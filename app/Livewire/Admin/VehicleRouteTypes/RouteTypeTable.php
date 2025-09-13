<?php

namespace App\Livewire\Admin\VehicleRouteTypes;

use Livewire\Component;
use App\Models\RouteType;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class RouteTypeTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'route_type_name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Form fields
    public $routeTypeId;
    public $route_type_name;
    public $description;

    // UI states
    public $isModalOpen = false;
    public $confirmingRouteTypeDeletion = false;
    public $routeTypeIdBeingDeleted;

    protected $listeners = ['refreshRouteTypes' => '$refresh'];

    protected function rules()
    {
        return [
            'route_type_name' => 'required|string|max:255|unique:routeTypes,route_type_name,' . $this->routeTypeId,
            'description' => 'nullable|string|max:50|unique:routeTypes,description,' . $this->routeTypeId,
        ];
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['routeTypeId', 'route_type_name', 'description']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function create()
    {
        $this->validate();

        RouteType::create([
            'route_type_name' => $this->route_type_name,
            'description' => $this->description,
        ]);

        $this->closeModal();
        $this->dispatch('route-type-saved', ['message' => 'Route Type created successfully!']);
    }

    public function edit($id)
    {
        $routeTypes = RouteType::findOrFail($id);
        $this->routeTypeId = $id;
        $this->route_type_name = $routeTypes->route_type_name;
        $this->description = $routeTypes->description;

        $this->openModal();
    }

    public function update()
    {
        $this->validate();

        $routeTypes = RouteType::find($this->routeTypeId);
        $routeTypes->update([
            'route_type_name' => $this->route_type_name,
            'description' => $this->description,
        ]);

        $this->closeModal();
        $this->dispatch('route-type-saved', ['message' => 'Route Type updated successfully!']);
    }

    public function save()
    {
        if ($this->routeTypeId) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function confirmRegionDeletion($id)
    {
        $this->confirmingRouteTypeDeletion = true;
        $this->routeTypeIdBeingDeleted = $id;
    }

    public function deleteRouteType()
    {
        $routeTypes = RouteType::findOrFail($this->routeTypeIdBeingDeleted);
        $routeTypes->delete();

        $this->confirmingRouteTypeDeletion = false;
        $this->dispatch('route-type-deleted', ['message' => 'Route Type deleted successfully!']);
    }
    public function render()
    {
        $routeTypes = RouteType::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.vehicle-route-types.route-type-table', [
            'routeTypes' => $routeTypes,
        ])->layout('layouts.app');
    }
}
