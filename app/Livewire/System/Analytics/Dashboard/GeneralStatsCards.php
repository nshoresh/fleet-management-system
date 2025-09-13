<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\License;
use App\Models\Scanner;
use App\Models\VehicleOwner;
use Carbon\Carbon;

class GeneralStatsCards extends Component
{
    public $vehicleCount;
    public $vehicleTrend;
    public $licenseCount;
    public $licenseTrend;
    public $ownerCount;
    public $ownerTrend;
    public $rfidCount;
    public $rfidTrend;

    public function mount()
    {
        // Calculate current counts
        $this->vehicleCount = Vehicle::count();
        $this->licenseCount = License::count();
        // $this->rfidCount = Scanner::count();
        $this->ownerCount = VehicleOwner::count();

        // Calculate trends (comparing with last month)
        $lastMonth = Carbon::now()->subMonth();

        // Calculate vehicle trend
        $lastMonthVehicles = Vehicle::where(
            'created_at',
            '<',
            $lastMonth
        )->count();
        $this->vehicleTrend = $lastMonthVehicles > 0
            ? round((($this->vehicleCount - $lastMonthVehicles) / $lastMonthVehicles) * 100, 1)
            : 0;

        // Calculate license trend
        $lastMonthLicenses = License::where(
            'created_at',
            '<',
            $lastMonth
        )->count();
        $this->licenseTrend = $lastMonthLicenses > 0
            ? round((($this->licenseCount - $lastMonthLicenses) / $lastMonthLicenses) * 100, 1)
            : 0;

        // Calculate RFID trend
        // $lastMonthRfid = Scanner::where(
        //     'created_at',
        //     '<',
        //     $lastMonth
        // )->count();
        // $this->rfidTrend = $lastMonthRfid > 0
        //     ? round((($this->rfidCount - $lastMonthRfid) / $lastMonthRfid) * 100, 1)
        //     : 0;
        // Calculate owner trend
        $lastMonthOwners = VehicleOwner::where(
            'created_at',
            '<',
            $lastMonth
        )->count();

        $this->ownerTrend = $lastMonthOwners > 0
            ? round((($this->ownerCount - $lastMonthOwners) / $lastMonthOwners) * 100, 1)
            : 0;
    }

    public function render()
    {
        return view('livewire.system.analytics.dashboard.general-stats-cards');
    }
}
