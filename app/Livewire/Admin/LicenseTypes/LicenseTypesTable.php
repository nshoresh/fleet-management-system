<?php

namespace App\Livewire\Admin\LicenseTypes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LicenseType;

class LicenseTypesTable extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $sortField = 'type_name';
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field)
            ? $this->reverseDirection()
            : 'asc';

        $this->sortField = $field;
    }

    private function reverseDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function delete($id)
    {
        LicenseType::findOrFail($id)->delete();
        session()->flash('success', 'License type deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.license-types.license-types-table', [
            'licenseTypes' => LicenseType::when($this->searchTerm, function ($query) {
                $query->where('type_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('type_category', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('type_description', 'like', '%' . $this->searchTerm . '%');
            })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ])->layout('layouts.app');
    }
}
