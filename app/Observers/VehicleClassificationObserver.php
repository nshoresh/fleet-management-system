<?php

namespace App\Observers;

use App\Models\VehicleClassification;

class VehicleClassificationObserver
{
    /**
     * Handle the VehicleClassification "created" event.
     */
    public function created(VehicleClassification $vehicleClassification): void
    {
        //
    }

    /**
     * Handle the VehicleClassification "updated" event.
     */
    public function updated(VehicleClassification $vehicleClassification): void
    {
        //
    }

    /**
     * Handle the VehicleClassification "deleted" event.
     */
    public function deleted(VehicleClassification $vehicleClassification): void
    {
        //
    }

    /**
     * Handle the VehicleClassification "restored" event.
     */
    public function restored(VehicleClassification $vehicleClassification): void
    {
        //
    }

    /**
     * Handle the VehicleClassification "force deleted" event.
     */
    public function forceDeleted(VehicleClassification $vehicleClassification): void
    {
        //
    }
}
