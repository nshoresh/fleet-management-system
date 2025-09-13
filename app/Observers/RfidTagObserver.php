<?php

namespace App\Observers;

use App\Models\RfidTag;

class RfidTagObserver
{
    /**
     * Handle the RfidTag "created" event.
     */
    public function created(RfidTag $rfidTag): void
    {
        //
    }

    /**
     * Handle the RfidTag "updated" event.
     */
    public function updated(RfidTag $rfidTag): void
    {
        //
    }

    /**
     * Handle the RfidTag "deleted" event.
     */
    public function deleted(RfidTag $rfidTag): void
    {
        //
    }

    /**
     * Handle the RfidTag "restored" event.
     */
    public function restored(RfidTag $rfidTag): void
    {
        //
    }

    /**
     * Handle the RfidTag "force deleted" event.
     */
    public function forceDeleted(RfidTag $rfidTag): void
    {
        //
    }
}
