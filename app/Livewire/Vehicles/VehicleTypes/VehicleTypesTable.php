<?php

namespace App\Livewire\Vehicles\VehicleTypes;

use App\Models\VehicleType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class VehicleTypesTable extends Component
{
    use WithPagination;

    // Specify the theme for pagination
    protected $paginationTheme = 'tailwind';

    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Form fields
    public $vehicleTypeId;
    public $name = '';
    public $description = '';

    // Listeners
    protected $listeners = ['refresh' => '$refresh'];

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset pagination when perPage is updated
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    // Sort results
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    // Show create modal
    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    // Show edit modal
    public function edit($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->vehicleTypeId = $id;

        $vehicleType = VehicleType::findOrFail($id);
        $this->name = $vehicleType->name;
        $this->description = $vehicleType->description;

        $this->showModal = true;
    }

    // Show delete confirmation modal
    public function confirmDelete($id)
    {
        $this->vehicleTypeId = $id;
        $this->showDeleteModal = true;
    }

    // Save vehicle type (create or update)
    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255|unique:vehicle_types,name' . ($this->editMode ? ',' . $this->vehicleTypeId : ''),
            'description' => 'nullable|string',
        ];

        $this->validate($rules);

        if ($this->editMode) {
            $vehicleType = VehicleType::findOrFail($this->vehicleTypeId);
            $vehicleType->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('message', 'Vehicle type updated successfully.');
        } else {
            VehicleType::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('message', 'Vehicle type created successfully.');
        }

        $this->resetForm();
    }

    // Delete vehicle type
    public function delete()
    {
        $vehicleType = VehicleType::findOrFail($this->vehicleTypeId);

        try {
            $vehicleType->delete();
            session()->flash('message', 'Vehicle type deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Cannot delete this vehicle type as it may be in use.');
        }

        $this->showDeleteModal = false;
    }

    // Reset form fields
    public function resetForm()
    {
        $this->vehicleTypeId = null;
        $this->name = '';
        $this->description = '';
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetErrorBag();
    }

    // Get vehicle types with pagination and sorting
    public function getVehicleTypesProperty()
    {
        return VehicleType::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.vehicles.vehicle-types.vehicle-types-table', [
            'vehicleTypes' => $this->vehicleTypes,
        ])/*->layout('layouts.app')*/;
    }
}
