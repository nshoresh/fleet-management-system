<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\VehicleType;

class VehicleTypesStats extends Component
{
    public $totalTypes;
    public $typesStats;
    public $topTypes;
    public function number_format_short($n)
    {
        if ($n < 1000) return $n;
        $units = ['', 'K', 'M', 'B'];
        $power = floor(log($n, 1000));
        return round($n / pow(1000, $power)) . $units[$power];
    }
    public function mount()
    {
        $this->fetchVehicleTypesStatistics();
    }

    public function fetchVehicleTypesStatistics()
    {
        // Total vehicle types count
        $this->totalTypes = VehicleType::count();

        // Detailed statistics with formatted numbers
        $this->typesStats = VehicleType::withCount(['vehicles'])
            ->get()
            ->map(function ($type) {
                return [
                    'name' => $type->name,
                    'vehicles' => $type->vehicles_count,
                    'vehicles_short' => $this->number_format_short($type->vehicles_count),
                    'vehicles_formatted' => number_format($type->vehicles_count),
                    'description' => $type->description
                ];
            });

        // Top 5 types by vehicle count
        $this->topTypes = VehicleType::withCount('vehicles')
            ->orderBy('vehicles_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($type) {
                return [
                    'name' => $type->name,
                    'count' => number_format($type->vehicles_count),
                    'icon' => '🚗' // Generic vehicle icon
                ];
            });
    }

    public function render()
    {
        return view('livewire.system.analytics.dashboard.vehicle-types-stats');
    }
}
