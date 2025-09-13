<?php

namespace App\Observers;

use App\Models\FeeStatus;

class FeeStatusObserver
{
    /**
     * Handle the FeeStatus "created" event.
     */
    public function created(FeeStatus $feeStatus): void
    {
        //
    }

    /**
     * Handle the FeeStatus "updated" event.
     */
    public function updated(FeeStatus $feeStatus): void
    {
        //
    }

    /**
     * Handle the FeeStatus "deleted" event.
     */
    public function deleted(FeeStatus $feeStatus): void
    {
        //
    }

    /**
     * Handle the FeeStatus "restored" event.
     */
    public function restored(FeeStatus $feeStatus): void
    {
        //
    }

    /**
     * Handle the FeeStatus "force deleted" event.
     */
    public function forceDeleted(FeeStatus $feeStatus): void
    {
        //
    }
}
