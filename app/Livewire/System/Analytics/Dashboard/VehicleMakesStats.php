<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\VehicleMake;

class VehicleMakesStats extends Component
{
    // public $totalMakes;
    // public $makesStats;
    // public $topManufacturers;

    public $totalMakes;
    public $makesStats;
    public $topManufacturers;

    public function mount()
    {
        $this->fetchVehicleMakesStatistics();
    }

    public function fetchVehicleMakesStatistics()
    {
        $this->totalMakes = VehicleMake::count();

        $this->makesStats = VehicleMake::withCount(['vehicles', 'models'])
            ->get()
            ->map(function ($make) {
                return [
                    'name' => $make->name,
                    'country' => $make->country,
                    'vehicles' => $make->vehicles_count_formatted,
                    'vehicles_raw' => $make->vehicles_count, // Add raw count for chart
                    'models' => $make->models_count_formatted,
                    'description' => $make->description
                ];
            });

        $this->topManufacturers = VehicleMake::withCount('vehicles')
            ->orderBy('vehicles_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($make) {
                return [
                    'name' => $make->name,
                    'count' => $make->vehicles_count_formatted,
                    'country_flag' => $this->countryToFlag($make->country)
                ];
            });
    }

    protected function countryToFlag($countryCode)
    {
        // Simple country code to emoji flag converter
        $countryCode = strtoupper($countryCode);
        return implode('', array_map(
            fn($letter) => mb_chr(127397 + ord($letter)),
            str_split($countryCode)
        ));
    }

    public function render()
    {
        return view('livewire.system.analytics.dashboard.vehicle-makes-stats');
    }
}
