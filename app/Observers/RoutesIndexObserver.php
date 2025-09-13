<?php

namespace App\Observers;

use App\Models\RoutesIndex;

class RoutesIndexObserver
{
    /**
     * Handle the RoutesIndex "created" event.
     */
    public function created(RoutesIndex $routesIndex): void
    {
        //
    }

    /**
     * Handle the RoutesIndex "updated" event.
     */
    public function updated(RoutesIndex $routesIndex): void
    {
        //
    }

    /**
     * Handle the RoutesIndex "deleted" event.
     */
    public function deleted(RoutesIndex $routesIndex): void
    {
        //
    }

    /**
     * Handle the RoutesIndex "restored" event.
     */
    public function restored(RoutesIndex $routesIndex): void
    {
        //
    }

    /**
     * Handle the RoutesIndex "force deleted" event.
     */
    public function forceDeleted(RoutesIndex $routesIndex): void
    {
        //
    }
}
