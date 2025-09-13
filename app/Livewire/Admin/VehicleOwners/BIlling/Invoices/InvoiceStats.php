<?php

namespace App\Livewire\Admin\VehicleOwners\BIlling\Invoices;

use App\Models\VehicleOwner;
use Livewire\Component;

class InvoiceStats extends Component
{
    public VehicleOwner $vehicleOwner;
    public int $inVoiceCount = 0;
    public float $totalInvoiceValue = 0.00;
    public function mount($id)
    {
        $this->vehicleOwner = VehicleOwner::find($id);
        $this->inVoiceCount = $this->vehicleOwner->invoices->count();
    }
    public function render()
    {

        return view('livewire.admin.vehicle-owners.b-illing.invoices.invoice-stats');
    }
}
