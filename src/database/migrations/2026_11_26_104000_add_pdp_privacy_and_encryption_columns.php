<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE users ADD COLUMN IF NOT EXISTS privacy_consent_at TIMESTAMP NULL');
            DB::statement('ALTER TABLE users ALTER COLUMN no_telepon TYPE TEXT');
            DB::statement('ALTER TABLE customers ALTER COLUMN alamat_lengkap TYPE TEXT');
            DB::statement('ALTER TABLE teknisi ALTER COLUMN no_ktp TYPE TEXT');
            return;
        }

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
