<?php
namespace App\Livewire\Admin\VehicleOwners\VehicleDocuments;

use Livewire\Component;
use App\Models\VehicleOwner;
use App\Models\Vehicle;

class Document extends Component
{
    public $ownerId;
    public $vehicleId;
    public $vehicleOwner;
    public $vehicle;

    public function mount($ownerId, $vehicleId)
    {
        $this->ownerId = $ownerId;
        $this->vehicleId = $vehicleId;
        $this->vehicleOwner = VehicleOwner::findOrFail($ownerId);
        $this->vehicle = Vehicle::findOrFail($vehicleId);
    }

    public function render()
    {
        return view('livewire.admin.vehicle-owners.vehicle-documents.document')
            ->with([
                'documents' => $this->vehicle->documents
            ]);
    }
}