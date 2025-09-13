<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Role;
use App\Models\UserType;
use App\Models\AccountStatus;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Rule;

class EditUser extends Component
{
    public User $user;

    #[Rule('required|string|max:255')]
    public $name;

    #[Rule('required|email|max:255')]
    public $email;

    #[Rule('required|string|max:20')]
    public $phone;

    #[Rule('nullable|string|min:8|confirmed')]
    public $password;

    public $password_confirmation;

    #[Rule('required|exists:roles,id')]
    public $role_id;

    #[Rule('required|exists:user_types,id')]
    public $user_type_id;

    #[Rule('required|exists:account_statuses,id')]
    public $account_status_id;

    public $roles = [];
    public $userTypes = [];
    public $accountStatuses = [];

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        // Fill form fields with user data
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->role_id = $this->user->role_id;
        $this->user_type_id = $this->user->user_type_id;
        $this->account_status_id = $this->user->account_status_id;
        // Load related data for dropdowns
        $this->roles = Role::all();
        $this->userTypes = UserType::all();
        $this->accountStatuses = AccountStatus::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveUser()
    {
        $validatedData = $this->validate();
        try {
            // Update user data
            $this->user->name = $this->name;
            $this->user->email = $this->email;
            $this->user->phone = $this->phone;
            $this->user->role_id = $this->role_id;
            $this->user->user_type_id = $this->user_type_id;
            $this->user->account_status_id = $this->account_status_id;
            // Only update password if provided
            if (!empty($this->password)) {
                $this->user->password = Hash::make($this->password);
            }
            $this->user->save();
            session()->flash('success', 'User updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'There was an error!. Error code: ' . $e->getCode() . ':' . $e->getMessage());
        }


        // Redirect to user list or detail page
        // return redirect()->route('users');
    }

    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
