<?php

namespace App\Livewire\Vehicles\Makes;

use App\Models\VehicleMake;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class MakesTable extends Component
{
    use WithPagination;

    // Search and sort properties
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Filter properties
    public $dateFrom = '';
    public $dateTo = '';
    public $status = '';
    public $country = ''; // New filter for country
    public $perPage = 10;

    // In your parent Livewire component (e.g., MakesTable.php)
public $showMakeForm = false;

    protected $listeners = [
        'close-form' => 'hideMakeForm',
        'make-created' => 'hideMakeForm'
    ];

    public function hideMakeForm()
    {
        $this->showMakeForm = false;
    }

    // Save filters in query string for shareable URLs
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'status' => ['except' => ''],
        'country' => ['except' => ''], // Added country filter
        'perPage' => ['except' => 10]
    ];

    /**
     * Toggle sort direction when clicking column headers
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Reset page when updating any filter
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingCountry() // Reset page when filtering by country
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    /**
     * Reset all filters
     */
    public function resetFilters()
    {
        $this->reset(['search', 'dateFrom', 'dateTo', 'status', 'country']); // Include country in reset
        $this->resetPage();
    }

    /**
     * Delete a vehicle make
     */
    public function deleteMake($makeId)
    {
        $make = VehicleMake::findOrFail($makeId);

        $make->delete();
        session()->flash('message', 'Make deleted successfully.');
    }

    /**
     * Render the component
     */
    public function render()
    {
        $makes = VehicleMake::query()
            // Search in name and description
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            // Filter by date range
            ->when($this->dateFrom, function ($query) {
                return $query->whereDate('created_at', '>=', Carbon::parse($this->dateFrom));
            })
            ->when($this->dateTo, function ($query) {
                return $query->whereDate('created_at', '<=', Carbon::parse($this->dateTo));
            })
            // Filter by status
            ->when($this->status !== '', function ($query) {
                return $query->where('status', $this->status);
            })
            // Filter by country
            ->when($this->country !== '', function ($query) {
                return $query->where('country', $this->country);
            })
            // Sort results
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Example country list - Replace with actual data source
        $countries = VehicleMake::distinct()->pluck('country', 'country');

        // Get all possible statuses
        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ];

        return view('livewire.vehicles.makes.makes-table', [
            'makes' => $makes,
            'statuses' => $statuses,
            'countries' => $countries // Pass country filter options to Blade
        ])/*->layout('layouts.app')*/;
    }
}
