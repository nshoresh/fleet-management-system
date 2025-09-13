<?php

namespace App\Livewire\Client\Home;

use Livewire\Component;
use App\Models\VehicleOwner;
use App\Models\AccountStatus;

class VehicleOwnerPreview extends Component
{
    public ?VehicleOwner $vehicleOwner = null;

    public function mount()
    {
        // Get the vehicle owner instance, not the relationship
        $this->vehicleOwner = auth()->user()->vehicleOwner;
        // Alternative approach if the above doesn't work:
        // $this->vehicleOwner = auth()->user()->vehicleOwner()->first();
    }

    public function render()
    {
        return view('livewire.client.home.vehicle-owner-preview', [
            'vehicleOwner' => $this->vehicleOwner
        ]);
    }
}
