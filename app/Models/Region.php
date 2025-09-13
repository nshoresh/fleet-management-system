<?php

namespace App\Models;

use App\Observers\RegionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(RegionObserver::class)]

class Region extends Model
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
    ];

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }


    public function getProvincesCountAttribute()
    {
        return $this->provinces->count();
    }


    public function getProvincesCountFormattedAttribute()
    {
        return number_format($this->provinces_count);
    }
}
