<?php

namespace App\Livewire\System\Roles;

use App\Models\Role;
use App\Models\Permisions;
use Livewire\Component;

class EditRole extends Component
{
    public Role $role;
    public $name;
    public $slug;
    public $description;
    public $is_active;
    public $selectedPermissions = [];
    public $allPermissions = [];

    public function mount($id)
    {
        // Retrieve the role by ID
        $this->role = Role::findOrFail($id);

        // Prepopulate form fields
        $this->name = $this->role->name;
        $this->slug = $this->role->slug;
        $this->description = $this->role->description;
        $this->is_active = $this->role->is_active;

        // Get all available permissions
        $this->allPermissions = Permisions::all();

        // Load the role's current permissions
        $this->selectedPermissions = $this->role->permissions()->pluck('permission_id')->toArray();
    }

    public function updateRole()
    {
        // Validate input
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'slug' => 'required|string|max:255|unique:roles,slug,' . $this->role->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'selectedPermissions' => 'array',
        ]);

        // Update role details
        $this->role->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        // Sync selected permissions with the role
        $this->role->permissions()->sync($this->selectedPermissions);

        // Flash message and redirect
        session()->flash('message', 'Role updated successfully!');
        return redirect()->route('system.roles');
    }
    public function render()
    {
        return view('livewire.system.roles.edit-role');
            //->layout('layouts.app');
    }
}
