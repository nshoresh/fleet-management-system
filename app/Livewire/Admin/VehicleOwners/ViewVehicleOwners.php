<?php

namespace App\Livewire\Admin\VehicleOwners;

use Livewire\Component;
use App\Models\VehicleOwner;

class ViewVehicleOwners extends Component
{
    public $vehicleOwnerId;
    public $vehicleOwner;

    public int $fleets_count;
    public int $users_count;

    protected $listeners = ['vehicleOwnerUpdated' => 'loadVehicleOwner', 'openModal'];
    // protected $listeners = ['openModal'];
    public function mount($id)
    {
        $this->vehicleOwnerId = $id;
        $this->loadVehicleOwner();
        $this->fleets_count = $this->vehicleOwner->fleets->count();
        $this->users_count = $this->vehicleOwner->users->count();
    }

    public function verifyVehicleOwner()
    {
        $this->vehicleOwner->update([
            'is_information_verified' => true,
            'status' => 'active'
        ]);
        $this->loadVehicleOwner();
    }
    public function verifyVehicleOwnerDocuments()
    {
        $this->vehicleOwner->update([
            'is_documents_verified' => true,
            'status' => 'active'
        ]);
        $this->loadVehicleOwner();
    }

    public function loadVehicleOwner()
    {
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
        return view('livewire.admin.vehicle-owners.view-vehicle-owners');
            //->layout('layouts.app');
    }
}
