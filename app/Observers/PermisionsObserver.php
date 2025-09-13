<?php

namespace App\Observers;

use App\Models\Permisions;

class PermisionsObserver
{

    public function creating(Permisions $permisions)
    {
        //
    }
    /**
     * Handle the Permisions "created" event.
     */
    public function created(Permisions $permisions): void
    {
        //
    }

    public function updating(Permisions $permisions): void
    {
        //
    }
    /**
     * Handle the Permisions "updated" event.
     */
    public function updated(Permisions $permisions): void
    {
        //
    }

    /**
     * Handle the Permisions "deleted" event.
     */
    public function deleted(Permisions $permisions): void
    {
        //
    }

    /**
     * Handle the Permisions "restored" event.
     */
    public function restored(Permisions $permisions): void
    {
        //
    }

    /**
     * Handle the Permisions "force deleted" event.
     */
    public function forceDeleted(Permisions $permisions): void
    {
        //
    }
}
