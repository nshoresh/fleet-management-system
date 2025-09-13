<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\Response;

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BusinessPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() ||
            $user->isClientsManager() ||
            $user->hasPermission('business_view_any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Business $business): bool
    {
        // Admins and clients managers can view any business
        if ($user->isAdmin() || $user->isClientsManager()) {
            return true;
        }

        // Vehicle owners can view their own businesses
        if ($user->isVehicleOwner() && $business->vehicle_owner_id === $user->vehicle_owner_id) {
            return true;
        }

        if ($user->isSiteManager()) {
            return true;
        }
        // Check specific permission
        return $user->hasPermission('business_view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() ||
            $user->isClientsManager() ||
            $user->hasPermission('business_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Business $business): bool
    {
        // Admins and clients managers can update any business
        if ($user->isAdmin() || $user->isClientsManager()) {
            return true;
        }

        // Vehicle owners can update their own businesses
        if ($user->isVehicleOwner() && $business->vehicle_owner_id === $user->vehicle_owner_id) {
            return $user->hasPermission('business_update_own');
        }

        // Check general update permission
        return $user->hasPermission('business_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Business $business): bool
    {
        // Only admins and clients managers can delete
        return $user->isAdmin() ||
            ($user->isClientsManager() && $user->hasPermission('business_delete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Business $business): bool
    {
        // Only admins can restore soft-deleted businesses
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Business $business): bool
    {
        // Only super admins can permanently delete
        return $user->isSuperAdmin();
    }
}
