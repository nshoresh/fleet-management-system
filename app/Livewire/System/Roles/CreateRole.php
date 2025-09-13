<?php

namespace App\Livewire\System\Roles;

use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Str;

class CreateRole extends Component
{
    public Role $role;
    public $isEdit = false;

    protected function rules()
    {
        $uniqueRule = $this->isEdit
            ? 'unique:roles,name,' . $this->role->id
            : 'unique:roles,name';

        return [
            'role.name' => ['required', 'string', 'max:255', $uniqueRule],
            'role.slug' => ['nullable', 'string', 'max:255', 'unique:roles,slug,' . ($this->role->id ?? '')],
            'role.description' => ['nullable', 'string', 'max:1000'],
            'role.is_active' => ['boolean'],
        ];
    }

    protected $validationAttributes = [
        'role.name' => 'name',
        'role.slug' => 'slug',
        'role.description' => 'description',
        'role.is_active' => 'active status',
    ];

    public function mount($role = null)
    {
        if ($role) {
            $this->role = $role;
            $this->isEdit = true;
        } else {
            $this->role = new Role();
            $this->role->is_active = true;
        }
    }

    public function updatedRoleName()
    {
        if (!$this->isEdit || !$this->role->slug) {
            $this->role->slug = Str::slug($this->role->name);
        }
    }

    public function save()
    {
        $this->validate();

        if (empty($this->role->slug)) {
            $this->role->slug = Str::slug($this->role->name);
        }

        $this->role->save();

        $message = $this->isEdit ? 'Role updated successfully.' : 'Role created successfully.';
        session()->flash('message', $message);

        if ($this->isEdit) {
            $this->dispatch('roleUpdated');
        } else {
            $this->dispatch('roleCreated');
            return redirect()->route('roles.index');
        }
    }

    public function render()
    {
        return view('livewire.system.roles.create-role')
            ->layout('layouts.app');
    }
}
