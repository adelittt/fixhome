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
        Schema::create('teknisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('keahlian')->nullable();
            $table->decimal('tarif_dasar', 12, 2)->default(0.00);
            $table->enum('status_kesiapan', ['ready', 'off'])->default('off')->index();
            $table->timestamp('off_start_date')->nullable();
            $table->integer('last_reminder_sent_day')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teknisi');
    }
};
