<?php

namespace App\Livewire\Client\License;

use Livewire\Component;
use App\Models\License;

class EditLicense extends Component
{
    public License $license;

    // Mount injects the License from the route (/{license}/edit)
    public function mount(License $license)
    {
        $this->license = $license;
    }

    // Validation rules
    protected $rules = [
        'license.application_number' => 'required|string|max:255',
        'license.submission_date'    => 'required|date',
        'license.expiry_date'        => 'nullable|date|after_or_equal:license.submission_date',
        'license.purpose'            => 'nullable|string|max:500',
        'license.additional_information' => 'nullable|string|max:1000',
        'license.terms_accepted'     => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $this->license->save();

        session()->flash('success', 'License updated successfully!');

        return redirect()->route('client.app.license_list');
    }

    public function render()
    {
        return view('livewire.client.license.edit-license');
    }
}
