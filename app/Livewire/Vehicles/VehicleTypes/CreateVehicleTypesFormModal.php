<?php

namespace App\Livewire\Vehicles\VehicleTypes;

use Livewire\Component;

class CreateVehicleTypesFormModal extends Component
{
    public function render()
    {
        return view('livewire.vehicles.vehicle-types.create-vehicle-types-form-modal')->layout('layouts.app');
    }
}
