<?php

namespace App\Observers;

use App\Models\VehicleOwnerType;

class VehicleOwnerTypeObserver
{
    /**
     * Handle the VehicleOwnerType "created" event.
     */
    public function created(VehicleOwnerType $vehicleOwnerType): void
    {
        //
    }

    /**
     * Handle the VehicleOwnerType "updated" event.
     */
    public function updated(VehicleOwnerType $vehicleOwnerType): void
    {
        //
    }

    /**
     * Handle the VehicleOwnerType "deleted" event.
     */
    public function deleted(VehicleOwnerType $vehicleOwnerType): void
    {
        //
    }

    /**
     * Handle the VehicleOwnerType "restored" event.
     */
    public function restored(VehicleOwnerType $vehicleOwnerType): void
    {
        //
    }

    /**
     * Handle the VehicleOwnerType "force deleted" event.
     */
    public function forceDeleted(VehicleOwnerType $vehicleOwnerType): void
    {
        //
    }
}
