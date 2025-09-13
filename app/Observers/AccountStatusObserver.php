<?php

namespace App\Observers;

use App\Models\AccountStatus;

class AccountStatusObserver
{
    /**
     * Handle the AccountStatus "created" event.
     */
    public function created(AccountStatus $accountStatus): void
    {
        //
    }

    /**
     * Handle the AccountStatus "updated" event.
     */
    public function updated(AccountStatus $accountStatus): void
    {
        //
    }

    /**
     * Handle the AccountStatus "deleted" event.
     */
    public function deleted(AccountStatus $accountStatus): void
    {
        //
    }

    /**
     * Handle the AccountStatus "restored" event.
     */
    public function restored(AccountStatus $accountStatus): void
    {
        //
    }

    /**
     * Handle the AccountStatus "force deleted" event.
     */
    public function forceDeleted(AccountStatus $accountStatus): void
    {
        //
    }
}
