<?php

namespace App\Observers;

use App\Models\RfidScanLog;

class RfidScanLogObserver
{
    /**
     * Handle the RfidScanLog "created" event.
     */
    public function created(RfidScanLog $rfidScanLog): void
    {
        //
    }

    /**
     * Handle the RfidScanLog "updated" event.
     */
    public function updated(RfidScanLog $rfidScanLog): void
    {
        //
    }

    /**
     * Handle the RfidScanLog "deleted" event.
     */
    public function deleted(RfidScanLog $rfidScanLog): void
    {
        //
    }

    /**
     * Handle the RfidScanLog "restored" event.
     */
    public function restored(RfidScanLog $rfidScanLog): void
    {
        //
    }

    /**
     * Handle the RfidScanLog "force deleted" event.
     */
    public function forceDeleted(RfidScanLog $rfidScanLog): void
    {
        //
    }
}
