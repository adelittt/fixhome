<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom pencatatan waktu persetujuan UU PDP (Pasal 20) & perlebar no_telepon untuk ciphertext AES-256
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'privacy_consent_at')) {
                $table->timestamp('privacy_consent_at')->nullable()->after('email_verified_at');
            }
            $table->text('no_telepon')->nullable()->change();
        });

        // 2. Pastikan alamat_lengkap bertipe text untuk menampung ciphertext AES-256
        Schema::table('customers', function (Blueprint $table) {
            $table->text('alamat_lengkap')->nullable()->change();
        });

        // 3. Perlebar no_ktp mitra teknisi menjadi text untuk menampung ciphertext AES-256
        Schema::table('teknisi', function (Blueprint $table) {
            $table->text('no_ktp')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'privacy_consent_at')) {
                $table->dropColumn('privacy_consent_at');
            }
        });
    }
};
