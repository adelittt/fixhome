<?php

namespace App\Models;

use App\Casts\SafeEncrypted;
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
        'foto',
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

    protected $appends = [
        'foto_url',
    ];

    public function getFotoUrlAttribute(): string
    {
        if (!empty($this->foto)) {
            if (
                str_starts_with($this->foto, 'data:image/')
                || str_starts_with($this->foto, 'http://')
                || str_starts_with($this->foto, 'https://')
            ) {
                return $this->foto;
            }

            return asset(ltrim($this->foto, '/'));
        }

        $index = ((max(1, (int) ($this->id ?? 1)) - 1) % 10) + 1;

        return asset("images/technicians/teknisi-{$index}.jpg");
    }

    protected $hidden = [
        'no_ktp',
    ];

    protected $casts = [
        'no_ktp' => SafeEncrypted::class,
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

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('status_verifikasi', 'verified');
    }

    public function scopeReady(Builder $query): Builder
    {
        return $query->where('status_kesiapan', 'ready')
            ->where('status_verifikasi', 'verified');
    }

    public function scopeOff(Builder $query): Builder
    {
        return $query->where('status_kesiapan', 'off');
    }

    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'verified';
    }

    public function isPendingVerification(): bool
    {
        return $this->status_verifikasi === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status_verifikasi === 'rejected';
    }

    public function isReady(): bool
    {
        return $this->status_kesiapan === 'ready' && $this->isVerified();
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
