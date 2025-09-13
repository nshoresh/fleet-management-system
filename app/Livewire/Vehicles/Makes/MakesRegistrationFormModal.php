<?php

namespace App\Livewire\Vehicles\Makes;

use Livewire\Component;
use App\Models\VehicleMake;
use Illuminate\Support\Facades\Validator;

class MakesRegistrationFormModal extends Component
{
    public $name = '';
    public $country = '';
    public $description = '';

    public $showModal = false;
    public $showDeleteModal = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:vehicle_makes,name',
        'country' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ];

    protected $messages = [
        'name.required' => 'The make name is required.',
        'name.unique' => 'This vehicle make already exists.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveMake()
    {
        $validatedData = $this->validate();

        try {
            VehicleMake::create($validatedData);

            $this->resetForm();
            session()->flash('message', 'Vehicle make created successfully!');
            $this->dispatch('vehicles.makes');
            return redirect()->route('vehicles.makes'); // Redirect after success
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create vehicle make: ' . $e->getMessage());
        }
    }

    /*public function resetForm()
    {
        //$this->vehicleTypeId = null;
        $this->name = '';
        $this->description = '';
        $this->country = '';
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetErrorBag();
    }*/


    public function resetForm()
    {
        $this->reset(['name', 'country', 'description']);
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.vehicles.makes.makes-registration-form-modal')/*->layout('layouts.app')*/;
    }
}
