<?php

namespace App\Livewire\Admin\VehicleOwnerTypes;

use Livewire\Component;

class CreateVehicleOwnerTypes extends Component
{
    public function render()
    {
        return view('livewire.admin.vehicle-owner-types.create-vehicle-owner-types')->layout('layouts.app');
    }
}
