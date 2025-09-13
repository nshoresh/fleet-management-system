<?php

namespace App\Livewire\Client\Vehicles;

use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleType;
use App\Models\VehicleOwner;
use App\Models\LicenseApplication;
use Illuminate\Database\Eloquent\Relations\HasMany; // ✅ Added
use Livewire\Component;
use Livewire\WithPagination;

class VehicleListing extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $statusFilter = null;
    public $makeFilter = '';
    public $typeFilter = '';
    //public $statusFilter = '';
    public $ownerFilter = '';
    public $yearFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    // Modal + Dropdown
    public $vehicleToDelete = null;
    public $showDeleteModal = false;
    public $openDropdown = null;


    public VehicleOwner $vehicleOwner;

    // Array of vehicle statuses for dropdown
    public $statuses = ['active', 'inactive', 'sold'];

    protected $queryString = [
        'search',
        'makeFilter',
        'typeFilter',
        'statusFilter',
        'ownerFilter',
        'yearFilter',
        'sortField',
        'sortDirection',
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        $this->vehicleOwner = auth()->user()->vehicleOwner;
    }

    /* -----------------
        Modal Actions
    ----------------- */
    public function confirmDelete($uuid)
    {
        $this->vehicleToDelete = $uuid;
        $this->showDeleteModal = true;
    }

    public function deleteVehicle()
    {
        if ($this->vehicleToDelete) {
            Vehicle::findOrFail($this->vehicleToDelete)->delete();

            session()->flash('success', 'Vehicle deleted successfully.');

            $this->vehicleToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    // Reset pagination when filters change
    public function updatingSearch() { $this->resetPage(); }
    public function updatingMakeFilter() { $this->resetPage(); }
    public function updatingTypeFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingOwnerFilter() { $this->resetPage(); }
    public function updatingYearFilter() { $this->resetPage(); }

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
            'makeFilter',
            'typeFilter',
            'statusFilter',
            'ownerFilter',
            'yearFilter'
        ]);
        $this->resetPage();
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->where('vehicle_owner_id', '=', $this->vehicleOwner->id)
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('vin', 'like', '%' . $this->search . '%')
                        ->orWhere('license_plate', 'like', '%' . $this->search . '%')
                        ->orWhere('color', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->makeFilter, fn($query) => $query->where('vehicle_make_id', $this->makeFilter))
            ->when($this->typeFilter, fn($query) => $query->where('vehicle_type_id', $this->typeFilter))
            ->when($this->statusFilter, fn($query) => $query->where('status', $this->statusFilter))
            ->when($this->ownerFilter, fn($query) => $query->where('vehicle_owner_id', $this->ownerFilter))
            ->when($this->yearFilter, fn($query) => $query->where('year', $this->yearFilter))
            ->with([
                'make',
                'makeModel',
                'makeOwner',
                'makeType',
                'license',   // 👈 eager load license
            ])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $makes = VehicleMake::orderBy('name')->get();
        $types = VehicleType::orderBy('name')->get();
        $owners = VehicleOwner::orderBy('name')->get();
        $years = Vehicle::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('livewire.client.vehicles.vehicle-listing', [
            'vehicles' => $vehicles,
            'makes' => $makes,
            'types' => $types,
            'owners' => $owners,
            'years' => $years,
        ])/*->layout('layouts.app')*/;
    }
}

// ✅ Quick fix: patch missing relationship so documents() won't throw errors
if (!method_exists(LicenseApplication::class, 'documents')) {
    LicenseApplication::resolveRelationUsing('documents', function ($licenseApp) {
        return $licenseApp->hasMany(\App\Models\LicenseDocument::class, 'license_application_id');
    });
}
