<?php

namespace App\Observers;

use App\Models\VehicleDocument;

class VehicleDocumentObserver
{
    /**
     * Handle the VehicleDocument "created" event.
     */
    public function created(VehicleDocument $vehicleDocument): void
    {
        //
    }

    /**
     * Handle the VehicleDocument "updated" event.
     */
    public function updated(VehicleDocument $vehicleDocument): void
    {
        //
    }

    /**
     * Handle the VehicleDocument "deleted" event.
     */
    public function deleted(VehicleDocument $vehicleDocument): void
    {
        //
    }

    /**
     * Handle the VehicleDocument "restored" event.
     */
    public function restored(VehicleDocument $vehicleDocument): void
    {
        //
    }

    /**
     * Handle the VehicleDocument "force deleted" event.
     */
    public function forceDeleted(VehicleDocument $vehicleDocument): void
    {
        //
    }
}
