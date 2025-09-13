<?php

namespace App\Livewire\Client\Users;

use App\Models\User;
use App\Models\Role;
use App\Models\VehicleOwner;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UsersList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $filters = [
        'role' => '',
        'status' => '',
    ];

    // For create/edit modal
    public $showModal = false;
    public $showEditModal = false;
    public $userId;
    public $name;
    public $email;
    public $role_id;
    public $password;
    public $password_confirmation;
    public $isActive = true;
    public VehicleOwner $vehicleOwner;
    public Collection $users;
    public Collection $roles;
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'filters' => ['except' => ['role' => '', 'status' => '']],
    ];

    protected $listeners = ['UserUpdated' => 'cancelEditUser', 'UserCreated' => 'cancelCreateUser'];

    protected function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'role_id' => 'required|exists:roles,id',
            'password' => $this->userId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'isActive' => 'boolean',
        ];
    }


    public function mount()
    {
        $this->vehicleOwner = auth()->user()->vehicleOwner;
        $this->users = $this->vehicleOwner->users;
        $this->roles = Role::nonSystem()->get();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'search') {
            $this->resetPage();
        }
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

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters', 'search');
        $this->resetPage();
    }

    public function createUser()
    {
        $this->resetErrorBag();
        $this->reset([
            'userId',
            'name',
            'email',
            'role_id',
            'password',
            'password_confirmation',
            'isActive'
        ]);
        $this->isActive = true;
        // Set default role to 'user' role ID
        $userRole = Role::where('name', 'user')->first();
        $this->role_id = $userRole ? $userRole->id : null;
        $this->showModal = true;
    }

    public function cancelCreateUser()
    {


        $this->showModal = false;
    }
    public function editUser($id)
    {

        $this->userId = $id;

        $this->showEditModal = true;
    }

    public function cancelEditUser()
    {
        $this->showEditModal = false;
        $this->reset([
            'userId',
            'name',
            'email',
            'role_id',
            'password',
            'password_confirmation',
            'isActive'
        ]);
    }

    public function saveUser()
    {
        try {
            // Validate input data
            $validatedData = $this->validate();

            // Begin database transaction
            DB::beginTransaction();

            if ($this->userId) {
                // Update existing user
                $user = User::findOrFail($this->userId);
                $user->name = $this->name;
                $user->email = $this->email;
                $user->role_id = $this->role_id;
                $user->is_active = $this->isActive;

                if (!empty($this->password)) {
                    $user->password = Hash::make($this->password);
                }

                // Save user data
                $user->save();
                // Commit database transaction
                DB::commit();

                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'User updated successfully!'
                ]);
            } else {
                // Create new user
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role_id' => $this->role_id,
                    'password' => Hash::make($this->password),
                    'is_active' => $this->isActive,
                ]);

                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'User created successfully!'
                ]);
            }

            $this->showModal = false;
            $this->reset(['userId', 'name', 'email', 'role_id', 'password', 'password_confirmation']);
        } catch (ValidationException $e) {
            DB::rollBack();
            // Let laravel automatically handle validation
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Fail to create user: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteConfirm($userId)
    {
        $this->dispatch('confirm-user-deletion', [
            'title' => 'Delete User',
            'message' => 'Are you sure you want to delete this user? This action cannot be undone.',
            'userId' => $userId,
        ]);
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'User deleted successfully!'
        ]);
    }

    public function toggleUserStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_active = !$user->is_active;
        $user->save();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $user->is_active ? 'User activated successfully!' : 'User deactivated successfully!'
        ]);
    }


    public function render()
    {
        $users = User::query()
            ->with(['role', 'account_status']) // Eager load the role relationship
            ->when($this->search, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filters['role'], function ($query) {
                return $query->whereHas('role', function ($q) {
                    $q->where('name', $this->filters['role']);
                });
            })
            ->when($this->filters['status'] !== '', function ($query) {
                return $query->whereHas('account_status', function ($q) {
                    $q->where('status', $this->filters['status']);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Get all roles for the filter dropdown
        $roles = \App\Models\Role::all();
        $acount_status = \App\Models\AccountStatus::all();

        return view('livewire.client.users.users-list', [
            'users' => $this->users,
            'roles' => $this->roles,
            'acount_status' => $acount_status
        ])->layout('layouts.app');
    }
}
