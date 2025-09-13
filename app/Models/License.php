<?php

namespace App\Models;

use App\Observers\LicenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(LicenseObserver::class)]

class License extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_owners_id',
        'vehicle_id',
        'registration_number',
        'license_type_id',
        'license_purpose_id',
        'route_id',
        'license_start_date',
        'license_end_date',
        'license_status',
        //'license_application_id',
    ];

    protected $casts = [
        'license_start_date' => 'date',
        'license_end_date' => 'date',
    ];

    // Relationships
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
}
