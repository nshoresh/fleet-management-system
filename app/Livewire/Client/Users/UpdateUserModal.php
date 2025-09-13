<?php

namespace App\Livewire\Client\Users;

use App\Models\AccountStatus;
use App\Models\Role;
use App\Models\User;
use App\Models\UserType;
use App\Models\VehicleOwner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateUserModal extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $role;
    public $user_type;
    public $account_status;
    public $vehicle_owner;
    public $user_id;
    public $user;

    // Collections for dropdowns
    public $roles = [];
    public $userTypes = [];
    public $accountStatus = [];
    public $vehicleOwners;
    public $changePassword = false;

    // Listeners
    protected $listeners = ['openUpdateModal' => 'mount'];

    public function mount($id)
    {
        $this->user = User::find($id);

        if (!$this->user) {
            // Handle user not found
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'User not found!'
            ]);
            return;
        }

        $this->user_id = $id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->role = $this->user->role_id;
        $this->user_type = $this->user->user_type_id;
        $this->account_status = $this->user->account_status_id;
        $this->vehicle_owner = $this->user->vehicle_owner_id;

        // Load all related data for dropdowns
        $this->loadRelatedData();
    }

    public function updateChangePassword()
    {
        $this->changePassword = !$this->changePassword;
    }
    public function loadRelatedData()
    {
        $this->roles = Role::nonSystem()->get();
        $this->userTypes = UserType::all();
        $this->accountStatus = AccountStatus::all();
        $this->vehicleOwners = VehicleOwner::all();
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'phone' => 'required|string|max:20',
            'role' => 'required|exists:roles,id',
            'user_type' => 'required|exists:user_types,id',
            'account_status' => 'required|exists:account_statuses,id',
            'vehicle_owner' => 'nullable|exists:vehicle_owners,id',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            $this->user->name = $this->name;
            $this->user->email = $this->email;
            $this->user->phone = $this->phone;
            $this->user->role_id = $this->role;
            $this->user->user_type_id = $this->user_type;
            $this->user->account_status_id = $this->account_status;
            $this->user->vehicle_owner_id = $this->vehicle_owner;
            if ($this->changePassword) {
                $this->user->password = Hash::make($this->password);
            }
            $this->user->save();

            $this->reset();
            $this->dispatch('/* The `UserUpdated` event is being dispatched after a user is
            successfully updated in the `updateUser` method of the
            `UpdateUserModal` Livewire component. This event is likely used to
            notify other parts of the application that a user has been updated,
            allowing any necessary actions or updates to be triggered in response
            to the user update. */
            UserUpdated');
            session()->flash('success', 'User updated successfully!');
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to update user: ' . $e->getMessage()
            ]);
            session()->flash('error', 'There was some issue!');
        }
    }

    public function render()
    {
        return view('livewire.client.users.update-user-modal');
    }
}
