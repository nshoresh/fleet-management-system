<?php

namespace App\Models;

use App\Observers\VehicleOwnerTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(VehicleOwnerTypeObserver::class)]

class VehicleOwnerType extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
    ];



    public function vehicle_owners(): HasMany
    {
        return $this->hasMany(VehicleOwner::class);
    }


    public function getVehicleOwnersCountAttribute()
    {
        return $this->vehicle_owners->count();
    }



    public function getVehicleOwnersCountFormattedAttribute()
    {
        return number_format($this->vehicle_owners_count);
    }
}
