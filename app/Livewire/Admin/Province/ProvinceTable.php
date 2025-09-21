<?php

namespace App\Livewire\Admin\Province;

use App\Models\Province;
use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class ProvinceTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $regionFilter = '';

    // Form fields
    public $provinceId;
    public $name;
    public $code;
    public $region_id;

    // UI states
    public $isModalOpen = false;
    public $confirmingProvinceDeletion = false;
    public $provinceIdBeingDeleted;

    protected $listeners = ['refreshProvinces' => '$refresh'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:provinces,name,' . $this->provinceId,
            'code' => 'nullable|string|max:50|unique:provinces,code,' . $this->provinceId,
            'region_id' => 'required|exists:regions,id',
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

    public function updatingRegionFilter()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['provinceId', 'name', 'code', 'region_id']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }
    public function resetForm()
    {
        $this->provinceId = null;
        $this->region_id = '';
        $this->name = '';
        $this->code = '';
    }
    public function create()
    {
        $this->validate();

        Province::create([
            'name' => $this->name,
            'code' => $this->code,
            'region_id' => $this->region_id,
        ]);

        session()->flash('message', 'Province created successfully.');
        
        $this->closeModal();
        $this->resetForm();
        //$this->dispatch('province-saved', ['message' => 'Province created successfully!']);
    }

    public function edit($id)
    {
        $province = Province::findOrFail($id);
        $this->provinceId = $id;
        $this->name = $province->name;
        $this->code = $province->code;
        $this->region_id = $province->region_id;

        //$this->openModal();
        $this->isModalOpen = true;
    }

    public function update()
    {
        $this->validate();

        $province = Province::find($this->provinceId);
        $province->update([
            'name' => $this->name,
            'code' => $this->code,
            'region_id' => $this->region_id,
        ]);

        session()->flash('message', 'Province updated successfully');

        $this->closeModal();
        $this->resetForm();
        //$this->dispatch('province-saved', ['message' => 'Province updated successfully!']);
    }

    public function save()
    {
        if ($this->provinceId) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function confirmProvinceDeletion($id)
    {
        $this->confirmingProvinceDeletion = true;
        $this->provinceIdBeingDeleted = $id;
    }

    public function deleteProvince()
    {
        $province = Province::findOrFail($this->provinceIdBeingDeleted);
        $province->delete();

        $this->confirmingProvinceDeletion = false;
        session()->flash('message', 'Province Deleted successfully.');
        //$this->dispatch('province-deleted', ['message' => 'Province deleted successfully!']);
        //$this->closeModal();
    }

    public function getRegionsProperty()
    {
        return Region::orderBy('name')->get();
    }

    public function render()
    {
        $query = Province::query()
            ->with('region')
            ->where(function ($query) {
                $query->where('provinces.name', 'like', '%' . $this->search . '%')
                    ->orWhere('provinces.code', 'like', '%' . $this->search . '%');
            });

        // Apply region filter if set
        if ($this->regionFilter) {
            $query->where('provinces.region_id', $this->regionFilter);
        }

        // Special handling for sorting by region name
        if ($this->sortField === 'region') {
            $provinces = $query->join('regions', 'provinces.region_id', '=', 'regions.id')
                ->select('provinces.*') // Keep only province columns
                ->orderBy('regions.name', $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            $provinces = $query->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return view(
            'livewire.admin.province.province-table',
            [
                'provinces' => $provinces,
                'regions' => $this->regions,
            ]
        );
    }
}
