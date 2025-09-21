<?php

namespace App\Livewire\Admin\LicensePurpose;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LicensePurpose;

class LicensePurposeTable extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $sortField = 'purpose_name';
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
        LicensePurpose::findOrFail($id)->delete();
        session()->flash('success', 'License purpose deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.license-purpose.license-purpose-table', [
            'licensePurposes' => LicensePurpose::when($this->searchTerm, function ($query) {
                $query->where('purpose_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('purpose_description', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('purpose_category', 'like', '%' . $this->searchTerm . '%');
            })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
}
