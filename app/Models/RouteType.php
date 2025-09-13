<?php

namespace App\Models;

use App\Observers\RouteTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(RouteTypeObserver::class)]
class RouteType extends Model
{
    //protected $table = 'routeTypes'; // or the actual name
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'route_type_name',
        'description',
    ];

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }


    public function getRoutesCountAttribute()
    {
        return $this->routes->count();
    }


    public function getRoutesCountFormattedAttribute()
    {
        return number_format($this->routes_count);
    }
}
