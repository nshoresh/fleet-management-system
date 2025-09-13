<?php

namespace App\Livewire\Admin\VehicleOwners\Users;

use App\Jobs\SendUserVerificationEmail;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\User;
use App\Models\UserType;
use App\Models\VehicleOwner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class VehicleOwnerUsersCreate extends Component
{
    use WithPagination;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $role_id;
    public $user_type_id;
    public $account_status_id = 1;
    public $owner;
    public $vehicleOwnerId;
    public $nonSystemUsers = [];
    public $roles;
    public $isOpen = false;
    public $showForm = false;

    public UserType $userType;
    protected $rules = [
        'name' => 'required|string|max:25,min:3',
        'email' => 'required|email|unique:users',
        'phone' => 'required|unique:users',
        'password' => 'required|min:8,max:25',
        'role_id' => 'required|exists:roles,id',
    ];
        /**
         * Close the form and reset the fields
         */
        
        /*public function openModal()
        {
            $this->isOpen = true;
        }

        public function closeModal()
        {
            $this->isOpen = false;
        }
        public function closeForm()
        {
            $this->reset(); // Optional: clears the form fields
            $this->dispatch('user-created'); // Emit an event if you're using a modal
            // OR if you're just showing/hiding the form in the same component:
            $this->showForm = false; // Assuming you have a $showForm property
        }*/
        /**
         * Mount the component and set the user type and vehicle owner
         * @param int $vehicleOwnerId The ID of the vehicle owner
         */
        public function mount($vehicleOwnerId)
        {
        $this->userType = UserType::where(['type_name' => 'Client User'])->firstOr();
        $this->vehicleOwnerId = $vehicleOwnerId;
        $this->owner = VehicleOwner::find($this->vehicleOwnerId);
        $this->user_type_id = $this->userType->id;
        $this->account_status_id = 1;
        // $this->roles = Role::nonSystem()->get();
        $this->nonSystemUsers = Role::nonSystem()->get();
    }

    public function store()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id,
                'user_type_id' => $this->user_type_id,
                'account_status_id' => $this->account_status_id,
                'vehicle_owner_id' => $this->vehicleOwnerId,
                // 'uuid'=>
            ]);


            $this->dispatch('userCreated');
            $this->resetForm();
            $this->sendVerificationEmail($user);
            session()->flash('success', 'User created successfully.');
        } catch (\Throwable $e) {
            Log::info("There was an error registering users by Management");
            Log::error($e);
            session()->flash('error', 'There was an error with user registration :' . $e->getMessage());
        }
    }
    private function sendVerificationEmail(User $user)
    {
        try {
            Log::info($user->id);
            // Mail::to($user->email)->send(new UserVerificationMail($user));
            SendUserVerificationEmail::dispatch($user)->onQueue('sendMail');
            Log::info("Verification email sent to user: {$user->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send verification email to {$user->email}: " . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->role_id = '';
        // $this->user_type_id = '';
        // $this->account_status_id = '';
    }

    public function render()
    {
        return view('livewire.admin.vehicle-owners.users.vehicle-owner-users-create');
    }
}
