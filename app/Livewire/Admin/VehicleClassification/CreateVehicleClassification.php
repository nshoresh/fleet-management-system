<?php

namespace App\Livewire\Admin\VehicleClassification;

use App\Models\VehicleClassification;
use Livewire\Component;

class CreateVehicleClassification extends Component
{
    // Form fields
    public $classification_name = '';
    public $min_weight = '';
    public $max_weight = '';
    public $rdc_fee = '';
    public $description = '';
    public $is_active = false;

    // Dynamic validation rules
    protected function rules()
    {
        return [
            'classification_name' => 'required|string|max:255|unique:vehicle_classifications,classification_name',
            'min_weight' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0',
            'rdc_fee' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    public function message()
    {
        return [
            'classification_name.required' => 'The classification name is required.',
        ];
    }

    public function createVehicleClassification()
    {
        $this->validate();

        VehicleClassification::create([
            'classification_name' => $this->classification_name,
            'min_weight' => $this->min_weight,
            'max_weight' => $this->max_weight,
            'rdc_fee' => $this->rdc_fee,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Vehicle classification created successfully.');

        return redirect()->route('admin.vehicle-classifications');
    }

    public function resetFields()
    {
        $this->reset([
            'classification_name',
            'min_weight',
            'max_weight',
            'rdc_fee',
            'description',
            'is_active']);
    }

    public function render()
    {
        return view('livewire.admin.vehicle-classification.create-vehicle-classification')
            ->layout('layouts.app');
    }
}
