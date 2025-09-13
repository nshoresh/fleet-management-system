<?php

namespace App\Livewire\Client\License;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LicenseApplication;
use App\Models\LicenseType;
use App\Models\LicensePurpose;
use App\Models\Route;
use App\Models\RouteType;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateLicense extends Component
{
    use WithFileUploads;

    public $vehicle_id;
    public $selectedLicenseType;
    public $applicationNumber;
    public $registrationNumber;
    public $submissionDate;
    public $expiryDate;
    public $purpose;
    public $supportingDocuments;
    public $additionalInformation;
    public $termsAccepted = false;

    public $selectedVehicle;

    protected function rules()
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'selectedLicenseType' => 'required|exists:license_types,id',
            'applicationNumber' => 'required|unique:license_applications,application_number',
            'submissionDate' => 'required|date',
            'expiryDate' => 'nullable|date',
            'purpose' => 'nullable|string',
            'supportingDocuments.*' => 'file|max:10240',
            'additionalInformation' => 'nullable|string',
            'termsAccepted' => 'required|boolean',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedVehicleId($value)
    {
        $this->selectedVehicle = Vehicle::find($value);
    }

    public function mount($vehicleId = null)
    {
        if ($vehicleId) {
            $this->vehicle_id = $vehicleId;
            $this->selectedVehicle = Vehicle::find($vehicleId);
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Each user is tied to a vehicle_owner
        $vehicleOwnerId = $user->vehicle_owner_id;

        return view('livewire.client.license.create-license', [
            'vehicles' => $vehicleOwnerId
                ? Vehicle::where('vehicle_owner_id', $vehicleOwnerId)->get()
                : collect(),
            'license_type' => LicenseType::all(),
            'license_purpose' => LicensePurpose::all(),
            'routes' => Route::all(),
            'route_types' => RouteType::all(),
            'vehicleMakes' => VehicleMake::all(),
        ]);
    }


    public function submitApplication()
    {
        $this->validate();

        $user = Auth::user();

        // ✅ Use relationship instead of querying user_id
        $vehicleOwner = $user->vehicleOwner;

        if (!$vehicleOwner) {
            throw new \Exception('No vehicle owner profile found for this account.');
        }

        // Create new LicenseApplication
        $licenseApplication = new LicenseApplication();

        $licenseApplication->user_id = $user->id;
        $licenseApplication->vehicle_id = $this->vehicle_id;   // vehicle chosen by owner
        $licenseApplication->license_type_id = $this->selectedLicenseType;
        $licenseApplication->application_number = $this->applicationNumber;
        $licenseApplication->submission_date = $this->submissionDate;
        $licenseApplication->expiry_date = $this->expiryDate;
        $licenseApplication->purpose = $this->purpose;
        $licenseApplication->additional_information = $this->additionalInformation;
        $licenseApplication->terms_accepted = $this->termsAccepted;
        $licenseApplication->status = 'Pending';

        $licenseApplication->save();


        // ✅ Handle file uploads if documents exist
        if ($this->supportingDocuments) {
            foreach ($this->supportingDocuments as $document) {
                $path = $document->store('license_documents', 'public');

                $licenseApplication->documents()->create([
                    'file_path' => $path,
                    'uploaded_by' => $user->id,
                ]);
            }
        }

        session()->flash('success', 'License application submitted successfully.');

        return redirect()->route('client.app.license_list');
    }

}
