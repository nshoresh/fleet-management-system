<?php

namespace App\Observers;

use App\Models\LicenseType;

class LicenseTypeObserver
{
    /**
     * Handle the LicenseType "created" event.
     */
    public function created(LicenseType $licenseType): void
    {
        //
    }

    /**
     * Handle the LicenseType "updated" event.
     */
    public function updated(LicenseType $licenseType): void
    {
        //
    }

    /**
     * Handle the LicenseType "deleted" event.
     */
    public function deleted(LicenseType $licenseType): void
    {
        //
    }

    /**
     * Handle the LicenseType "restored" event.
     */
    public function restored(LicenseType $licenseType): void
    {
        //
    }

    /**
     * Handle the LicenseType "force deleted" event.
     */
    public function forceDeleted(LicenseType $licenseType): void
    {
        //
    }
}
