<?php

namespace App\Models;

use App\Observers\VehicleObserver;
use App\Observers\VehicleOwnerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[ObservedBy(VehicleOwnerObserver::class)]
class VehicleOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'email',
        'address',
        'vehicle_owner_type_id',
        'business_name',
        'business_phone',
        'business_email',
        'business_address',
        'business_registration_number',
        'business_type',
        'business_tax_id',
        'business_website',
        'business_logo',
        'business_contact_person',
        'business_contact_number',
        'id_number',
        'id_type',
        'position',
        'business_registration_date',
        'is_information_verified',
        'is_documents_verified',
        'status'
    ];

    protected $casts = [
        'business_registration_date' => 'date',
        'is_information_verified' => 'boolean',
        'is_documents_verified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'is_information_verified' => false,
        'is_documents_verified' => false,
        'status' => 'active',
    ];
    protected $appends = [
        'vehicles_count',
        'usercount',
        'fleets_count',
        'fleets_count_formatted',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
    /**
     * Generate a unique UUID for the vehicle owner.
     *
     * @return string
     */



    public function vehicle_owner_type(): BelongsTo
    {
        return $this->belongsTo(VehicleOwnerType::class);
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'vehicle_owner_id');
    }

    public function fleets(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'vehicle_owner_id');
    }

    public function getVehiclesCountAttribute()
    {
        return $this->vehicles->count();
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'vehicle_owner_id');
    }

    public function getUsercountAttribute()
    {
        return $this->users->count() ?? 0;
    }

    public function getFleetsCountAttribute()
    {
        return $this->fleets->count() ?? 0;
    }


    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'vehicle_owner_id');
    }
    public function getFleetsCountFormattedAttribute()
    {
        return number_format($this->fleets_count) ?? 0;
    }

    // Is Verified
    public function isVerified(): bool
    {
        return $this->is_information_verified;
    }
    // Is Documents Verified
    public function isDocumentsVerified(): bool
    {
        return $this->is_documents_verified;
    }
    // Is Active
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
    // Is Inactive
    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }
}
