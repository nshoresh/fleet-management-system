<?php

namespace App\Observers;

use App\Models\Charge;

class ChargeObserver
{
    /**
     * Handle the Charge "created" event.
     */
    public function created(Charge $charge): void
    {
        //
    }

    /**
     * Handle the Charge "updated" event.
     */
    public function updated(Charge $charge): void
    {
        //
    }

    /**
     * Handle the Charge "deleted" event.
     */
    public function deleted(Charge $charge): void
    {
        //
    }

    /**
     * Handle the Charge "restored" event.
     */
    public function restored(Charge $charge): void
    {
        //
    }

    /**
     * Handle the Charge "force deleted" event.
     */
    public function forceDeleted(Charge $charge): void
    {
        //
    }
}
