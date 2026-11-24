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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('komisi_admin', 12, 2); // 5% komisi admin (BR-04, BR-12)
            $table->decimal('dana_teknisi', 12, 2); // 95% dana teknisi (BR-04)
            $table->enum('status_pembayaran', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid')->index();
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway_ref')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
