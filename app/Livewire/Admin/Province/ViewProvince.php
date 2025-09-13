<?php

namespace App\Livewire\Admin\Province;

use App\Models\Province;
use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class ViewProvince extends Component
{
    use WithPagination;

    public $provinceId;
    public $province;
    public $districts;
    public $isModalOpen = false;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255|unique:districts,name',
    ];

    public function mount($provinceId = null)
    {
        if (!$provinceId) {
            abort(404, 'Province ID is required.');
        }

        $this->provinceId = $provinceId;
        $this->province = Province::with('districts')->find($provinceId);

        if (!$this->province) {
            abort(404, 'Province not found.');
        }

        $this->districts = $this->province->districts;
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function createDistrict()
    {
        $this->validate();

        District::create([
            'name' => $this->name,
            'province_id' => $this->provinceId,
        ]);

        $this->province = Province::with('districts')->find($this->provinceId);
        $this->districts = $this->province->districts;
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.province.view-province', [
            'province' => $this->province,
            'districts' => $this->districts,
        ])->layout('layouts.app');
    }
}
