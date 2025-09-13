<?php

namespace App\Livewire\License;

use App\Models\License;
use App\Models\VehicleOwner;
use App\Models\Vehicle;
use App\Models\LicenseType;
use App\Models\LicensePurpose;
use App\Models\Route;
use App\Models\LicenseApplication;
use Livewire\Component;

class CreateLicense extends Component
{
    public $vehicle_owners_id;
    public $vehicle_id;
    public $registration_number;
    public $license_type_id;
    public $license_purpose_id;
    public $route_id;
    public $license_start_date;
    public $license_end_date;
    public $license_status = 'Active';
    public $license_application_id;

    protected $rules = [
        'vehicle_owners_id' => 'required|exists:vehicle_owners,id',
        'vehicle_id' => 'required|exists:vehicles,id',
        'registration_number' => 'required|string|max:255',
        'license_type_id' => 'required|exists:license_types,id',
        'license_purpose_id' => 'required|exists:license_purposes,id',
        'route_id' => 'nullable|exists:routes,id',
        'license_start_date' => 'required|date',
        'license_end_date' => 'required|date|after_or_equal:license_start_date',
        'license_status' => 'required|in:Active,Expired',
        'license_application_id' => 'required|exists:license_applications,id',
    ];

    public function store()
    {
        $this->validate();

        License::create([
            'vehicle_owners_id' => $this->vehicle_owners_id,
            'vehicle_id' => $this->vehicle_id,
            'registration_number' => $this->registration_number,
            'license_type_id' => $this->license_type_id,
            'license_purpose_id' => $this->license_purpose_id,
            'route_id' => $this->route_id,
            'license_start_date' => $this->license_start_date,
            'license_end_date' => $this->license_end_date,
            'license_status' => $this->license_status,
            'license_application_id' => $this->license_application_id,
        ]);

        session()->flash('message', 'License created successfully.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.license.create-license', [
            'vehicleOwners' => VehicleOwner::all(),
            'vehicles' => Vehicle::all(),
            'licenseTypes' => LicenseType::all(),
            'licensePurposes' => LicensePurpose::all(),
            'routes' => Route::all(),
            'applications' => LicenseApplication::all(),
        ]);
    }
}
