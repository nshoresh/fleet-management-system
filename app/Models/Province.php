<?php

namespace App\Models;

use App\Observers\ProvinceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ProvinceObserver::class)]

class Province extends Model
{
    use HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'region_id',
    ];

    /**
     * Get the region that owns the province.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function districts()
    {
        return $this->hasMany(District::class);
    }


    public function getDistrictsCountAttribute()
    {
        return $this->districts->count();
    }


    public function getDistrictsCountFormattedAttribute()
    {
        return number_format($this->districts_count);
    }
}
