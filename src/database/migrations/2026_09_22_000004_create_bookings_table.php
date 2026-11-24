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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('teknisi_id')->constrained('teknisi')->cascadeOnDelete();
            $table->dateTime('jadwal');
            $table->text('deskripsi_kerusakan')->nullable();
            $table->text('catatan_perbaikan')->nullable();
            $table->enum('status_order', [
                'pending_payment',
                'paid',
                'otw',
                'working',
                'completed',
                'cancelled'
            ])->default('pending_payment')->index();
            $table->decimal('total_biaya', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
