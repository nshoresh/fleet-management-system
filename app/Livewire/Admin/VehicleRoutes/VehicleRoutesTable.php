<?php

namespace App\Livewire\Admin\VehicleRoutes;

use App\Models\Route;
use App\Models\RouteType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class VehicleRoutesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'route_name';
    public $perPage = 10;
    public $routeTypeFilter = '';
    public $sortDirection = 'asc';


    // Form fields
    public $routeId;
    public $route_name;
    public $route_type_id;

    // UI states
    public $showModal = false;
    public $editMode = false;
    public $isModalOpen = false;
    public $confirmingRouteDeletion = false;
    //public $routeIdBeingDeleted;

    protected $listeners = ['refreshRoutes' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRouteTypeFilter()
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
        $this->routeId = $id;

        $route = Route::findOrFail($id);
        $this->route_name = $route->route_name;
        $this->route_type_id = $route->route_type_id;

        $this->showModal = true;
    }

    public function show($id)
    {
        $this->resetForm();
        $this->editMode = false; // We're just viewing, not editing
        $this->routeId = $id;

        $route = Route::findOrFail($id);
        $this->route_name = $route->route_name;
        $this->route_type_id = $route->route_type_id;

        $this->showModal = true; // Show the modal in view-only mode
    }

    public function save()
    {
        $rules = [
        'route_name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('routes', 'route_name')->ignore($this->routeId),
            ],
        'route_type_id' => 'required|exists:route_types,id',
        ];

         $this->validate($rules);

        if ($this->editMode) {
            $route = Route::findOrFail($this->routeId);
            $route->update([
                'route_name' => $this->route_name,
                'route_type_id' => $this->route_type_id,
            ]);

            session()->flash('message', 'Route updated successfully.');
        } else {
            Route::create([
                'route_name' => $this->route_name,
                'route_type_id' => $this->route_type_id,
            ]);

            session()->flash('message', 'Route created successfully.');
        }

        $this->resetForm();
    }
    public function confirmRouteDeletion($id)
    {
        $this->routeId = $id;
        $this->confirmingRouteDeletion = true;
    }

    public function deleteRoute()
    {
        try {
            $route = Route::findOrFail($this->routeId);
            $route->delete();

            session()->flash('message', 'Route deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Cannot delete this route as it may be in use.');
        }

        $this->confirmingRouteDeletion = false;
    }

    // Reset form fields
    public function resetForm()
    {
        $this->routeId = null;
        $this->route_name = '';
        $this->route_type_id = '';
        $this->showModal = false;
        $this->confirmingRouteDeletion = false;
        $this->resetErrorBag();
    }

    public function getRouteTypesProperty()
    {
        return RouteType::orderBy('route_type_name')->get();
    }

    public function render()
    {
        $query = Route::query()
            ->with('routeType')
            ->where(function ($query) {
                $query->where('routes.route_name', 'like', '%' . $this->search . '%');
            });

        // Apply route type filter if set
        if ($this->routeTypeFilter) {
            $query->where('routes.route_type_id', $this->routeTypeFilter);
        }

        // Special handling for sorting by route type name
        if ($this->sortField === 'routeType') {
            $routes = $query->join('routeTypes', 'routes.route_type_id', '=', 'routeTypes.id')
                ->select('routes.*') // Keep only route columns
                ->orderBy('routeTypes.route_type_name', $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            $routes = $query->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return view(
            'livewire.admin.vehicle-routes.vehicle-routes-table',
            [
                'routes' => $routes,
                'routeTypes' => $this->routeTypes,
            ]
        );
    }
}
