<?php

namespace App\Observers;

use App\Models\FeeCategory;

class FeeCategoryObserver
{
    /**
     * Handle the FeeCategory "created" event.
     */
    public function created(FeeCategory $feeCategory): void
    {
        //
    }

    /**
     * Handle the FeeCategory "updated" event.
     */
    public function updated(FeeCategory $feeCategory): void
    {
        //
    }

    /**
     * Handle the FeeCategory "deleted" event.
     */
    public function deleted(FeeCategory $feeCategory): void
    {
        //
    }

    /**
     * Handle the FeeCategory "restored" event.
     */
    public function restored(FeeCategory $feeCategory): void
    {
        //
    }

    /**
     * Handle the FeeCategory "force deleted" event.
     */
    public function forceDeleted(FeeCategory $feeCategory): void
    {
        //
    }
}
