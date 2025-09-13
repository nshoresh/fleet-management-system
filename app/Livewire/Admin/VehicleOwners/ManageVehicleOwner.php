<?php

namespace App\Livewire\Admin\VehicleOwners;

use Livewire\Component;
use App\Models\VehicleOwner;

class ManageVehicleOwner extends Component
{
    public $vehicleOwnerId;
    public $vehicleOwner;

    protected $listeners = ['vehicleOwnerUpdated' => 'loadVehicleOwner'];

    public function mount($id)
    {
        $this->vehicleOwnerId = $id;
        $this->loadVehicleOwner();
    }

    public function loadVehicleOwner()
    {
        //$this->vehicleOwner = VehicleOwner::with('vehicle_owner_type')
            //->findOrFail($this->vehicleOwnerId);

        $this->vehicleOwner = VehicleOwner::with('vehicle_owner_type')
            ->where('uuid', $this->vehicleOwnerId)->firstOrFail();

    }

    public function openEditModal()
    {
        // Dispatch an event to open the modal in the modal component
        $this->dispatch('openModal', $this->vehicleOwnerId);
    }
    public function render()
    {
        return view('livewire.admin.vehicle-owners.manage-vehicle-owner');
    }
}
