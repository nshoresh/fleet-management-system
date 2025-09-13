<?php

namespace App\Livewire\System\Roles;

use App\Models\Role;
use App\Models\Permisions; // Fixed model name (was Permisions)
use Livewire\Component;
use Livewire\WithPagination;

class RolePermissions extends Component
{
    use WithPagination;

    public Role $role;
    public $selectedPermissions = [];
    public $selectAll = false;

    public function mount($id)
    {
        // Find the role by ID
        $this->role = Role::findOrFail($id);

        // Initialize selectedPermissions with current role permissions
        $this->selectedPermissions = $this->role->permissions->pluck('id')->toArray();

        // Check if all permissions are selected
        $this->checkIfAllSelected();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Select all permissions
            $this->selectedPermissions = Permisions::pluck('id')->toArray();
        } else {
            // Deselect all permissions
            $this->selectedPermissions = [];
        }
    }

    public function updatedSelectedPermissions()
    {
        // Update the selectAll property based on whether all permissions are selected
        $this->checkIfAllSelected();
    }

    private function checkIfAllSelected()
    {
        $this->selectAll = count($this->selectedPermissions) === Permisions::count();
    }

    public function updateRolePermissions()
    {
        // Sync the selected permissions with the role
        $this->role->permissions()->sync($this->selectedPermissions);

        session()->flash('message', 'Permissions updated successfully!');
    }

    public function render()
    {
        return view('livewire.system.roles.role-permissions', [
            'role' => $this->role,
            'all_permissions' => Permisions::all(),
            'role_permission_ids' => $this->selectedPermissions
        ]);
    }
}
