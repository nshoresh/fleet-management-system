<?php

namespace App\Livewire\Vehicles\Makes;

use Livewire\Component;
use App\Models\VehicleMake;

class EditMake extends Component
{
    public $name;
    public $country;
    public $description;
    public $make;
    public $makeId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'country' => 'required|string|max:20',
        'description' => 'required|string|max:255',
    ];

    protected $messages = [
        'name.required' => 'Make name is required.',
        'country.required' => 'Make country is required.',
        'description.required' => 'Make Description is required.',
    ];

    public function mount(int $id)
    {
        $this->make = VehicleMake::findOrFail($id);
        $this->initializeFormFields();
    }
    
    public function initializeFormFields()
    {
        $this->name = $this->make->name;
        $this->country = $this->make->country;
        $this->description = $this->make->description;
    }

    public function updateVehicleMake()
    {
        $validatedData = $this->validate();

        $this->make->update([
            'name' => $this->name,
            'country' => $this->country,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Vehicle make details updated successfully!');

        return redirect()->route('vehicles.makes.view', $this->make->id);
    }

    public function cancelEdit()
    {
        return redirect()->route('vehicles.makes.view', $this->make->id);
    }
    public function render()
    {
        return view('livewire.vehicles.makes.edit-make')/*->layout('layouts.app')*/;
    }
}
