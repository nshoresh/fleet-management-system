<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\Response;

class VehiclePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        //
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to view vehicles.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vehicle $vehicle): Response
    {
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to view vehicles.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to create vehicles.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Vehicle $vehicle): Response
    {
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to update vehicles.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vehicle $vehicle): Response
    {
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to delete vehicles.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vehicle $vehicle): Response
    {
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to restore vehicles.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vehicle $vehicle): Response
    {
        return $user->isSuperAdmin() || $user->isSystemAdmin() || $user->isPlatformAdmin() || $user->isSiteManager()
            ? Response::allow()
            : Response::deny('You do not have permission to permanently delete vehicles.');
    }
}
