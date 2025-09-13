<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleOwner;
use App\Models\VehicleOwnerType;
use App\Models\VehicleType;
use App\Models\VehicleMakeModel;
use App\Models\VehicleMake;

class DashboardMain extends Component
{
    public $activeTab = 'makes';
    public $metrics = [];
    public $vehicleData = [];
    public $yearlyTrends = [];

    public function mount()
    {
        $this->activeTab = 'makes';
        $this->loadData();
    }

    public function loadData()
    {
        $totalVehicles = Vehicle::count();

        // === Load Vehicle Makes ===
        $makes = VehicleMake::withCount('vehicles')
            ->orderBy('vehicles_count', 'desc')
            ->take(7)
            ->get();

        $otherMakes = VehicleMake::withCount('vehicles')
            ->orderBy('vehicles_count', 'desc')
            ->skip(7)
            ->take(100)
            ->get();

        $otherMakesCount = $otherMakes->sum('vehicles_count');

        $makesData = $makes->map(function ($make) use ($totalVehicles) {
            return [
                'name' => $make->name,
                'count' => $make->vehicles_count,
                'percentage' => $totalVehicles > 0 ? round(($make->vehicles_count / $totalVehicles) * 100, 1) : 0
            ];
        })->toArray();

        $makesData[] = [
            'name' => 'Other',
            'count' => $otherMakesCount,
            'percentage' => $totalVehicles > 0 ? round(($otherMakesCount / $totalVehicles) * 100, 1) : 0
        ];

        // === Load Vehicle Models ===
        $models = VehicleMakeModel::select('vehicle_make_models.*')
            ->selectRaw('(SELECT COUNT(*) FROM vehicles WHERE vehicles.model_id = vehicle_make_models.id) as vehicles_count')
            ->orderBy('vehicles_count', 'desc')
            ->take(7)
            ->get();

        $otherModels = VehicleMakeModel::select('vehicle_make_models.*')
            ->selectRaw('(SELECT COUNT(*) FROM vehicles WHERE vehicles.model_id = vehicle_make_models.id) as vehicles_count')
            ->orderBy('vehicles_count', 'desc')
            ->skip(7)
            ->take(1000)
            ->get();

        $otherModelsCount = $otherModels->sum('vehicles_count');

        $modelsData = $models->map(function ($model) use ($totalVehicles) {
            return [
                'name' => $model->name,
                'count' => $model->vehicles_count,
                'percentage' => $totalVehicles > 0 ? round(($model->vehicles_count / $totalVehicles) * 100, 1) : 0
            ];
        })->toArray();

        $modelsData[] = [
            'name' => 'Other',
            'count' => $otherModelsCount,
            'percentage' => $totalVehicles > 0 ? round(($otherModelsCount / $totalVehicles) * 100, 1) : 0
        ];

        // === Vehicle Types ===
        $vehicleTypes = Vehicle::select('type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($type) use ($totalVehicles) {
                return [
                    'name' => $type->type,
                    'count' => $type->count,
                    'percentage' => $totalVehicles > 0 ? round(($type->count / $totalVehicles) * 100, 1) : 0
                ];
            })->toArray();

        // === Metrics ===
        $this->metrics = [
            'totalVehicles' => $totalVehicles,
            'uniqueMakes' => VehicleMake::count(),
            'uniqueModels' => VehicleMakeModel::count(),
            'averageAge' => round(Vehicle::avg('age'), 1),
            'averageMileage' => number_format(round(Vehicle::avg('mileage')))
        ];

        // === Yearly Trends (Simulated — Replace With Real Data If Available) ===
        $this->yearlyTrends = [
            ['year' => 2018, 'sedans' => 980, 'suvs' => 540, 'pickups' => 320],
            ['year' => 2019, 'sedans' => 920, 'suvs' => 620, 'pickups' => 340],
            ['year' => 2020, 'sedans' => 840, 'suvs' => 720, 'pickups' => 350],
            ['year' => 2021, 'sedans' => 760, 'suvs' => 810, 'pickups' => 380],
            ['year' => 2022, 'sedans' => 680, 'suvs' => 880, 'pickups' => 410],
            ['year' => 2023, 'sedans' => 620, 'suvs' => 950, 'pickups' => 430],
            ['year' => 2024, 'sedans' => 580, 'suvs' => 1020, 'pickups' => 450],
        ];

        // === Final Data Collection ===
        $this->vehicleData = [
            'makes' => $makesData,
            'models' => $modelsData,
            'vehicleTypes' => $vehicleTypes
        ];
    }

    public function render()
    {
        return view('livewire.system.analytics.dashboard.dasboard-main');
    }
}
