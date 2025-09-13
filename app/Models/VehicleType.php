<?php

namespace App\Models;

use App\Observers\VehicleTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(VehicleTypeObserver::class)]
class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
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


    public function getVehiclesCountFormattedShortAttribute()
    {
        return number_format($this->vehicles_count);
    }
}
