<?php

namespace App\Livewire\System\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Permisions; // Fixed model name from Permisions
use Livewire\Attributes\Url; // Add this for query string support

class PermissionsTable extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $groupFilter = '';

    #[Url(history: true)]
    public $sortField = 'name';

    #[Url(history: true)]
    public $sortDirection = 'asc';

    #[Url(history: true)]
    public $perPage = 10;

    // Define available options for per page filter
    public $perPageOptions = [10, 25, 50, 100];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingGroupFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
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

    public function render()
    {
        $query = Permisions::query(); // Fixed model name from Permisions

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('group', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->groupFilter) {
            $query->where('group', $this->groupFilter);
        }

        $permissions = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $groups = Permisions::select('group')
            ->distinct()
            ->whereNotNull('group')
            ->orderBy('group')
            ->pluck('group');

        return view('livewire.system.permissions.permissions-table', compact('permissions', 'groups'));
    }
}
