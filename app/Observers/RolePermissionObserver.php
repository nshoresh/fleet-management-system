<?php

namespace App\Observers;

use App\Models\RolePermission;

class RolePermissionObserver
{
    /**
     * Handle the RolePermission "created" event.
     */
    public function created(RolePermission $rolePermission): void
    {
        //
    }

    /**
     * Handle the RolePermission "updated" event.
     */
    public function updated(RolePermission $rolePermission): void
    {
        //
    }

    /**
     * Handle the RolePermission "deleted" event.
     */
    public function deleted(RolePermission $rolePermission): void
    {
        //
    }

    /**
     * Handle the RolePermission "restored" event.
     */
    public function restored(RolePermission $rolePermission): void
    {
        //
    }

    /**
     * Handle the RolePermission "force deleted" event.
     */
    public function forceDeleted(RolePermission $rolePermission): void
    {
        //
    }
}
