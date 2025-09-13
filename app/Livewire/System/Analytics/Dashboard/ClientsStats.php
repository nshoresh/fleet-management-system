<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\VehicleOwner;
use App\Models\Vehicle;
use App\Models\VehicleType;

class ClientsStats extends Component
{
    public $ownerVehicleCounts; // Data for the owner vehicle bar chart


    public function mount()
    {
        $this->fetchVehicleOwnerStats();
    }

    public function fetchVehicleOwnerStats()
    {

        // Fetch vehicle counts for all owners for chart
        $owners = VehicleOwner::all();
        $this->ownerVehicleCounts = [
            'labels' => $owners->pluck('name')->toArray(),
            'data' => $owners->pluck('fleets_count')->toArray(),
            'colors' => $this->generateColors(count($owners)),  // Generate enough colors
        ];

        $this->dispatch('update-charts', [
            'ownerVehicleCounts' => $this->ownerVehicleCounts,  // Include the new data
        ]);
    }

    private function generateColors($numColors)
    {
        $colors = [];
        for ($i = 0; $i < $numColors; $i++) {
            // Generate a random color
            $r = mt_rand(0, 255);
            $g = mt_rand(0, 255);
            $b = mt_rand(0, 255);
            $colors[] = "rgba($r, $g, $b, 0.7)";
        }
        return $colors;
    }


    public function render()
    {
        return view('livewire.system.analytics.dashboard.clients-stats');
    }
}
