<?php

namespace App\Livewire\Client\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class ViewVehicle extends Component
{
    public $vehicle;
    public $vehicleId;

    public function mount($id)
    {
        $this->vehicleId = $id;
        $this->loadVehicle();
    }

    public function loadVehicle()
    {
        $this->vehicle = Vehicle::with([
            'make',
            'makeModel',
            'makeOwner',
            'makeType'
        ])
            ->findOrFail($this->vehicleId);
    }
    public function render()
    {
        return view('livewire.client.vehicles.view-vehicle');
            //->layout('layouts.app');
    }
}
