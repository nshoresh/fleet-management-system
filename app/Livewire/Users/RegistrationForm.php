<?php

namespace App\Livewire\Users;

use App\Jobs\AccountVerificationMailJob;
use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\AccountStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegistrationForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $role_id;
    public $account_status_id;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|unique:users,phone',
        'password' => 'required|string|min:8|confirmed',
        'role_id' => 'required|exists:roles,id',
        'account_status_id' => 'required|exists:account_statuses,id',
    ];
    public function registerUser()
    {
        $this->validate();
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id,
                'account_status_id' => 2,
            ]);

            AccountVerificationMailJob::dispatch($user)->onQueue('emails_que')->delay(5);

            $this->reset();
            session()->flash('message', 'User registered successfully!');
        } catch (\Throwable $e) {
            // Log the error message
            Log::error('User registration failed: ' . $e->getMessage());
            // Handle the error, log it, or show a message to the user
            session()->flash('error', 'Failed to register user: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.users.registration-form', [
            'roles' => Role::all(),
            'account_statuses' => AccountStatus::all(),
        ]);
    }
}
