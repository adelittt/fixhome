<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * Cast enkripsi AES-256-CBC (UU PDP Pasal 35 & 39) yang aman terhadap data legacy plaintext.
 * Setiap penyimpanan baru otomatis dienkripsi dengan APP_KEY; pembacaan data lama tetap berjalan normal.
 */
class SafeEncrypted implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            return Crypt::decryptString((string) $value);
        } catch (DecryptException) {
            return (string) $value;
        }
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $stringValue = (string) $value;

        // Hindari double-encrypt jika nilai sudah merupakan payload Laravel Crypt yang valid
        try {
            Crypt::decryptString($stringValue);
            return $stringValue;
        } catch (DecryptException) {
            return Crypt::encryptString($stringValue);
        }
    }
}
