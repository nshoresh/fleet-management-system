<?php

namespace App\Livewire\License\LicenseApplications;

use App\Models\LicenseRenewalApplication;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class RenewalApplications extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $statusFilter = '';
    public string $dateFilter = '';

    protected $queryString = ['search', 'statusFilter', 'dateFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $applications = LicenseRenewalApplication::with(['license', 'vehicleOwner', 'vehicle', 'licenseType', 'licensePurpose', 'route'])
            ->when($this->search, function ($query) {
                $query->where('application_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('vehicleOwner', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('vehicle', function ($q) {
                        $q->where('plate_number', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFilter, function ($query) {
                switch ($this->dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'this_week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'this_month':
                        $query->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year);
                        break;
                    case 'expiring_soon':
                        $query->whereDate('requested_end_date', '<=', now()->addDays(30))
                            ->whereDate('requested_end_date', '>=', now());
                        break;
                }
            })
            ->latest()
            ->paginate(10);

        $statusOptions = ['Pending', 'Approved', 'Rejected'];
        $dateFilterOptions = [
            'today' => 'Today',
            'this_week' => 'This Week',
            'this_month' => 'This Month',
            'expiring_soon' => 'Expiring Soon'
        ];

        return view('livewire.license.license-applications.renewal-applications', [
            'applications' => $applications,
            'statusOptions' => $statusOptions,
            'dateFilterOptions' => $dateFilterOptions,
        ]);
    }

    public function viewDetails($id)
    {
        return redirect()->route('license.renewal-applications.show', $id);
    }

    public function approveApplication($id)
    {
        $application = LicenseRenewalApplication::findOrFail($id);
        $application->status = 'Approved';
        $application->save();

        // Update the associated license with new dates
        $license = $application->license;
        $license->start_date = $application->requested_start_date;
        $license->end_date = $application->requested_end_date;
        $license->save();

        session()->flash('message', 'Application approved successfully.');
    }

    public function rejectApplication($id, $reason = null)
    {
        $application = LicenseRenewalApplication::findOrFail($id);
        $application->status = 'Rejected';
        $application->rejection_reason = $reason;
        $application->save();

        session()->flash('message', 'Application rejected successfully.');
    }
}
