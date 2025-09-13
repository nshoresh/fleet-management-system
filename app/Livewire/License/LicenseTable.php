<?php

namespace App\Livewire\License;

use App\Models\License;
use App\Models\LicenseType;
use App\Models\LicensePurpose;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\VehicleOwner;
use Livewire\Component;
use Livewire\WithPagination;

class LicenseTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search and filter properties
    public $search = '';
    public $licenseTypeFilter = '';
    public $licensePurposeFilter = '';
    public $licenseStatusFilter = '';
    public $dateRangeStart = '';
    public $dateRangeEnd = '';

    // For editing license
    public $licenseId;
    public $registrationNumber;
    public $vehicleOwnerId;
    public $vehicleId;
    public $licenseTypeId;
    public $licensePurposeId;
    public $routeId;
    public $licenseStartDate;
    public $licenseEndDate;
    public $licenseStatus;

    // For modal states
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showViewModal = false;

    // Listeners for events
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function clearFilters(){
        
    }

    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLicenseTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingLicensePurposeFilter()
    {
        $this->resetPage();
    }

    public function updatingLicenseStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateRangeStart()
    {
        $this->resetPage();
    }

    public function updatingDateRangeEnd()
    {
        $this->resetPage();
    }

    // View license details
    public function viewLicense($id)
    {
        $this->licenseId = $id;
        $this->showViewModal = true;
    }

    // Open edit modal
    public function editLicense($id)
    {
        $this->resetValidation();
        $this->resetLicenseFields();

        $license = License::findOrFail($id);
        
        $this->licenseId = $license->id;
        $this->registrationNumber = $license->registration_number;
        $this->vehicleOwnerId = $license->vehicle_owners_id;
        $this->vehicleId = $license->vehicle_id;
        $this->licenseTypeId = $license->license_type_id;
        $this->licensePurposeId = $license->license_purpose_id;
        $this->routeId = $license->route_id;
        $this->licenseStartDate = $license->license_start_date->format('Y-m-d');
        $this->licenseEndDate = $license->license_end_date->format('Y-m-d');
        $this->licenseStatus = $license->license_status;

        $this->showEditModal = true;
    }

    // Save edited license
    public function updateLicense()
    {
        $this->validate([
            'registrationNumber' => 'required|string',
            'vehicleOwnerId' => 'nullable|exists:vehicle_owners,id',
            'vehicleId' => 'nullable|exists:vehicles,id',
            'licenseTypeId' => 'nullable|exists:license_types,id',
            'licensePurposeId' => 'nullable|exists:license_purposes,id',
            'routeId' => 'nullable|exists:routes,id',
            'licenseStartDate' => 'required|date',
            'licenseEndDate' => 'required|date|after_or_equal:licenseStartDate',
            'licenseStatus' => 'required|in:Active,Expired',
        ]);

        $license = License::findOrFail($this->licenseId);
        
        $license->update([
            'registration_number' => $this->registrationNumber,
            'vehicle_owners_id' => $this->vehicleOwnerId,
            'vehicle_id' => $this->vehicleId,
            'license_type_id' => $this->licenseTypeId,
            'license_purpose_id' => $this->licensePurposeId,
            'route_id' => $this->routeId,
            'license_start_date' => $this->licenseStartDate,
            'license_end_date' => $this->licenseEndDate,
            'license_status' => $this->licenseStatus,
        ]);

        $this->showEditModal = false;
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'License updated successfully!'
        ]);
    }

    // Confirm delete
    public function confirmDelete($id)
    {
        $this->licenseId = $id;
        $this->showDeleteModal = true;
    }

    // Delete license
    public function deleteLicense()
    {
        $license = License::findOrFail($this->licenseId);
        $license->delete();
        
        $this->showDeleteModal = false;
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'License deleted successfully!'
        ]);
    }

    // Reset fields
    public function resetLicenseFields()
    {
        $this->licenseId = null;
        $this->registrationNumber = '';
        $this->vehicleOwnerId = '';
        $this->vehicleId = '';
        $this->licenseTypeId = '';
        $this->licensePurposeId = '';
        $this->routeId = '';
        $this->licenseStartDate = '';
        $this->licenseEndDate = '';
        $this->licenseStatus = 'Active';
    }

    // Close modals
    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = false;
        $this->resetValidation();
        $this->resetLicenseFields();
    }

    // Get license data with relationships for viewing
    public function getLicenseDetailsProperty()
    {
        if (!$this->licenseId) {
            return null;
        }
        
        return License::with([
            'vehicleOwner', 
            'vehicle', 
            'licenseType', 
            'licensePurpose', 
            'route'
        ])->findOrFail($this->licenseId);
    }

    public function render()
    {
        $query = License::query()
            ->with(['vehicleOwner', 'vehicle', 'licenseType', 'licensePurpose', 'route']);

        // Search functionality
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('registration_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('vehicleOwner', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('vehicle', function ($q) {
                      $q->where('plate_number', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply filters
        if (!empty($this->licenseTypeFilter)) {
            $query->where('license_type_id', $this->licenseTypeFilter);
        }

        if (!empty($this->licensePurposeFilter)) {
            $query->where('license_purpose_id', $this->licensePurposeFilter);
        }

        if (!empty($this->licenseStatusFilter)) {
            $query->where('license_status', $this->licenseStatusFilter);
        }

        // Date range filter
        if (!empty($this->dateRangeStart)) {
            $query->whereDate('license_start_date', '>=', $this->dateRangeStart);
        }

        if (!empty($this->dateRangeEnd)) {
            $query->whereDate('license_end_date', '<=', $this->dateRangeEnd);
        }

        // Get dropdown data for filters and forms
        $licenseTypes = LicenseType::all();
        $licensePurposes = LicensePurpose::all();
        $routes = Route::all();
        $vehicles = Vehicle::all();
        $vehicleOwners = VehicleOwner::all();

        $licenses = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.license.license-table', [
            'licenses' => $licenses,
            'licenseTypes' => $licenseTypes,
            'licensePurposes' => $licensePurposes,
            'routes' => $routes,
            'vehicles' => $vehicles,
            'vehicleOwners' => $vehicleOwners,
        ])->layout('layouts.app');
    }
}