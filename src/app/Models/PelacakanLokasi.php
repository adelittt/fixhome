<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PelacakanLokasi extends Model
{
    use HasFactory;

    protected $table = 'pelacakan_lokasis';

    protected $fillable = [
        'booking_id',
        'current_lat',
        'current_lng',
        'is_active',
    ];

    protected $casts = [
        'current_lat' => 'decimal:8',
        'current_lng' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
