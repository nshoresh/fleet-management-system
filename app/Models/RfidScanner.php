<?php

namespace App\Models;

use App\Observers\RfidScannerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(RfidScannerObserver::class)]

class RfidScanner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rf_id_scanners';
    protected $fillable = [
        'serial_number',
        'model',
        'manufacturer',
        'location',
        'ip_address',
        'mac_address',
        'firmware_version',
        'is_active',
        'settings',
        'last_online_at',
        'last_maintenance_at',
        'notes'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'last_online_at' => 'datetime',
        'last_maintenance_at' => 'datetime'
    ];

    // public function tags(): HasMany
    // {
    //     return $this->hasMany(RfIdTag::class, 'last_scanner_id');
    // }

    public function isOnline(): bool
    {
        return $this->last_online_at
            && $this->last_online_at->gt(now()
                ->subMinutes(5));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
