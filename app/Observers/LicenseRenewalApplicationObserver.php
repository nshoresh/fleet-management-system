<?php

namespace App\Observers;

use App\Models\LicenseRenewalApplication;

class LicenseRenewalApplicationObserver
{
    /**
     * Handle the LicenseRenewalApplication "created" event.
     */
    public function created(LicenseRenewalApplication $licenseRenewalApplication): void
    {
        //
    }

    /**
     * Handle the LicenseRenewalApplication "updated" event.
     */
    public function updated(LicenseRenewalApplication $licenseRenewalApplication): void
    {
        //
    }

    /**
     * Handle the LicenseRenewalApplication "deleted" event.
     */
    public function deleted(LicenseRenewalApplication $licenseRenewalApplication): void
    {
        //
    }

    /**
     * Handle the LicenseRenewalApplication "restored" event.
     */
    public function restored(LicenseRenewalApplication $licenseRenewalApplication): void
    {
        //
    }

    /**
     * Handle the LicenseRenewalApplication "force deleted" event.
     */
    public function forceDeleted(LicenseRenewalApplication $licenseRenewalApplication): void
    {
        //
    }
}
