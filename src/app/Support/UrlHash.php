<?php

namespace App\Support;

use Illuminate\Support\Facades\Config;

/**
 * Menghasilkan token hash URL yang ringkas (24 karakter hex), deterministik, dan terotentikasi HMAC-SHA256
 * untuk menyembunyikan ID numerik & mencegah enumerasi / IDOR pada URL sensitif.
 */
class UrlHash
{
    public static function encode(int|string $id, string $scope = 'fh'): string
    {
        $numericId = (int) $id;
        if ($numericId <= 0) {
            return (string) $id;
        }

        $key = self::deriveKey($scope);
        // Pack 64-bit big-endian integer (8 bytes)
        $plain = pack('J', $numericId);
        // XOR obfuscation menggunakan stream dari HMAC(scope, key)
        $mask = substr(hash_hmac('sha256', "mask:{$scope}", $key, true), 0, 8);
        $cipher = $plain ^ $mask;
        // 4-byte (32-bit) HMAC authentication tag agar tidak bisa dimanipulasi
        $tag = substr(hash_hmac('sha256', $scope . ':' . $cipher, $key, true), 0, 4);

        return bin2hex($cipher . $tag); // 12 bytes = 24 hex chars
    }

    public static function decode(string $token, string $scope = 'fh'): int
    {
        if (!preg_match('/^[0-9a-f]{24}$/i', $token)) {
            abort(404);
        }

        $raw = hex2bin(strtolower($token));
        if ($raw === false || strlen($raw) !== 12) {
            abort(404);
        }

        $cipher = substr($raw, 0, 8);
        $tag = substr($raw, 8, 4);
        $key = self::deriveKey($scope);

        $expectedTag = substr(hash_hmac('sha256', $scope . ':' . $cipher, $key, true), 0, 4);
        if (!hash_equals($expectedTag, $tag)) {
            abort(404);
        }

        $mask = substr(hash_hmac('sha256', "mask:{$scope}", $key, true), 0, 8);
        $plain = $cipher ^ $mask;
        $unpacked = unpack('J', $plain);
        $id = (int) ($unpacked[1] ?? 0);

        if ($id <= 0) {
            abort(404);
        }

        return $id;
    }

    private static function deriveKey(string $scope): string
    {
        $appKey = (string) Config::get('app.key', 'fixhome-fallback-key');
        return hash_hmac('sha256', "urlhash:{$scope}", $appKey, true);
    }
}
