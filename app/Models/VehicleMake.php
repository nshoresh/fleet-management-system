<?php

namespace App\Models;

use App\Observers\VehicleMakeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(VehicleMakeObserver::class)]

class VehicleMake extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'country',
        'description'
    ];

    public function models()
    {
        return $this->hasMany(VehicleMakeModel::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function getCountryAttribute($value)
    {
        return strtoupper($value);
    }

    public function setCountryAttribute($value)
    {
        return $this->attributes['country'] = strtoupper($value);
    }

    public function getVehiclesCountAttribute()
    {
        return $this->vehicles->count();
    }

    public function getModelsCountAttribute()
    {
        return $this->models->count();
    }

    public function getVehiclesCountFormattedAttribute()
    {
        return number_format($this->vehicles_count);
    }

    public function getModelsCountFormattedAttribute()
    {
        return number_format($this->models_count);
    }
}
