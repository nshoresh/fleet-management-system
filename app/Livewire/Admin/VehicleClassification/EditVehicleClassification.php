<?php

namespace App\Livewire\Admin\VehicleClassification;

use Livewire\Component;
use App\Models\VehicleClassification;

class EditVehicleClassification extends Component
{
    public $vehicleClassificationId;
    public $classification_name;
    public $min_weight;
    public $max_weight;
    public $rdc_fee;
    public $description;
    public $is_active = false;


    //public $showEditModal = false;
    //public $editingClassificationId = null;

    protected $rules = [
        'classification_name' => 'required|string|max:255',
        'min_weight' => 'nullable|numeric|min:0',
        'max_weight' => 'nullable|numeric|min:0',
        'rdc_fee' => 'required|numeric|min:0',
        'is_active' => 'boolean',
        'description' => 'nullable|string|max:1000',
    ];

    public function mount($vehicleClassificationId)
    {
        $classification = VehicleClassification::findOrFail($vehicleClassificationId);

        $this->vehicleClassificationId = $classification->id;
        $this->classification_name = $classification->classification_name;
        $this->min_weight = $classification->min_weight;
        $this->max_weight = $classification->max_weight;
        $this->rdc_fee = $classification->rdc_fee;
        $this->description = $classification->description;
        $this->is_active = $classification->is_active;
    }

    public function updateVehicleClassification()
    {
        $this->validate();

        try {
            $classification = VehicleClassification::findOrFail($this->vehicleClassificationId);

            $classification->update([
                'classification_name' => $this->classification_name,
                'min_weight' => $this->min_weight,
                'max_weight' => $this->max_weight,
                'rdc_fee' => $this->rdc_fee,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', 'Vehicle classification updated successfully.');

            // Redirect to the table view
            return redirect()->route('admin.vehicle-classifications');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update vehicle classification: ' . $e->getMessage());
        }
    }
    /*
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingClassificationId = null;
    }
        */
    public function render()
    {
        return view('livewire.admin.vehicle-classification.edit-vehicle-classification');
    }
}
