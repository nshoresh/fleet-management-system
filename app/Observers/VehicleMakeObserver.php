<?php

namespace App\Observers;

use App\Models\VehicleMake;

class VehicleMakeObserver
{
    /**
     * Handle the VehicleMake "created" event.
     */
    public function created(VehicleMake $vehicleMake): void
    {
        //
    }

    /**
     * Handle the VehicleMake "updated" event.
     */
    public function updated(VehicleMake $vehicleMake): void
    {
        //
    }

    /**
     * Handle the VehicleMake "deleted" event.
     */
    public function deleted(VehicleMake $vehicleMake): void
    {
        //
    }

    /**
     * Handle the VehicleMake "restored" event.
     */
    public function restored(VehicleMake $vehicleMake): void
    {
        //
    }

    /**
     * Handle the VehicleMake "force deleted" event.
     */
    public function forceDeleted(VehicleMake $vehicleMake): void
    {
        //
    }
}
