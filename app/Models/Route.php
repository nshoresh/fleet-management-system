<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RouteType;
use App\Observers\RouteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(RouteObserver::class)]
class Route extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'route_name',
        'route_type_id',
    ];

    /**
     * Get the region that owns the province.
     *
     */

    public function routeType(): BelongsTo
    {
        return $this->belongsTo(RouteType::class, 'route_type_id');
    }

        public function licenses()
    {
        return $this->hasMany(License::class);
    }
    
    /*public function route_type()
    {
        return $this->belongsTo(RouteType::class, 'route_type_id');
    }*/
}
