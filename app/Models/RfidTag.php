<?php

namespace App\Models;

use App\Observers\RfidTagObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(RfidTagObserver::class)]

class RfidTag extends Model
{
    protected $fillable = [
        'tag_uid',
        'tag_type',
        'frequency_range',
        'is_active',
        'status',
        'vehicle_id',
        'license_id',
        'assigned_to_user_id',
        'issue_date',
        'expiry_date',
        'notes',
        'last_scanner_id',
        'last_scanned_at',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'last_scanned_at' => 'datetime',
        'metadata' => 'array',

    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function lastScanner(): BelongsTo
    {
        return $this->belongsTo(RfidScanner::class, 'last_scanner_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Helpers
    public function isExpired(): bool
    {
        return $this->expiry_date
            && $this->expiry_date->isPast();
    }

    public function markAs(string $status): void
    {
        $this->update(['status' => $status]);
    }
}
