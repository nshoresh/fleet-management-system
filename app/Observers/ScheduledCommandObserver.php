<?php

namespace App\Observers;

use App\Models\ScheduledCommand;

class ScheduledCommandObserver
{
    /**
     * Handle the ScheduledCommand "created" event.
     */
    public function created(ScheduledCommand $scheduledCommand): void
    {
        //
    }

    /**
     * Handle the ScheduledCommand "updated" event.
     */
    public function updated(ScheduledCommand $scheduledCommand): void
    {
        //
    }

    /**
     * Handle the ScheduledCommand "deleted" event.
     */
    public function deleted(ScheduledCommand $scheduledCommand): void
    {
        //
    }

    /**
     * Handle the ScheduledCommand "restored" event.
     */
    public function restored(ScheduledCommand $scheduledCommand): void
    {
        //
    }

    /**
     * Handle the ScheduledCommand "force deleted" event.
     */
    public function forceDeleted(ScheduledCommand $scheduledCommand): void
    {
        //
    }
}
