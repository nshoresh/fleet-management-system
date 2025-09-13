<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\Vehicle; // Assuming you have a Vehicle model

class VehicleStats extends Component
{
    // Properties to hold vehicle statistics
    public $totalVehicles;
    public $activeVehicles;
    public $inactiveVehicles;

    public function mount()
    {
        // Fetch vehicle statistics when the component mounts
        $this->fetchVehicleStats();
    }

    public function fetchVehicleStats()
    {
        // Assuming you have a Vehicle model with methods to get total, active, and inactive vehicles
        $this->totalVehicles = Vehicle::count();
        $this->activeVehicles = Vehicle::where('status', 'active')->count();
        $this->inactiveVehicles = Vehicle::where('status', 'inactive')->count();
    }

    public function render()
    {
        return view('livewire.system.analytics.dashboard.vehicle-stats');
    }
}
