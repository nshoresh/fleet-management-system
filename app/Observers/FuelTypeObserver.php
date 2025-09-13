<?php

namespace App\Observers;

use App\Models\FuelType;

class FuelTypeObserver
{
    /**
     * Handle the FuelType "created" event.
     */
    public function created(FuelType $fuelType): void
    {
        //
    }

    /**
     * Handle the FuelType "updated" event.
     */
    public function updated(FuelType $fuelType): void
    {
        //
    }

    /**
     * Handle the FuelType "deleted" event.
     */
    public function deleted(FuelType $fuelType): void
    {
        //
    }

    /**
     * Handle the FuelType "restored" event.
     */
    public function restored(FuelType $fuelType): void
    {
        //
    }

    /**
     * Handle the FuelType "force deleted" event.
     */
    public function forceDeleted(FuelType $fuelType): void
    {
        //
    }
}
