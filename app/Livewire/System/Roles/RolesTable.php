<?php

namespace App\Livewire\System\Roles;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class RolesTable extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $sortField = 'name';

    #[Url]
    public $sortDirection = 'asc';

    #[Url]
    public $perPage = 10;

    public $filterStatus = '';

    // Properties for confirmation modal
    public $confirmingRoleDeletion = false;
    public $roleIdBeingDeleted = null;

    // Listeners for emitted events
    protected $listeners = [
        'roleCreated' => '$refresh',
        'roleUpdated' => '$refresh'
    ];

    protected $queryString = [
        'search',
        'filterStatus',
        'sortDirection',
        'perPage'
    ];
    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset pagination when filter status changes
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    // Sort by specified field
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    // Confirm role deletion
    public function confirmRoleDeletion($id)
    {
        $this->confirmingRoleDeletion = true;
        $this->roleIdBeingDeleted = $id;
    }

    // Delete the role
    public function deleteRole()
    {
        $role = Role::findOrFail($this->roleIdBeingDeleted);
        $role->delete();

        $this->confirmingRoleDeletion = false;
        $this->roleIdBeingDeleted = null;

        session()->flash(
            'message',
            'Role successfully deleted.'
        );
    }

    // Toggle role status
    public function toggleStatus($id)
    {
        $role = Role::findOrFail($id);
        $role->is_active = !$role->is_active;
        $role->save();

        session()->flash(
            'message',
            'Role status updated successfully.'
        );
    }

    public function render()
    {
        $roles = Role::query()
            ->when(
                $this->search,
                function (Builder $query) {
                    return $query->where(
                        'name',
                        'like',
                        '%' . $this->search . '%'
                    )
                        ->orWhere(
                            'description',
                            'like',
                            '%' . $this->search . '%'
                        )->orWhere(
                            'slug',
                            'like',
                            '%' . '$this->search' . '%'
                        );
                }
            )
            ->when(
                $this->filterStatus !== '',
                function (Builder $query) {
                    return $query->where(
                        'is_active',
                        $this->filterStatus
                    );
                }
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.system.roles.roles-table', [
            'roles' => $roles
        ]);
    }
}
