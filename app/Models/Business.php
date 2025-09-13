<?php

namespace App\Models;

use App\Observers\BusinessObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[ObservedBy(BusinessObserver::class)]

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'type',
        'phone',
        'email',
        'address',
        'registration_number',
        'registration_date',
        'status',
        'verification_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'registration_date' => 'date',
    ];

    /**
     * Boot the model.
     */


    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Scope a query to only include verified businesses.
     */
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    /**
     * Scope a query to only include approved businesses.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include active businesses (approved and verified).
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
            ->where('verification_status', 'verified');
    }

    /**
     * Check if the business is verified.
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    /**
     * Check if the business is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the business is active (approved and verified).
     */
    public function isActive(): bool
    {
        return $this->isApproved() && $this->isVerified();
    }
}
