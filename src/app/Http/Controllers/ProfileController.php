<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $customer = $user->customer;
        $teknisi = $user->teknisi;

        return view('pages.customer.profile', compact('user', 'customer', 'teknisi'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $isTeknisi = $user->isTeknisi() && $user->teknisi;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:25'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
            'remove_avatar' => ['nullable', 'boolean'],
            'new_password' => ['nullable', 'confirmed', Password::min(6)],
        ];

        if ($isTeknisi) {
            $rules['keahlian'] = ['required', 'string', 'max:255'];
            $rules['tarif_dasar'] = ['required', 'numeric', 'min:10000'];
            $rules['sertifikasi'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'avatar.image' => 'File foto profil harus berupa gambar (JPG, PNG, atau WebP).',
            'avatar.max' => 'Ukuran foto profil maksimal 3 MB.',
            'tarif_dasar.min' => 'Tarif dasar jasa minimal Rp 10.000.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'new_password.min' => 'Kata sandi baru minimal 6 karakter.',
        ]);

        $avatarDataUri = $user->avatar_url;

        if ($request->boolean('remove_avatar')) {
            $avatarDataUri = null;
        }

        if ($request->hasFile('avatar')) {
            $processed = $this->encodeSquareAvatar($request->file('avatar')->getRealPath());
            if (!$processed) {
                return back()->withErrors([
                    'avatar' => 'Gagal memproses gambar. Gunakan format JPG, PNG, atau WebP yang valid.',
                ])->withInput();
            }
            $avatarDataUri = $processed;
        }

        $userUpdate = [
            'name' => trim($validated['name']),
            'no_telepon' => $validated['no_telepon'] ? trim($validated['no_telepon']) : null,
            'avatar_url' => $avatarDataUri,
        ];

        if (!empty($validated['new_password'])) {
            $userUpdate['password'] = Hash::make($validated['new_password']);
        }

        $user->update($userUpdate);

        if ($user->customer) {
            $user->customer->update([
                'nama_lengkap' => trim($validated['name']),
            ]);
        }

        if ($isTeknisi) {
            $tekUpdate = [
                'nama_lengkap' => trim($validated['name']),
                'keahlian' => $validated['keahlian'],
                'tarif_dasar' => $validated['tarif_dasar'],
                'sertifikasi' => $validated['sertifikasi'] ?? null,
            ];

            if ($request->hasFile('avatar') || $request->boolean('remove_avatar')) {
                $tekUpdate['foto'] = $avatarDataUri;
            }

            $user->teknisi->update($tekUpdate);
        }

        return redirect()->route('customer.profile')
            ->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    /**
     * Re-encode uploaded image into a clean, EXIF-stripped 256x256 JPEG data URI
     * so avatars persist reliably across stateless Vercel serverless containers.
     */
    private function encodeSquareAvatar(string $filePath): ?string
    {
        $raw = @file_get_contents($filePath);
        if ($raw === false) {
            return null;
        }

        if (!function_exists('imagecreatefromstring')) {
            $mime = mime_content_type($filePath) ?: 'image/jpeg';
            return 'data:' . $mime . ';base64,' . base64_encode($raw);
        }

        $src = @imagecreatefromstring($raw);
        if (!$src) {
            return null;
        }

        $width = imagesx($src);
        $height = imagesy($src);
        $side = min($width, $height);
        $srcX = (int) floor(($width - $side) / 2);
        $srcY = (int) floor(($height - $side) / 2);

        $targetSize = 256;
        $dst = imagecreatetruecolor($targetSize, $targetSize);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $targetSize, $targetSize, $side, $side);

        ob_start();
        imagejpeg($dst, null, 82);
        $jpegBytes = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        if (!$jpegBytes) {
            return null;
        }

        return 'data:image/jpeg;base64,' . base64_encode($jpegBytes);
    }
}
