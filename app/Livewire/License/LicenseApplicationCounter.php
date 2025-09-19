<?php

namespace App\Livewire\License;

use Livewire\Component;
use App\Models\LicenseApplication;

class LicenseApplicationCounter extends Component
{
    public int $count = 0;

    protected $listeners = ['applicationCreated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = LicenseApplication::where('status', 'Pending')->count();
    }

    public function render()
    {
        return view('livewire.license.license-application-counter');
    }
}
