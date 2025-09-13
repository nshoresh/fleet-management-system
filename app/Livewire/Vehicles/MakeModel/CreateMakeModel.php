<?php

namespace App\Livewire\Vehicles\MakeModel;

use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateMakeModel extends Component
{
    // Public properties for form inputs
    public $vehicle_make_id;
    public $name;
    public $year;
    public $body_type;
    public $description;

    // Property to store vehicle makes for dropdown
    public $vehicleMakes = [];

    // Body type options
    public $bodyTypeOptions = [
        'Sedan' => 'Sedan',
        'SUV' => 'SUV',
        'Hatchback' => 'Hatchback',
        'Coupe' => 'Coupe',
        'Convertible' => 'Convertible',
        'Truck' => 'Truck',
        'Trailer' => 'Trailer',
        'Van' => 'Van',
        'Wagon' => 'Wagon',
        'Crossover' => 'Crossover'
    ];

    // Validation rules
    protected function rules()
    {
        return [
            'vehicle_make_id' => 'required|exists:vehicle_makes,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicle_make_models', 'name')
            ],
            'year' => 'nullable|integer|min:1886|max:' . (date('Y') + 1),
            'body_type' => 'nullable|in:' . implode(',', array_keys($this->bodyTypeOptions)),
            'description' => 'nullable|string|max:1000'
        ];
    }

    // Custom validation messages
    protected function messages()
    {
        return [
            'vehicle_make_id.required' => 'Please select a vehicle make.',
            'vehicle_make_id.exists' => 'Selected vehicle make is invalid.',
            'name.required' => 'Model name is required.',
            'name.unique' => 'This model name already exists.',
            'year.integer' => 'Year must be a valid number.',
            'year.min' => 'Year must be after 1886 (first automobile).',
            'year.max' => 'Year cannot be in the future.',
            'body_type.in' => 'Invalid body type selected.',
            'body_type.required' => 'Body type is required.',
            'description.max' => 'Description cannot exceed 1000 characters.'
        ];
    }

    /*public function getBodyTypeOptionsProperty()
    {
        return [
            'Sedan' => 'Sedan',
            'SUV' => 'SUV',
            'Hatchback' => 'Hatchback',
            'Coupe' => 'Coupe',
            'Convertible' => 'Convertible',
            'Truck' => 'Truck',
            'Trailer' => 'Trailer',
            'Van' => 'Van',
            'Wagon' => 'Wagon',
            'Crossover' => 'Crossover'
        ];
    }*/

    // Lifecycle method to prepare data
    public function mount()
    {
        // Fetch vehicle makes for dropdown
        $this->vehicleMakes = VehicleMake::orderBy('name')->get();
    }

    // Reset form after submission
    public function resetForm()
    {
        $this->reset([
            'vehicle_make_id',
            'name',
            'year',
            'body_type',
            'description'
        ]);
    }

    // Save new vehicle make model
    public function save()
    {
        // Validate input
        $validatedData = $this->validate();

        try {
            // Create new vehicle make model
            $makeModel = VehicleMakeModel::create($validatedData);

            // Flash success message
            session()->flash('success', "Vehicle Model '{$makeModel->name}' created successfully!");

            // Reset form
            $this->resetForm();

            // Optionally dispatch an event if needed
            $this->dispatch('make-model-created', $makeModel->id);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error creating vehicle make model: ' . $e->getMessage());

            // Flash error message
            session()->flash('error', 'Failed to create vehicle model. Please try again.');
        }
    }

    // Render the view
    public function render()
    {
        return view('livewire.vehicles.make-model.create-make-model');
            //->layout('layouts.app');
    }
}
