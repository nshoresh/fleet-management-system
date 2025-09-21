<?php

namespace App\Livewire\Admin\District;

use App\Models\District;
use App\Models\Province;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Str;

class DistrictTable extends Component
{
    use WithPagination;

    public $district_id;
    public $province_id = '';
    public $name = '';
    public $code = '';
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $isOpen = false;
    public $confirmingDelete = false;
    public $deleteId;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'province_id' => 'required|exists:provinces,id',
        'name' => 'required|string|max:255',
        'code' => 'nullable|string|max:50'
    ];

    public function updatedName($value)
    {
        // Auto-generate the code as a slug based on the name
        $this->code = \Illuminate\Support\Str::slug($value);
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

    public function openModal()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->confirmingDelete = false;
    }

    public function resetForm()
    {
        $this->district_id = null;
        $this->province_id = '';
        $this->name = '';
        $this->code = '';
    }

    public function edit($id)
    {
        $district = District::findOrFail($id);
        $this->district_id = $id;
        $this->province_id = $district->province_id;
        $this->name = $district->name;
        $this->code = $district->code;

        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        District::updateOrCreate(
            ['id' => $this->district_id],
            [
                'province_id' => $this->province_id,
                'name' => $this->name,
                'code' => $this->code
            ]
        );

        session()->flash('message', $this->district_id ? 'District updated successfully.' : 'District created successfully.');

        $this->closeModal();
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        District::find($this->deleteId)->delete();
        session()->flash('message', 'District deleted successfully.');
        $this->closeModal();
    }

    public function render()
    {
        $provinces = Province::orderBy('name')->get();

        $districts = District::query()
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('province', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.district.district-table', [
            'districts' => $districts,
            'provinces' => $provinces,
        ]);
    }
}
