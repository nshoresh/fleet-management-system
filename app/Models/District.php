<?php

namespace App\Models;

use App\Observers\DistrictObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(DistrictObserver::class)]

class District extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'province_id',
    ];




    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function getDistrictsCountAttribute()
    {
        return $this->districts->count();
    }
}
