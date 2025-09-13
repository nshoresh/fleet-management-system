<?php

namespace App\Observers;

use App\Models\FeeStructure;

class FeeStructureObserver
{
    /**
     * Handle the FeeStructure "created" event.
     */
    public function created(FeeStructure $feeStructure): void
    {
        //
    }

    /**
     * Handle the FeeStructure "updated" event.
     */
    public function updated(FeeStructure $feeStructure): void
    {
        //
    }

    /**
     * Handle the FeeStructure "deleted" event.
     */
    public function deleted(FeeStructure $feeStructure): void
    {
        //
    }

    /**
     * Handle the FeeStructure "restored" event.
     */
    public function restored(FeeStructure $feeStructure): void
    {
        //
    }

    /**
     * Handle the FeeStructure "force deleted" event.
     */
    public function forceDeleted(FeeStructure $feeStructure): void
    {
        //
    }
}
