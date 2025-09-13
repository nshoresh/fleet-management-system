<?php

namespace App\Observers;

use App\Models\LicensePurpose;

class LicensePurposeObserver
{
    /**
     * Handle the LicensePurpose "created" event.
     */
    public function created(LicensePurpose $licensePurpose): void
    {
        //
    }

    /**
     * Handle the LicensePurpose "updated" event.
     */
    public function updated(LicensePurpose $licensePurpose): void
    {
        //
    }

    /**
     * Handle the LicensePurpose "deleted" event.
     */
    public function deleted(LicensePurpose $licensePurpose): void
    {
        //
    }

    /**
     * Handle the LicensePurpose "restored" event.
     */
    public function restored(LicensePurpose $licensePurpose): void
    {
        //
    }

    /**
     * Handle the LicensePurpose "force deleted" event.
     */
    public function forceDeleted(LicensePurpose $licensePurpose): void
    {
        //
    }
}
