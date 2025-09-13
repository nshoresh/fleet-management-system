<?php

namespace App\Models;

use App\Observers\LicenseApplicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(LicenseApplicationObserver::class)]

class LicenseApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'license_type_id',
        'route_id',
        'application_number',
        'status',
        'submission_date',
        'expiry_date',
        'purpose',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'terms_accepted',
        'supporting_documents',
        'additional_information',
        'terms_accepted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submission_date' => 'date',
        'expiry_date' => 'date',
        'reviewed_at' => 'datetime',
        'terms_accepted' => 'boolean',
        'supporting_documents' => 'array',
        'additional_information' => 'array',
    ];

    /**
     * Get the user that owns the license application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Optional: define relationships
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    /**
     * Get the license type for this application.
     */
    public function licenseType(): BelongsTo
    {
        return $this->belongsTo(LicenseType::class);
    }
    /**
     * Get the route for this application.
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Get the route type for this application.
     */
    public function routeType()
    {
        return $this->belongsTo(RouteType::class);
    }

    /**
     * Get the user who reviewed this application.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include pending applications.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope a query to only include approved applications.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    /**
     * Scope a query to only include rejected applications.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    /**
     * Check if the application is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    /**
     * Check if the application is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'Approved';
    }

    /**
     * Check if the application has expired.
     */
    public function isExpired(): bool
    {
        return $this->status === 'Expired' ||
            ($this->isApproved() && $this->expiry_date && $this->expiry_date->isPast());
    }

    /**
     * Generate a unique application number.
     */
    public static function generateApplicationNumber(): string
    {
        $prefix = 'LA-';
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

        return $prefix . $year . '-' . $random;
    }
}
