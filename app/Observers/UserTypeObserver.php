<?php

namespace App\Observers;

use App\Models\UserType;

class UserTypeObserver
{
    /**
     * Handle the UserType "created" event.
     */
    public function created(UserType $userType): void
    {
        //
    }

    /**
     * Handle the UserType "updated" event.
     */
    public function updated(UserType $userType): void
    {
        //
    }

    /**
     * Handle the UserType "deleted" event.
     */
    public function deleted(UserType $userType): void
    {
        //
    }

    /**
     * Handle the UserType "restored" event.
     */
    public function restored(UserType $userType): void
    {
        //
    }

    /**
     * Handle the UserType "force deleted" event.
     */
    public function forceDeleted(UserType $userType): void
    {
        //
    }
}
