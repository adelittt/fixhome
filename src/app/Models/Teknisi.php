<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teknisi extends Model
{
    use HasFactory;

    protected $table = 'teknisi';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'keahlian',
        'tarif_dasar',
        'status_kesiapan',
        'off_start_date',
        'last_reminder_sent_day',
        'rating',
        'latitude',
        'longitude',
        'no_ktp',
        'sertifikasi',
        'status_verifikasi',
    ];

    protected $casts = [
        'tarif_dasar' => 'decimal:2',
        'rating' => 'decimal:2',
        'off_start_date' => 'datetime',
        'last_reminder_sent_day' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }

    public function scopeReady(Builder $query): Builder
    {
        return $query->where('status_kesiapan', 'ready');
    }

    public function scopeOff(Builder $query): Builder
    {
        return $query->where('status_kesiapan', 'off');
    }

    public function isReady(): bool
    {
        return $this->status_kesiapan === 'ready';
    }

    public function isOff(): bool
    {
        return $this->status_kesiapan === 'off';
    }

    /**
     * Hitung jumlah hari inaktif sejak off_start_date (BR-09, BR-10).
     */
    public function getInactiveDays(): int
    {
        if (!$this->off_start_date || $this->isReady()) {
            return 0;
        }

        return (int) $this->off_start_date->diffInDays(Carbon::now());
    }
}
