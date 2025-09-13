<?php

namespace App\Livewire\License;

use App\Models\License;
use App\Models\LicenseType;
use App\Models\LicensePurpose;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\VehicleOwner;
use App\Models\LicenseApplication;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LicenseForm extends Component
{
    // Form fields
    public $registrationNumber;
    public $vehicleOwnerId;
    public $vehicleId;
    public $licenseTypeId;
    public $licensePurposeId;
    public $routeId;
    public $licenseStartDate;
    public $licenseEndDate;
    public $licenseStatus = 'Active';
    public $licenseApplicationId;

    // List of license applications to choose from
    public $licenseApplications = [];

    public function mount()
    {
        // Set default start date to today
        $this->licenseStartDate = date('Y-m-d');
        
        // Set default end date to one year from today
        $this->licenseEndDate = date('Y-m-d', strtotime('+1 year'));
        
        // Load pending license applications
        $this->loadLicenseApplications();
    }

    public function loadLicenseApplications()
    {
        // Get pending license applications that don't have a license yet
        $this->licenseApplications = LicenseApplication::where('status', 'Approved')
            ->whereDoesntHave('license')
            ->get();
    }

    // When a license application is selected, prefill the form
    public function updatedLicenseApplicationId()
    {
        if (!empty($this->licenseApplicationId)) {
            $application = LicenseApplication::with(['vehicleOwner', 'vehicle', 'licenseType', 'licensePurpose', 'route'])
                ->findOrFail($this->licenseApplicationId);
            
            // Prefill the form with application data
            $this->registrationNumber = 'LIC-' . date('Y') . '-' . str_pad($this->licenseApplicationId, 5, '0', STR_PAD_LEFT);
            $this->vehicleOwnerId = $application->vehicle_owner_id;
            $this->vehicleId = $application->vehicle_id;
            $this->licenseTypeId = $application->license_type_id;
            $this->licensePurposeId = $application->license_purpose_id;
            $this->routeId = $application->route_id;
        }
    }
    
    // When a vehicle owner is selected, load their vehicles
    public function updatedVehicleOwnerId()
    {
        if (!empty($this->vehicleOwnerId)) {
            // Reset vehicle selection when owner changes
            $this->vehicleId = '';
        }
    }

    // Save the new license
    public function saveLicense()
    {
        $this->validate([
            'registrationNumber' => 'required|string|unique:licenses,registration_number',
            'licenseApplicationId' => 'required|exists:license_applications,id',
            'vehicleOwnerId' => 'nullable|exists:vehicle_owners,id',
            'vehicleId' => 'nullable|exists:vehicles,id',
            'licenseTypeId' => 'nullable|exists:license_types,id',
            'licensePurposeId' => 'nullable|exists:license_purposes,id',
            'routeId' => 'nullable|exists:routes,id',
            'licenseStartDate' => 'required|date',
            'licenseEndDate' => 'required|date|after_or_equal:licenseStartDate',
            'licenseStatus' => 'required|in:Active,Expired',
        ]);

        try {
            DB::beginTransaction();
            
            // Create the new license
            $license = License::create([
                'registration_number' => $this->registrationNumber,
                'license_application_id' => $this->licenseApplicationId,
                'vehicle_owners_id' => $this->vehicleOwnerId,
                'vehicle_id' => $this->vehicleId,
                'license_type_id' => $this->licenseTypeId,
                'license_purpose_id' => $this->licensePurposeId,
                'route_id' => $this->routeId,
                'license_start_date' => $this->licenseStartDate,
                'license_end_date' => $this->licenseEndDate,
                'license_status' => $this->licenseStatus,
            ]);
            
            // Update the license application status to indicate license has been issued
            LicenseApplication::where('id', $this->licenseApplicationId)
                ->update(['status' => 'Completed']);
            
            DB::commit();
            
            // Show success message
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success', 
                'message' => 'License created successfully!'
            ]);
            
            // Redirect to the license table view
            return redirect()->route('license.index');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Show error message
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Error creating license: ' . $e->getMessage()
            ]);
        }
    }

    // Reset form fields
    public function resetForm()
    {
        $this->reset([
            'registrationNumber',
            'vehicleOwnerId',
            'vehicleId',
            'licenseTypeId',
            'licensePurposeId',
            'routeId',
            'licenseApplicationId'
        ]);
        
        $this->licenseStartDate = date('Y-m-d');
        $this->licenseEndDate = date('Y-m-d', strtotime('+1 year'));
        $this->licenseStatus = 'Active';
    }

    public function render()
    {
        // Get data for dropdowns
        $licenseTypes = LicenseType::all();
        $licensePurposes = LicensePurpose::all();
        $routes = Route::all();
        $vehicleOwners = VehicleOwner::all();
        
        // Get vehicles based on selected owner
        $vehicles = [];
        if (!empty($this->vehicleOwnerId)) {
            $vehicles = Vehicle::where('vehicle_owner_id', $this->vehicleOwnerId)->get();
        } else {
            $vehicles = Vehicle::all();
        }

        return view('livewire.license.license-form', [
            'licenseTypes' => $licenseTypes,
            'licensePurposes' => $licensePurposes,
            'routes' => $routes,
            'vehicles' => $vehicles,
            'vehicleOwners' => $vehicleOwners,
        ])->layout('layouts.app');
    }
}