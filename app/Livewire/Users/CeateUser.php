<?php

namespace App\Livewire\Users;

use App\Jobs\AccountVerificationMailJob;
use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\AccountStatus;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;


class CeateUser extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $role_id;
    public $account_status_id;
    public $user_type_id;
    public Collection $user_roles;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|unique:users,phone',
        'password' => 'required|string|min:8|confirmed',
        'role_id' => 'required|exists:roles,id',
        'account_status_id' => 'required|exists:account_statuses,id',
        'user_type_id' => 'required|exists:user_types,id'
    ];

    public function mount()
    {
        $this->user_roles = Role::all();
    }
    public function register()
    {
        try {
            $this->validate();
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id,
                'account_status_id' => $this->account_status_id,
                'user_type_id' => $this->user_type_id
            ]);
            $this->resetFields();
            AccountVerificationMailJob::dispatch($user)->onQueue('emails_que')->delay(5);
            session()->flash(
                'message',
                'User registered successfully!'
            );
        } catch (\Throwable $e) {
            session()->flash(
                'error',
                'User registration failed! Error code: ' . $e->getCode() . ':' . $e->getMessage()
            );
        }
    }
    public function updatedUserTypeId()
    {
        // Reset role selection when user type changes
        $this->role_id = '';

        // This method will be automatically called when user_type_id changes
        $this->user_roles = $this->loadRoleScopes();
    }
    public function loadRoleScopes()
    {
        if (!$this->user_type_id) {
            return;
        }

        if ((int)$this->user_type_id === 1) {
            return Role::system()->get();
        } else {
            return Role::nonSystem()->get();
        }
    }

    public function resetFields()
    {
        $this->name = "";
        $this->email = "";
        $this->phone = "";
        $this->password = "";
        $this->password_confirmation = "";
        $this->role_id = "";
        $this->account_status_id = "";
    }
    public function render()
    {
        return view('livewire.users.ceate-user', [
            'roles' => $this->user_roles,
            'user_types' => UserType::all(),
            'account_statuses' => AccountStatus::all(),
        ]);
    }
}
