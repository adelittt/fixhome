<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teknisi', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('rating');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('no_ktp', 30)->nullable()->after('longitude');
            $table->string('sertifikasi')->nullable()->after('no_ktp');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('verified')->after('sertifikasi');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('jarak_km', 8, 2)->default(0.00)->after('status_order');
            $table->decimal('biaya_layanan', 12, 2)->default(0.00)->after('jarak_km');
            $table->decimal('biaya_jarak', 12, 2)->default(0.00)->after('biaya_layanan');
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('biaya_jarak', 12, 2)->default(0.00)->after('dana_teknisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('biaya_jarak');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['jarak_km', 'biaya_layanan', 'biaya_jarak']);
        });

        Schema::table('teknisi', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'no_ktp', 'sertifikasi', 'status_verifikasi']);
        });
    }
};
