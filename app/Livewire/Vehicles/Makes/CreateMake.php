<?php

namespace App\Livewire\Vehicles\Makes;

use Livewire\Component;
use App\Models\VehicleMake;

class CreateMake extends Component
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
            $this->dispatch('makes.create'); // Notify parent if needed
            return redirect()->route('vehicles.makes'); // Redirect after success
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create vehicle make: ' . $e->getMessage());
        }

        $this->resetForm();
    }
    public function resetForm()
    {
        //$this->vehicleTypeId = null;
        $this->name = '';
        $this->description = '';
        $this->country = '';
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.vehicles.makes.create-make');
    }
}