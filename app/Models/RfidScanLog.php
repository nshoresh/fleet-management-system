<?php

namespace App\Models;

use App\Observers\RfidScanLogObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(RfidScanLogObserver::class)]

class RfidScanLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'detected_at',
        'signal_strength',
        'direction',
        'scanner_location',
        'metadata'
    ];

    protected $casts = [
        'detected_at' => 'datetime',
        'metadata' => 'array'
    ];

    // Relationships
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function scanner(): BelongsTo
    {
        return $this->belongsTo(RfidScanner::class);
    }

    // Scopes
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('detected_at', [$start, $end]);
    }

    public function scopeForVehicle($query, $vehicleId)
    {
        return $query->whereHas('tag', function ($q) use ($vehicleId) {
            $q->where('vehicle_id', $vehicleId);
        });
    }

    // Helpers
    public function getSignalQualityAttribute(): string
    {
        return match (true) {
            $this->signal_strength >= -60 => 'Excellent',
            $this->signal_strength >= -70 => 'Good',
            $this->signal_strength >= -80 => 'Fair',
            default => 'Weak'
        };
    }
}
