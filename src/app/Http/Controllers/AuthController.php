<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    private function isGoogleOAuthEnabled(): bool
    {
        return config('services.google.client_id') !== ''
            && config('services.google.client_secret') !== '';
    }

    public function showSplash()
    {
        return view('pages.splash');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('pages.auth.login', [
            'googleOAuthEnabled' => $this->isGoogleOAuthEnabled(),
        ]);
    }

    public function login(Request $request)
    {
        if ($this->isGoogleOAuthEnabled()) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan masuk menggunakan tombol "Lanjutkan dengan Google" di bawah ini.',
            ]);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email', 'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/i'],
            'password' => ['required'],
        ], [
            'email.required' => 'Alamat Gmail wajib diisi.',
            'email.email' => 'Format alamat Gmail tidak valid.',
            'email.regex' => 'Hanya akun Google (@gmail.com) yang diperbolehkan. Akun dummy tidak diizinkan.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'auth' => 'Akun Administrator menggunakan halaman login terpisah. Silakan masuk melalui /admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'auth' => 'Alamat Gmail atau kata sandi salah. Pastikan Anda sudah mendaftar dengan akun Google (@gmail.com).',
        ])->onlyInput('email');
    }

    public function redirectToGoogle(Request $request)
    {
        if (!$this->isGoogleOAuthEnabled()) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Login Google OAuth belum dikonfigurasi (GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET). Untuk sementara masuk menggunakan akun @gmail.com Anda.',
            ]);
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);
        $request->session()->put('google_oauth_role', $request->query('role') === 'teknisi' ? 'teknisi' : 'customer');

        $redirectUri = config('services.google.redirect') ?: route('auth.google.callback');

        $query = http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
            'access_type' => 'online',
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$this->isGoogleOAuthEnabled()) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Login Google OAuth belum dikonfigurasi.',
            ]);
        }

        $expectedState = (string) $request->session()->pull('google_oauth_state', '');
        $incomingState = (string) $request->query('state', '');
        if ($expectedState === '' || !hash_equals($expectedState, $incomingState)) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Sesi autentikasi Google tidak valid atau kedaluwarsa. Silakan coba masuk lagi.',
            ]);
        }

        $code = (string) $request->query('code', '');
        if ($code === '') {
            return redirect()->route('login')->withErrors([
                'auth' => 'Login Google dibatalkan.',
            ]);
        }

        try {
            $redirectUri = config('services.google.redirect') ?: route('auth.google.callback');

            $tokenRes = Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
            ]);

            if (!$tokenRes->successful()) {
                Log::warning('Google OAuth token exchange failed', ['status' => $tokenRes->status(), 'body' => $tokenRes->body()]);
                return redirect()->route('login')->withErrors([
                    'auth' => 'Gagal memverifikasi akun Google. Silakan coba lagi.',
                ]);
            }

            $accessToken = (string) $tokenRes->json('access_token', '');
            $profileRes = Http::withToken($accessToken)->timeout(15)->get('https://openidconnect.googleapis.com/v1/userinfo');

            if (!$profileRes->successful()) {
                return redirect()->route('login')->withErrors([
                    'auth' => 'Gagal mengambil profil akun Google.',
                ]);
            }

            $googleEmail = strtolower(trim((string) $profileRes->json('email', '')));
            $emailVerified = (bool) $profileRes->json('email_verified', false);
            $googleName = trim((string) $profileRes->json('name', '')) ?: Str::before($googleEmail, '@');

            if ($googleEmail === '' || !$emailVerified) {
                return redirect()->route('login')->withErrors([
                    'auth' => 'Akun Google Anda harus memiliki email terverifikasi.',
                ]);
            }

            $user = User::where('email', $googleEmail)->first();

            if ($user && $user->isAdmin()) {
                return redirect()->route('login')->withErrors([
                    'auth' => 'Akun Administrator menggunakan halaman login terpisah di /admin.',
                ]);
            }

            if (!$user) {
                $user = User::create([
                    'name' => $googleName,
                    'email' => $googleEmail,
                    'no_telepon' => null,
                    'role' => 'customer',
                    'password' => Hash::make(Str::random(32)),
                    'email_verified_at' => now(),
                ]);
                $user->assignRole('customer');

                Customer::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->name,
                    'is_address_completed' => false,
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user);
        } catch (\Throwable $e) {
            Log::error('Google OAuth callback error', ['error' => $e->getMessage()]);
            return redirect()->route('login')->withErrors([
                'auth' => 'Terjadi kendala saat login dengan Google. Silakan coba lagi.',
            ]);
        }
    }

    public function showRegister()
    {
        return view('pages.auth.register', [
            'googleOAuthEnabled' => $this->isGoogleOAuthEnabled(),
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/i', 'unique:users'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:customer,teknisi'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'keahlian' => ['nullable', 'string', 'max:255'],
            'tarif_dasar' => ['required_if:role,teknisi', 'nullable', 'numeric', 'min:10000'],
            'no_ktp' => ['nullable', 'string', 'max:30'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
        ], [
            'email.regex' => 'Hanya alamat Gmail (@gmail.com) yang diperbolehkan untuk mendaftar.',
            'tarif_dasar.required_if' => 'Tarif dasar jasa wajib diisi untuk Mitra Teknisi.',
            'tarif_dasar.min' => 'Tarif dasar jasa minimal Rp 10.000 (tidak boleh Rp 0).',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        if ($validated['role'] === 'customer') {
            Customer::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'is_address_completed' => false,
            ]);
        } else {
            Teknisi::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'keahlian' => $validated['keahlian'] ?? 'Servis Umum',
                'tarif_dasar' => $validated['tarif_dasar'] ?? 75000,
                'status_kesiapan' => 'off',
                'rating' => 5.0,
                'no_ktp' => $validated['no_ktp'] ?? null,
                'sertifikasi' => $validated['sertifikasi'] ?? null,
                'status_verifikasi' => 'pending',
                'latitude' => -6.2155,
                'longitude' => 106.8205,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($validated['role'] === 'teknisi') {
            return redirect()->route('teknisi.dashboard')
                ->with('success', 'Pendaftaran berhasil! Akun Mitra Teknisi Anda sedang menunggu konfirmasi verifikasi dari Admin FixHome.');
        }

        return $this->redirectBasedOnRole($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('splash');
    }

    protected function redirectBasedOnRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        if ($user->isTeknisi()) {
            return redirect()->route('teknisi.dashboard');
        }

        // Customer: jika belum melengkapi alamat, arahkan ke set-address (BR-01)
        $customer = $user->customer;
        if ($customer && !$customer->is_address_completed) {
            return redirect()->route('customer.set-address');
        }

        return redirect()->route('customer.home');
    }
}
