<?php

namespace App\Observers;

use App\Models\TransmissionType;

class TransmissionTypeObserver
{
    /**
     * Handle the TransmissionType "created" event.
     */
    public function created(TransmissionType $transmissionType): void
    {
        //
    }

    /**
     * Handle the TransmissionType "updated" event.
     */
    public function updated(TransmissionType $transmissionType): void
    {
        //
    }

    /**
     * Handle the TransmissionType "deleted" event.
     */
    public function deleted(TransmissionType $transmissionType): void
    {
        //
    }

    /**
     * Handle the TransmissionType "restored" event.
     */
    public function restored(TransmissionType $transmissionType): void
    {
        //
    }

    /**
     * Handle the TransmissionType "force deleted" event.
     */
    public function forceDeleted(TransmissionType $transmissionType): void
    {
        //
    }
}
