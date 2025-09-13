<?php

namespace App\Observers;

use App\Models\VehicleType;

class VehicleTypeObserver
{
    /**
     * Handle the VehicleType "created" event.
     */
    public function created(VehicleType $vehicleType): void
    {
        //
    }

    /**
     * Handle the VehicleType "updated" event.
     */
    public function updated(VehicleType $vehicleType): void
    {
        //
    }

    /**
     * Handle the VehicleType "deleted" event.
     */
    public function deleted(VehicleType $vehicleType): void
    {
        //
    }

    /**
     * Handle the VehicleType "restored" event.
     */
    public function restored(VehicleType $vehicleType): void
    {
        //
    }

    /**
     * Handle the VehicleType "force deleted" event.
     */
    public function forceDeleted(VehicleType $vehicleType): void
    {
        //
    }
}
