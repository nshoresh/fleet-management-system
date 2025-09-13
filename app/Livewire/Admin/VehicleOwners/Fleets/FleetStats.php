<?php

namespace App\Livewire\Admin\VehicleOwners\Fleets;

use App\Models\VehicleOwner;
use Livewire\Component;

class FleetStats extends Component
{
    public VehicleOwner $vehicle_owner;

    public int $vehicle_count = 0;
    public function mount($id)
    {
        $this->vehicle_owner = VehicleOwner::find($id);
        $this->vehicle_count = $this->vehicle_owner->getFleetsCountAttribute();
    }
    public function render()
    {

        return view('livewire.admin.vehicle-owners.fleets.fleet-stats');
    }
}
