<?php

namespace App\Observers;

use App\Models\Role;


class RoleObserver
{

    public function creating(Role $role)
    {
        if (empty($role->slug)) {
            $role->slug = \Illuminate\Support\Str::slug($role->name);
        }
    }
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        //
    }


    public function updating(Role $role): void
    {
        if ($role->isDirty('name') && empty($role->slug)) {
            $role->slug = \Illuminate\Support\Str::slug($role->name);
        }
    }


    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        //
    }

    public function deleting(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
