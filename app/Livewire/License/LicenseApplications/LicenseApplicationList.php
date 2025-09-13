<?php

namespace App\Livewire\License\LicenseApplications;

use App\Models\LicenseApplication;
use Livewire\Component;
use Livewire\WithPagination;

class LicenseApplicationList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $applications = LicenseApplication::with(['user', 'licenseType'])
            ->when($this->search, function ($query) {
                $query->where('application_number', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.license.license-applications.license-application-list', [
            'applications' => $applications,
        ]);
    }
}
