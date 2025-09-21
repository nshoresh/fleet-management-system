<?php

namespace App\Livewire\Vehicles\Makes;

use Livewire\Component;
use App\Models\VehicleMake;

class ViewMake extends Component
{
    public $makeId;
    public $make;
    protected $listeners = ['vehicleMakeUpdated' => 'loadVehicleMake', 'openModal'];
    // protected $listeners = ['openModal'];
    public function mount($id)
    {
        $this->makeId = $id;
        $this->loadVehicleMake($id);
    }

    public function loadVehicleMake($makeId)
    {
        $this->make = VehicleMake::findOrFail($makeId);
    }

    public function openEditModal()
    {
        // Dispatch an event to open the modal in the modal component
        $this->dispatch('openModal', $this->makeId);
    }
    public function render()
    {
        return view('livewire.vehicles.makes.view-make')/*->layout('layouts.app')*/;
    }
}
