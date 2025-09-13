<?php

namespace App\Models;

use App\Observers\VehicleMakeModelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(VehicleMakeModelObserver::class)]

class VehicleMakeModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_make_id',
        'name',
        'year',
        'body_type',
        'description',
    ];

    // Relationships


    public function vehicleMake(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }


    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function getVehiclesCountAttribute()
    {
        return $this->vehicles->count();
    }

    public function getVehiclesCountFormattedAttribute()
    {
        return number_format($this->vehicles_count);
    }

    public function getMakeNameAttribute()
    {
        return $this->vehicleMake->name;
    }

    public function getMakeCountryAttribute()
    {
        return $this->vehicleMake->country;
    }

    public function getMakeDescriptionAttribute()
    {
        return $this->vehicleMake->description;
    }

    public function getMakeVehiclesCountAttribute()
    {
        return $this->vehicleMake->vehicles_count;
    }

    public function getMakeModelsCountAttribute()
    {
        return $this->vehicleMake->models_count;
    }

    public function getMakeVehiclesCountFormattedAttribute()
    {
        return $this->vehicleMake->vehicles_count_formatted;
    }

    public function getMakeModelsCountFormattedAttribute()
    {
        return $this->vehicleMake->models_count_formatted;
    }


    public function getMakeCountryFormattedAttribute()
    {
        return strtoupper($this->vehicleMake->country);
    }


    public function getVehiclesCountPercentageAttribute()
    {
        return round(($this->vehicles_count / $this->vehicleMake->vehicles_count) * 100, 1);
    }

    public function getMakeVehiclesCountPercentageAttribute()
    {
        return round(($this->vehicleMake->vehicles_count / $this->vehicleMake->vehicles_count) * 100, 1);
    }


    public function getVehiclesCountPercentageFormattedAttribute()
    {
        return number_format($this->vehicles_count_percentage, 1);
    }


    public function getMakeVehiclesCountPercentageFormattedAttribute()
    {
        return number_format($this->make_vehicles_count_percentage, 1);
    }

    public function getVehiclesCountPercentageRoundedAttribute()
    {
        return round($this->vehicles_count_percentage);
    }


    public function getMakeVehiclesCountPercentageRoundedAttribute()
    {
        return round($this->make_vehicles_count_percentage);
    }
}
