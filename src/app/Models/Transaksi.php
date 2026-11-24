<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'kode_transaksi',
        'gross_amount',
        'komisi_admin',
        'dana_teknisi',
        'biaya_jarak',
        'status_pembayaran',
        'payment_method',
        'payment_gateway_ref',
        'paid_at',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'komisi_admin' => 'decimal:2',
        'dana_teknisi' => 'decimal:2',
        'biaya_jarak' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function isPaid(): bool
    {
        return $this->status_pembayaran === 'paid';
    }

    /**
     * Hitung split saldo otomatis: 5% komisi admin, 95% dana teknisi (BR-04, BR-12).
     *
     * @param float $grossAmount
     * @return array{komisi_admin: float, dana_teknisi: float}
     */
    public static function calculateSplit(float $grossAmount): array
    {
        $komisiAdmin = round($grossAmount * 0.05, 2);
        $danaTeknisi = round($grossAmount - $komisiAdmin, 2);

        return [
            'komisi_admin' => $komisiAdmin,
            'dana_teknisi' => $danaTeknisi,
        ];
    }
}
