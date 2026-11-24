<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'teknisi_id',
        'jadwal',
        'deskripsi_kerusakan',
        'catatan_perbaikan',
        'status_order',
        'jarak_km',
        'biaya_layanan',
        'biaya_jarak',
        'total_biaya',
    ];

    protected $casts = [
        'jadwal' => 'datetime',
        'jarak_km' => 'decimal:2',
        'biaya_layanan' => 'decimal:2',
        'biaya_jarak' => 'decimal:2',
        'total_biaya' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(Teknisi::class);
    }

    public function transaksi(): HasOne
    {
        return $this->hasOne(Transaksi::class);
    }

    public function pelacakanLokasis(): HasMany
    {
        return $this->hasMany(PelacakanLokasi::class);
    }

    public function latestPelacakan(): HasOne
    {
        return $this->hasOne(PelacakanLokasi::class)->latestOfMany();
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function ulasan(): HasOne
    {
        return $this->hasOne(Ulasan::class);
    }

    /**
     * Memeriksa apakah fitur chat diizinkan (BR-03: Chat aktif setelah pembayaran berhasil).
     */
    public function canChat(): bool
    {
        return in_array($this->status_order, ['paid', 'otw', 'working', 'completed']) ||
            ($this->transaksi && $this->transaksi->isPaid());
    }

    /**
     * Memeriksa apakah pelacakan GPS diizinkan (BR-05, BR-06, BR-08).
     * Aktif setelah pembayaran berhasil diverifikasi hingga pekerjaan selesai.
     */
    public function canTrack(): bool
    {
        return in_array($this->status_order, ['paid', 'otw', 'working', 'completed']) ||
            ($this->transaksi && $this->transaksi->isPaid());
    }
}
