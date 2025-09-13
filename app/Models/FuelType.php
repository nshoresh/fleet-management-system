<?php

namespace App\Models;

use App\Observers\FuelTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(FuelTypeObserver::class)]

class FuelType extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['name'];



    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }
}
