<?php

namespace App\Livewire\Client\Dashboard;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\License;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientDashboard extends Component
{
    public $totalVehicles;
    public $activeLicenses;
    public $totalUsers;
    public $pendingApprovals;
    public $latestVehicle;
    public $latestLicense;

    public function mount()
    {
        $user = Auth::user();
        $vehicleOwnerId = $user->vehicle_owner_id;

        // Vehicles owned by client
        $this->totalVehicles = Vehicle::where('vehicle_owner_id', $vehicleOwnerId)->count();

        // Active licenses
        $this->activeLicenses = License::whereHas('vehicle', function ($q) use ($vehicleOwnerId) {
            $q->where('vehicle_owner_id', $vehicleOwnerId);
        })->where('license_status', 'active')->count();

        // Users under this client
        $this->totalUsers = User::where('vehicle_owner_id', $vehicleOwnerId)->count();

        // Pending licenses
        $this->pendingApprovals = License::whereHas('vehicle', function ($q) use ($vehicleOwnerId) {
            $q->where('vehicle_owner_id', $vehicleOwnerId);
        })->where('license_status', 'pending')->count();

        // Latest vehicle
        $this->latestVehicle = Vehicle::where('vehicle_owner_id', $vehicleOwnerId)->latest()->first();

        // Latest license
        $this->latestLicense = License::whereHas('vehicle', function ($q) use ($vehicleOwnerId) {
            $q->where('vehicle_owner_id', $vehicleOwnerId);
        })->latest()->first();
    }

    public function render()
    {
        return view('livewire.client.dashboard.client-dashboard');
    }
}
