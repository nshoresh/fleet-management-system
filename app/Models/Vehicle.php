<?php

namespace App\Models;

use App\Observers\VehicleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\License;

#[ObservedBy(VehicleObserver::class)]
class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [

        'year',
        'vin',
        'color',
        'license_plate',
        'engine_type',
        'mileage',
        'registration_date',
        'status',
        'vehicle_make_id',
        'vehicle_model_id',
        'vehicle_owner_id',
        'vehicle_type_id',
        'vehicle_classification_id',
        'transmission_type',
        'fuel_type',
        'seating_capacity',
        'vehicle_condition',
        'additional_features',
        'insurance_status',
        'last_service_date',
        'gross_vehicle_weight',
        'vehicle_tare_weight',
        'gross_trailer_weight',
        'trailer_tare_weight',
        'payload_capacity',
        'tire_capacity',
        'axle_configuration',
        'number_of_axles',
        'engine_power',
        'torque',
        'uuid',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'last_service_date' => 'date',
    ];

    public function license()
    {
        return $this->hasOne(License::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function vehicleOwner()
    {
        return $this->belongsTo(VehicleOwner::class, 'vehicle_owner_id');
    }
    public function classification(): BelongsTo
    {
        return $this->belongsTo(
            VehicleClassification::class,
            'vehicle_classification_id'
        );
    }

    public function make(): BelongsTo
    {
        return $this->belongsTo(
            VehicleMake::class,
            'vehicle_make_id'
        );
    }

    public function makeModel(): BelongsTo
    {
        return $this->belongsTo(
            VehicleMakeModel::class,
            'vehicle_model_id'
        );
    }

    public function makeOwner(): BelongsTo
    {
        return $this->belongsTo(
            VehicleOwner::class,
            'vehicle_owner_id'
        );
    }

    public function makeType(): BelongsTo
    {
        return $this->belongsTo(
            VehicleType::class,
            'vehicle_type_id'
        );
    }

    /**
     * Generate a unique VIN if not provided
     *
     * @return string
     */
    public static function generateUniqueVin(): string
    {
        do {
            $vin = strtoupper(
                substr(md5(uniqid()), 0, 17)
            );
        } while (self::where(
            'vin',
            $vin
        )->exists());

        return $vin;
    }

    // Generate Unique uuid()
    public static function generateUniqueUuid(): string
    {
        do {
            $uuid = strtoupper(substr(md5(uniqid()), 0, 50));
            $exists = self::where('uuid', $uuid)->exists();
        } while ($exists);

        return $uuid;
    }

    /**
     * Calculate and set the payload capacity
     */
    protected function calculatePayloadCapacity(): void
    {
        if (is_numeric($this->gross_vehicle_weight) && is_numeric($this->vehicle_tare_weight)) {
            $this->payload_capacity = $this->gross_vehicle_weight - $this->vehicle_tare_weight;
        } elseif (is_numeric($this->gross_trailer_weight) && is_numeric($this->trailer_tare_weight)) {

            $this->payload_capacity = $this->gross_trailer_weight - $this->trailer_tare_weight;
        } else {
            $this->payload_capacity = null;
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vehicle) {
            if (empty($vehicle->uuid)) {
                $vehicle->uuid = self::generateUniqueUuid();
            }
            $vehicle->calculatePayloadCapacity();
        });

        static::updating(function ($vehicle) {
            $vehicle->calculatePayloadCapacity();
        });
    }
}
