<?php

namespace App\Observers;

use App\Models\LicenseApplication;

class LicenseApplicationObserver
{
    /**
     * Handle the LicenseApplication "created" event.
     */
    public function created(LicenseApplication $licenseApplication): void
    {
        //
    }

    /**
     * Handle the LicenseApplication "updated" event.
     */
    public function updated(LicenseApplication $licenseApplication): void
    {
        //
    }

    /**
     * Handle the LicenseApplication "deleted" event.
     */
    public function deleted(LicenseApplication $licenseApplication): void
    {
        //
    }

    /**
     * Handle the LicenseApplication "restored" event.
     */
    public function restored(LicenseApplication $licenseApplication): void
    {
        //
    }

    /**
     * Handle the LicenseApplication "force deleted" event.
     */
    public function forceDeleted(LicenseApplication $licenseApplication): void
    {
        //
    }
}
