<?php

namespace App\Livewire\Admin\Regions;

use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class RegionsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Form fields
    public $regionId;
    public $name;
    public $code;

    // UI states
    public $isModalOpen = false;
    public $confirmingRegionDeletion = false;
    public $regionIdBeingDeleted;

    protected $listeners = ['refreshRegions' => '$refresh'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:regions,name,' . $this->regionId,
            'code' => 'nullable|string|max:50|unique:regions,code,' . $this->regionId,
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
        $this->reset(['regionId', 'name', 'code']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->regionId = null;
        $this->name = '';
        $this->code ='';
    }

    public function create()
    {
        $this->validate();

        Region::create([
            'name' => $this->name,
            'code' => $this->code,
        ]);

        session()->flash('message', 'Region created successfully.');

        $this->closeModal();
        $this->resetForm();
        //$this->dispatch('region-saved', ['message' => 'Region created successfully!']);
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        $this->regionId = $id;
        $this->name = $region->name;
        $this->code = $region->code;

        $this->isModalOpen = true;
        //$this->openModal();
    }

    public function update()
    {
        $this->validate();

        $region = Region::find($this->regionId);
        $region->update([
            'name' => $this->name,
            'code' => $this->code,
        ]);

        session()->flash('message', 'Region updated successfully');

        $this->closeModal();
        $this->resetForm();
        //$this->dispatch('region-saved', ['message' => 'Region updated successfully!']);
    }

    public function save()
    {
        if ($this->regionId) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function confirmRegionDeletion($id)
    {
        $this->confirmingRegionDeletion = true;
        $this->regionIdBeingDeleted = $id;
    }

    public function deleteRegion()
    {
        $region = Region::findOrFail($this->regionIdBeingDeleted);
        $region->delete();

        session()->flash('message', 'Region deleted successfully.');
        $this->confirmingRegionDeletion = false;
        //$this->dispatch('region-deleted', ['message' => 'Region deleted successfully!']);
    }
    public function render()
    {
        $regions = Region::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.regions.regions-table', [
            'regions' => $regions,
        ])->layout('layouts.app');
    }
}
