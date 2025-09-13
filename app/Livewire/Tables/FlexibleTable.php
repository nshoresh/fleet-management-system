<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;

class FlexibleTable extends Component
{
    use WithPagination; // Add this line to use the trait

    public $data = []; // The data to display
    public $columns = []; // Column definitions
    public $sortField = null; // Current sort field
    public $sortDirection = 'asc'; // Current sort direction
    public $searchQuery = ''; // Search query
    public $perPage = 10; // Items per page
    public $tableTitle = 'Data Table'; // Table title
    public $loading = false; // Loading state
    public $selectedItems = []; // Selected items for bulk actions
    public $showFilters = false; // Show filters toggle
    public $filters = []; // Applied filters
    public $page = 1;
    public function mount($data = [], $columns = [], $tableTitle = 'Data Table', $perPage = 10)
    {
        $this->data = $data;
        $this->columns = $columns;
        $this->tableTitle = $tableTitle;
        $this->perPage = $perPage;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        if (count($this->selectedItems) === count($this->data)) {
            $this->selectedItems = [];
        } else {
            $this->selectedItems = collect($this->data)->pluck('id')->toArray();
        }
    }

    public function toggleFilter()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function resetFilters()
    {
        $this->filters = [];
        $this->resetPage();
    }

    public function getFilteredDataProperty()
    {
        $data = collect($this->data);

        // Apply search
        if ($this->searchQuery) {
            $data = $data->filter(function ($item) {
                foreach ($this->columns as $column) {
                    $field = $column['field'];
                    if (
                        isset($item[$field]) &&
                        str_contains(strtolower($item[$field]), strtolower($this->searchQuery))
                    ) {
                        return true;
                    }
                }
                return false;
            });
        }

        // Apply filters
        foreach ($this->filters as $field => $value) {
            if (!empty($value)) {
                $data = $data->filter(function ($item) use ($field, $value) {
                    return isset($item[$field]) && $item[$field] == $value;
                });
            }
        }

        // Apply sorting
        if ($this->sortField) {
            $data = $data->sortBy($this->sortField, SORT_REGULAR, $this->sortDirection === 'desc');
        }

        return $data;
    }

    public function getPaginatedDataProperty()
    {
        return $this->filteredData->forPage($this->page, $this->perPage);
    }

    public function render()
    {
        return view('livewire.tables.flexible-table', [
            'items' => $this->paginatedData,
            'totalItems' => $this->filteredData->count(),
        ]);
    }
}
