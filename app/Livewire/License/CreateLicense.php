<?php

namespace App\Livewire\License;

use Illuminate\Support\Facades\Auth;
use App\Models\RouteType;
use App\Models\VehicleMake;
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

    /*public function mount()
    {
        // ✅ Prefill fields from LicenseApplication if vehicleId is passed
        $vehicleId = request()->query('vehicleId');

        if ($vehicleId) {
            $licenseApp = LicenseApplication::with(['vehicle', 'licenseType'])
                ->where('vehicle_id', $vehicleId)
                ->latest()
                ->first();

            if ($licenseApp) {
                $this->vehicle_id = $licenseApp->vehicle_id;
                $this->vehicle_owners_id = $licenseApp->vehicle->vehicle_owner_id ?? null;
                $this->registration_number = $licenseApp->vehicle->license_plate ?? '';
                $this->license_type_id = $licenseApp->license_type_id;
                $this->license_purpose_id = $licenseApp->purpose
                    ? LicensePurpose::where('purpose_name', $licenseApp->purpose)->value('id')
                    : null;
                $this->license_application_id = $licenseApp->id;

                // Dates
                $this->license_start_date = $licenseApp->submission_date;
                $this->license_end_date = $licenseApp->expiry_date ?? null;
            }
        }
    }*/

    public function mount($applicationId = null)
    {
        // ✅ Prefill fields from LicenseApplication if vehicleId is passed
        $vehicleId = request()->query('vehicleId');
        if ($applicationId) {
            $licenseApp = LicenseApplication::with('vehicle')->findOrFail($applicationId);

            $this->license_application_id = $licenseApp->id;
            $this->vehicle_id = $licenseApp->vehicle_id;
            $this->vehicle_owners_id = $licenseApp->vehicle->vehicle_owner_id ?? null;
            $this->registration_number = optional($licenseApp->makeType)->name . ' ' .
                                    optional($licenseApp->vehicle)->model . ' ' .
                                    optional($licenseApp->vehicle)->year . ' ' .
                                    optional($licenseApp->vehicle)->license_plate;

            //$this->registration_number = $licenseApp->vehicle->license_plate ?? '';
            $this->license_type_id = $licenseApp->license_type_id;
            $this->license_purpose_id = $licenseApp->purpose
                ? LicensePurpose::where('purpose_name', $licenseApp->purpose)->value('id')
                : null;

            $this->license_start_date = $licenseApp->submission_date;
            $this->license_end_date = $licenseApp->expiry_date ?? null;
        }
        elseif ($vehicleId) {
            // fallback if only vehicleId provided
            $licenseApp = LicenseApplication::with('vehicle.make')
            ->where('vehicle_id', $vehicleId)
            ->latest()
            ->first();
            if ($licenseApp) {
                $this->license_application_id = $licenseApp->id;
                $this->vehicle_id = $licenseApp->vehicle_id;
                $this->vehicle_owners_id = $licenseApp->vehicle->vehicle_owner_id ?? null;
                $this->registration_number = optional($licenseApp->makeType)->name . ' ' .
                                        optional($licenseApp->vehicle)->model . ' ' .
                                        optional($licenseApp->vehicle)->year . ' ' .
                                        optional($licenseApp->vehicle)->license_plate;

                //$this->registration_number = $licenseApp->vehicle->license_plate ?? '';
                $this->license_type_id = $licenseApp->license_type_id;
                $this->license_purpose_id = $licenseApp->purpose
                    ? LicensePurpose::where('purpose_name', $licenseApp->purpose)->value('id')
                    : null;

                $this->license_start_date = $licenseApp->submission_date;
                $this->license_end_date = $licenseApp->expiry_date ?? null;
            }
        }
    }

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

        return redirect()->route('admin.license.list'); // redirect instead of reset()
    }

    public function render()
    {
        return view('livewire.license.create-license', [ // ✅ Correct view for Admin
            'vehicleOwners' => VehicleOwner::all(),
            'vehicles' => Vehicle::all(),
            'licenseTypes' => LicenseType::all(),
            'licensePurposes' => LicensePurpose::all(),
            'routes' => Route::all(),
            'route_types' => RouteType::all(),
            'vehicleMakes' => VehicleMake::all(),
            'applications' => LicenseApplication::all(),
        ]);
    }
}
