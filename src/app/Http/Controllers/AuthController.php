<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showSplash()
    {
        return view('pages.splash');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
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
            'auth' => 'Alamat email atau kata sandi yang Anda masukkan salah. Silakan periksa kembali.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:customer,teknisi'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'keahlian' => ['nullable', 'string', 'max:255'],
            'tarif_dasar' => ['required_if:role,teknisi', 'nullable', 'numeric', 'min:10000'],
            'no_ktp' => ['nullable', 'string', 'max:30'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
        ], [
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

    public function quickLogin(string $email, Request $request)
    {
        $user = User::where('email', $email)->firstOrFail();
        Auth::login($user);
        $request->session()->regenerate();

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
