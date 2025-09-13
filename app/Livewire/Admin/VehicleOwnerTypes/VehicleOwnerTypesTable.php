<?php

namespace App\Livewire\Admin\VehicleOwnerTypes;

use Livewire\Component;
use App\Models\VehicleOwnerType;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class VehicleOwnerTypesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Form fields
    public $vehicleOwnerTypeId;
    public $name = '';
    public $description = '';

    // Listeners
    protected $listeners = ['refresh' => '$refresh'];

    // Reset pagination when perPage is updated
    public function updatingPerPage()
    {
        $this->resetPage();
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
        $this->vehicleOwnerTypeId = $id;

        $ownerType = VehicleOwnerType::findOrFail($id);
        $this->name = $ownerType->name;
        $this->description = $ownerType->description;

        $this->showModal = true;
    }

    // Show delete confirmation modal
    public function confirmDelete($id)
    {
        $this->vehicleOwnerTypeId = $id;
        $this->showDeleteModal = true;
    }

    // Delete vehicle owner type
    public function delete()
    {
        $ownerType = VehicleOwnerType::findOrFail($this->vehicleOwnerTypeId);

        try {
            $ownerType->delete();
            session()->flash('message', 'Vehicle owner type deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Cannot delete this vehicle owner type as it may be in use.');
        }

        $this->showDeleteModal = false;
    }

    // Save vehicle owner type (create or update)
    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255|unique:vehicle_owner_types,name' . ($this->editMode ? ',' . $this->vehicleOwnerTypeId : ''),
            'description' => 'nullable|string',
        ];

        $this->validate($rules);

        if ($this->editMode) {
            $ownerType = VehicleOwnerType::findOrFail($this->vehicleOwnerTypeId);
            $ownerType->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('message', 'Vehicle type updated successfully.');
        } else {
            VehicleOwnerType::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('message', 'Vehicle type created successfully.');
        }

        $this->resetForm();
    }

    // Reset form fields
    public function resetForm()
    {
        $this->vehicleOwnerTypeId = null;
        $this->name = '';
        $this->description = '';
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetErrorBag();
    }

    // Sorting
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    // Computed property for vehicle owner types
    public function getVehicleOwnerTypesProperty()
    {
        return VehicleOwnerType::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
    // Render the view
    public function render()
    {
        return view('livewire.admin.vehicle-owner-types.vehicle-owner-types-table', [
            'vehicleOwnerTypes' => $this->vehicleOwnerTypes,
            ])/*->layout('layouts.app')*/;
    }

}
