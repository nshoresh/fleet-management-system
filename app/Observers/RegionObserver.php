<?php

namespace App\Observers;

use App\Models\Region;

class RegionObserver
{
    /**
     * Handle the Region "created" event.
     */
    public function created(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "updated" event.
     */
    public function updated(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "deleted" event.
     */
    public function deleted(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "restored" event.
     */
    public function restored(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "force deleted" event.
     */
    public function forceDeleted(Region $region): void
    {
        //
    }
}
