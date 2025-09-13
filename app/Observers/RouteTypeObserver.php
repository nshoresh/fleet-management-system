<?php

namespace App\Observers;

use App\Models\RouteType;

class RouteTypeObserver
{
    /**
     * Handle the RouteType "created" event.
     */
    public function created(RouteType $routeType): void
    {
        //
    }

    /**
     * Handle the RouteType "updated" event.
     */
    public function updated(RouteType $routeType): void
    {
        //
    }

    /**
     * Handle the RouteType "deleted" event.
     */
    public function deleted(RouteType $routeType): void
    {
        //
    }

    /**
     * Handle the RouteType "restored" event.
     */
    public function restored(RouteType $routeType): void
    {
        //
    }

    /**
     * Handle the RouteType "force deleted" event.
     */
    public function forceDeleted(RouteType $routeType): void
    {
        //
    }
}
