<?php

namespace App\Observers;

use App\Models\VehicleOwner;

class VehicleOwnerObserver

{

    public function creating(VehicleOwner $vehicleOwner)
    {
        if (empty($vehicleOwner->uuid)) {
            $vehicleOwner->uuid = self::generateUniqueUuid();
        }
    }
    /**
     * Handle the VehicleOwner "created" event.
     */
    public function created(VehicleOwner $vehicleOwner): void
    {
        //
    }

    /**
     * Handle the VehicleOwner "updated" event.
     */
    public function updated(VehicleOwner $vehicleOwner): void
    {
        //
    }

    /**
     * Handle the VehicleOwner "deleted" event.
     */
    public function deleted(VehicleOwner $vehicleOwner): void
    {
        //
    }

    /**
     * Handle the VehicleOwner "restored" event.
     */
    public function restored(VehicleOwner $vehicleOwner): void
    {
        //
    }

    /**
     * Handle the VehicleOwner "force deleted" event.
     */
    public function forceDeleted(VehicleOwner $vehicleOwner): void
    {
        //
    }

    public static function generateUniqueUuid(): string
    {
        do {
            $uuid = strtoupper(bin2hex(random_bytes(32)) . uniqid());
            $exists = VehicleOwner::where('uuid', $uuid)->exists();
        } while ($exists);

        return $uuid;
    }
}
