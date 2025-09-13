<?php

namespace App\Livewire\Vehicles\VehicleTypes;

use Livewire\Component;

class CreateVehicleTypes extends Component
{
    public function render()
    {
        return view('livewire.vehicles.vehicle-types.create-vehicle-types')->layout('layouts.app');
    }
}
