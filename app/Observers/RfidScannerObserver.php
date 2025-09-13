<?php

namespace App\Observers;

use App\Models\RfidScanner;

class RfidScannerObserver
{
    /**
     * Handle the RfidScanner "created" event.
     */
    public function created(RfidScanner $rfidScanner): void
    {
        //
    }

    /**
     * Handle the RfidScanner "updated" event.
     */
    public function updated(RfidScanner $rfidScanner): void
    {
        //
    }

    /**
     * Handle the RfidScanner "deleted" event.
     */
    public function deleted(RfidScanner $rfidScanner): void
    {
        //
    }

    /**
     * Handle the RfidScanner "restored" event.
     */
    public function restored(RfidScanner $rfidScanner): void
    {
        //
    }

    /**
     * Handle the RfidScanner "force deleted" event.
     */
    public function forceDeleted(RfidScanner $rfidScanner): void
    {
        //
    }
}
