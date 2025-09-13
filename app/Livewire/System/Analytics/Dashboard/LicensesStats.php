<?php

namespace App\Livewire\System\Analytics\Dashboard;

use Livewire\Component;
use App\Models\License;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LicensesStats extends Component
{
    public $totalLicenses = 0;
    public $activeLicenses = 0;
    public $expiredLicenses = 0;
    public $expiringLicenses = 0;
    public $licensesByType = [];
    public $licensesByPurpose = [];
    public $licensesTrend = [];
    public $selectedPeriod = 'month';
    public $chartData = [];

    protected $listeners = ['refreshLicenseStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Get total licenses
        $this->totalLicenses = License::count();

        // Get active and expired licenses
        $this->activeLicenses = License::where('license_status', 'Active')->count();
        $this->expiredLicenses = License::where('license_status', 'Expired')->count();

        // Get licenses expiring in the next 30 days
        $thirtyDaysFromNow = Carbon::now()->addDays(30)->toDateString();
        $this->expiringLicenses = License::where('license_status', 'Active')
            ->whereDate('license_end_date', '<=', $thirtyDaysFromNow)
            ->whereDate('license_end_date', '>=', Carbon::now()->toDateString())
            ->count();

        // Get licenses by type
        $this->licensesByType = License::select('license_type_id', DB::raw('count(*) as total'))
            ->with('licenseType:id,name')
            ->groupBy('license_type_id')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->licenseType ? $item->licenseType->name : 'Unknown',
                    'total' => $item->total
                ];
            });

        // Get licenses by purpose
        $this->licensesByPurpose = License::select('license_purpose_id', DB::raw('count(*) as total'))
            ->with('licensePurpose:id,name')
            ->groupBy('license_purpose_id')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->licensePurpose ? $item->licensePurpose->name : 'Unknown',
                    'total' => $item->total
                ];
            });

        // Get licenses trend based on selected period
        $this->updateChartData();
    }

    public function updateChartData()
    {
        $dateFormat = 'Y-m-d';
        $groupByFormat = 'Y-m-d';
        $days = 30;

        if ($this->selectedPeriod === 'year') {
            $dateFormat = 'Y-m';
            $groupByFormat = 'Y-m';
            $days = 365;
        } elseif ($this->selectedPeriod === 'week') {
            $days = 7;
        }

        $startDate = Carbon::now()->subDays($days);

        // Get new licenses over time
        $newLicenses = License::select(
            DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as date"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Get expired licenses over time
        $expiredLicenses = License::select(
            DB::raw("DATE_FORMAT(license_end_date, '{$dateFormat}') as date"),
            DB::raw('count(*) as total')
        )
            ->where('license_end_date', '>=', $startDate)
            ->where('license_end_date', '<=', Carbon::now())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Prepare dates array for the chart
        $period = Carbon::parse($startDate)->daysUntil(Carbon::now());

        $chartLabels = [];
        $newLicensesData = [];
        $expiredLicensesData = [];

        foreach ($period as $date) {
            $dateKey = $date->format($dateFormat);
            $chartLabels[] = $dateKey;
            $newLicensesData[] = $newLicenses[$dateKey] ?? 0;
            $expiredLicensesData[] = $expiredLicenses[$dateKey] ?? 0;
        }

        $this->chartData = [
            'labels' => $chartLabels,
            'datasets' => [
                [
                    'label' => 'New Licenses',
                    'data' => $newLicensesData,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)'
                ],
                [
                    'label' => 'Expired Licenses',
                    'data' => $expiredLicensesData,
                    'borderColor' => '#EF4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)'
                ]
            ]
        ];

        $this->dispatch('chartDataUpdated', $this->chartData);
    }

    public function changePeriod($period)
    {
        $this->selectedPeriod = $period;
        $this->updateChartData();
    }

    public function render()
    {
        return view('livewire.system.analytics.dashboard.licenses-stats');
    }
}
