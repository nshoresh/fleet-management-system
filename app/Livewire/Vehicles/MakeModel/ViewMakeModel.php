<?php

namespace App\Livewire\Vehicles\MakeModel;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use Illuminate\Support\Facades\DB;

class ViewMakeModel extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $selectedMake = null;
    public $showModels = false;
    public $models = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected $listeners = [
        'refreshMakes' => '$refresh',
        'makeUpdated' => '$refresh',
        'makeDeleted' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function viewModels($makeId)
    {
        $this->selectedMake = VehicleMake::find($makeId);
        $this->models = VehicleMakeModel::where('vehicle_make_id', $makeId)
            ->orderBy('name', 'asc')
            ->get();
        $this->showModels = true;
    }

    public function closeModelsView()
    {
        $this->showModels = false;
        $this->selectedMake = null;
        $this->models = [];
    }

    public function getMakesProperty()
    {
        return VehicleMake::query()
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getModelsCountProperty()
    {
        return DB::table('vehicle_models')
            ->select('vehicle_make_id', DB::raw('count(*) as count'))
            ->groupBy('vehicle_make_id')
            ->pluck('count', 'vehicle_make_id')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.vehicles.make-model.view-make-model', [
            'makes' => $this->makes,
            'modelsCount' => $this->modelsCount,
        ])/*->layout('layouts.app')*/;
    }
}
