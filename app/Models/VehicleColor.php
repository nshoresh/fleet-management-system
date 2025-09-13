<?php

namespace App\Models;

use App\Observers\VehicleColorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(VehicleColorObserver::class)]
class VehicleColor extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
}
