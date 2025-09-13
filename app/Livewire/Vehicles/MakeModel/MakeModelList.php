<?php

namespace App\Livewire\Vehicles\MakeModel;

use Livewire\Component;
use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use Livewire\WithPagination;

class MakeModelList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $editMode = false;
    public $showModal = false;
    public $showDeleteModal = false;
    //public $confirmingRouteDeletion = false;

    // Form fields
    public $modelsId;
    public $name = '';
    public $vehicle_make_id;
    public $description = '';
    public $year = '';
    public $body_type = '';

    public $search = '';
    public $makeFilter = '';
    public $bodyTypeFilter = '';
    public $yearFilter = '';
    public $perPage = 10;

    // Listeners
    protected $listeners = ['refresh' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'makeFilter' => ['except' => ''],
        'bodyTypeFilter' => ['except' => ''],
        'yearFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public $bodyTypeOptions = [
        'Truck' => 'Truck',
        'Trailer' => 'Trailer',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMakeFilter()
    {
        $this->resetPage();
    }

    public function updatingBodyTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingYearFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }
    public function edit($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->modelsId = $id;

        $models = VehicleMakeModel::findOrFail($id);
        $this->name = $models->name;
        $this->vehicle_make_id = $models->vehicle_make_id;
        $this->description = $models->description;
        $this->body_type = $models->body_type;
        $this->year = $models->year;

        $this->showModal = true;
    }
    public function show($id)
    {
        $this->resetForm();
        $this->editMode = false; // We're just viewing, not editing
        $this->modelsId = $id;

        $models = VehicleMakeModel::findOrFail($id);
        $this->name = $models->name;
        $this->vehicle_make_id = $models->vehicle_make_id;
        $this->description = $models->description;
        $this->body_type = $models->body_type;
        $this->year = $models->year;

        $this->showModal = true; // Show the modal in view-only mode
    }

    // Save vehicle type (create or update)
    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255|unique:vehicle_make_models,name' . ($this->editMode ? ',' . $this->modelsId : ''),
            'description' => 'nullable|string',
            'body_type' => 'required|string',
            'year' => 'required|string',
            'vehicle_make_id' => 'required|exists:vehicle_makes,id',
        ];

        $this->validate($rules);

        if ($this->editMode) {
            $models = VehicleMakeModel::findOrFail($this->modelsId);
            $models->update([
                'name' => $this->name,
                'vehicle_make_id' => $this->vehicle_make_id,
                'description' => $this->description,
                'body_type' => $this->body_type,
                'year' => $this->year,
            ]);

            session()->flash('message', 'Vehicle model updated successfully.');
        } else {
            VehicleMakeModel::create([
                'name' => $this->name,
                'vehicle_make_id' => $this->vehicle_make_id,
                'description' => $this->description,
                'body_type' => $this->body_type,
                'year' => $this->year,
            ]);

            session()->flash('message', 'Vehicle model created successfully.');
        }

        $this->resetForm();
    }

    public function confirmMakeModelDeletion($id)
    {
        $this->modelsId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteModel()
    {
        try {
            $models = VehicleMakeModel::find($this->modelsId);

            if ($models) {
                $modelName = $models->name;
                $models->delete();
                session()->flash('message', "Vehicle model '$modelName' deleted successfully.");
                $this->showDeleteModal = false;  // <-- Move inside the success case
                return true;
            }
            
            $this->showDeleteModal = false;  // <-- Also hide if model wasn't found
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting vehicle model: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete vehicle model. Please try again.');
            return false;
        }
    }

    public function resetForm()
    {
        $this->modelsId = null;
        $this->name = '';
        $this->vehicle_make_id = '';
        $this->description = '';
        $this->body_type = '';
        $this->year = '';
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        $makes = VehicleMake::orderBy('name')->get();

        $bodyTypes = VehicleMakeModel::select('body_type')
            ->whereNotNull('body_type')
            ->distinct()
            ->orderBy('body_type')
            ->pluck('body_type');

        $years = VehicleMakeModel::select('year')
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $models = VehicleMakeModel::with('vehicleMake')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('vehicleMake', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->makeFilter, function ($query) {
                $query->where('vehicle_make_id', $this->makeFilter);
            })
            ->when($this->bodyTypeFilter, function ($query) {
                $query->where('body_type', $this->bodyTypeFilter);
            })
            ->when($this->yearFilter, function ($query) {
                $query->where('year', $this->yearFilter);
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.vehicles.make-model.make-model-list', [
            'models' => $models,
            'makes' => $makes,
            'bodyTypes' => $bodyTypes,
            'years' => $years,
        ])/*->layout('layouts.app')*/;
    }
}
