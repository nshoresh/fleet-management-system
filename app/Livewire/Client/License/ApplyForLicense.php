<?php
//namespace App\Http\Livewire;

namespace App\Livewire\Client\License;

use Livewire\Component;
use App\Models\User;
use App\Models\LicenseType;
use App\Models\LicenseApplication;
use Illuminate\Support\Facades\Auth;

class ApplyForLicense extends Component
{
    public $licenseTypes;
    public $selectedLicenseType;
    public $applicationNumber;
    public $submissionDate;
    public $expiryDate;
    public $purpose;
    public $supportingDocuments;
    public $additionalInformation;
    public $termsAccepted;

    public function mount()
    {
        $this->licenseTypes = LicenseType::all();
        $this->selectedLicenseType = null;
        $this->applicationNumber = null;
        $this->submissionDate = null;
        $this->expiryDate = null;
        $this->purpose = null;
        $this->supportingDocuments = null;
        $this->additionalInformation = null;
        $this->termsAccepted = false;
    }

    public function render()
    {
        return view('livewire.apply-for-license');
    }

    public function submitApplication()
    {
        $this->validate([
            'selectedLicenseType' => 'required',
            'applicationNumber' => 'required|unique:license_applications,application_number',
            'submissionDate' => 'required|date',
            'expiryDate' => 'nullable|date',
            'purpose' => 'nullable|string',
            'supportingDocuments' => 'nullable|array',
            'additionalInformation' => 'nullable|string',
            'termsAccepted' => 'required|boolean',
        ]);

        $licenseApplication = new LicenseApplication();
        $licenseApplication->user_id = Auth::id();
        $licenseApplication->license_type_id = $this->selectedLicenseType;
        $licenseApplication->application_number = $this->applicationNumber;
        $licenseApplication->submission_date = $this->submissionDate;
        $licenseApplication->expiry_date = $this->expiryDate;
        $licenseApplication->purpose = $this->purpose;
        $licenseApplication->supporting_documents = $this->supportingDocuments;
        $licenseApplication->additional_information = $this->additionalInformation;
        $licenseApplication->terms_accepted = $this->termsAccepted;
        $licenseApplication->save();

        session()->flash('success', 'Application submitted successfully!');

        return redirect()->route('apply-for-license');
    }
}
/*class AplyForLicense extends Component
{
    public function render()
    {
        return view('livewire.client.license.aply-for-license');
    }
}*/
