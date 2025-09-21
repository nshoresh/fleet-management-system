<?php

namespace App\Livewire\Client\License;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LicenseApplication;
use Illuminate\Support\Facades\Auth;

class LicenseList extends Component
{
    use WithPagination;

    // Filters & Sorting
    public $search = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    // Modal + Dropdown
    public $licenseToDelete = null;
    public $showDeleteModal = false;
    public $openDropdown = null;

    protected $paginationTheme = 'tailwind';

    // Persist filters in URL
    protected $queryString = [
        'search',
        'statusFilter',
        'sortField',
        'sortDirection',
        'perPage' => ['except' => 10],
    ];

    /* -----------------
        Modal Actions
    ----------------- */
    public function confirmDelete($id)
    {
        $this->licenseToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteLicense()
    {
        if ($this->licenseToDelete) {
            LicenseApplication::findOrFail($this->licenseToDelete)->delete();

            session()->flash('success', 'License application deleted successfully.');

            $this->licenseToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    /* -----------------
        Sorting & Filters
    ----------------- */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'statusFilter',
        ]);
        $this->resetPage();
    }

    /* -----------------
        Render
    ----------------- */
    public function render()
    {
        $user = auth()->user();

        $licenseApplications = LicenseApplication::with('licenseType')
            ->where('user_id', $user->id) // ✅ correct column
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('application_number', 'like', '%' . $this->search . '%')
                    ->orWhere('purpose', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.client.license.license-list', [
            'licenseApplications' => $licenseApplications,
        ])/*->layout('layouts.app')*/;
    }

}
