<?php

namespace App\Models;

use App\Observers\LicenseRenewalApplicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(LicenseRenewalApplicationObserver::class)]

class LicenseRenewalApplication extends Model
{
    use HasFactory;

    protected $table = 'license_renewal_applications';
    protected $fillable = [
        'license_id',
        'application_number',
        'vehicle_owners_id',
        'vehicle_id',
        'license_type_id',
        'license_purpose_id',
        'route_id',
        'requested_start_date',
        'requested_end_date',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'requested_start_date' => 'date',
        'requested_end_date' => 'date',
    ];

    // Generate unique application number when creating a new record
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (!$application->application_number) {
                $application->application_number = 'REN-' . date('Ymd') . '-' . sprintf('%04d', static::whereDate('created_at', today())->count() + 1);
            }
        });
    }

    // Relationships
    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function vehicleOwner()
    {
        return $this->belongsTo(VehicleOwner::class, 'vehicle_owners_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class);
    }

    public function licensePurpose()
    {
        return $this->belongsTo(LicensePurpose::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Status check methods
    public function isPending()
    {
        return $this->status === 'Pending';
    }

    public function isApproved()
    {
        return $this->status === 'Approved';
    }

    public function isRejected()
    {
        return $this->status === 'Rejected';
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereDate('requested_end_date', '<=', now()->addDays($days))
            ->whereDate('requested_end_date', '>=', now());
    }
}
