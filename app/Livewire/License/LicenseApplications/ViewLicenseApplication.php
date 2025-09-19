<?php

namespace App\Livewire\License\LicenseApplications;

use Livewire\Component;
use App\Models\LicenseApplication;
class ViewLicenseApplication extends Component
{
    public $application;

    public function mount($id)
    {
        // Load application with relationships
        $this->application = LicenseApplication::with([
            'vehicle.make',
            'vehicle.makeModel',
            'vehicle.vehicleOwner',
            'licenseType',
            'documents',
        ])->findOrFail($id);
    }
    public function render()
    {
        return view('livewire.license.license-applications.view-license-application');
    }
}
