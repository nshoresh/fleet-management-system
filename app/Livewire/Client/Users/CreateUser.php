<?php

namespace App\Livewire\Client\Users;

// use App\Models\User;

use App\Jobs\AccountVerificationMailJob;
use App\Models\Role;
use App\Models\AccountStatus;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;


class CreateUser extends Component
{
    use WithFileUploads;
    // ‑‑ form fields ‑‑
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $role_id;
    public $account_status_id = 1;
    public $avatar;

    // data for <select>s
    public $roles   = [];
    // public $account_statuses = [];
    public UserType $userType;
    public AccountStatus $accountStatus;

    /* -----------------------------------------------------------------
     |  Lifecycle
     * -----------------------------------------------------------------*/
    public function mount(): void
    {
        // preload options for the <select> inputs
        $this->roles = Role::nonSystem()->get();

        $this->account_statuses = AccountStatus::query()
            ->select('id', 'status')
            ->orderBy('status')->get();

        // sensible defaults
        $this->role_id = $this->roles->first()->id ?? null;

        $this->account_status_id = $this->account_statuses
            ->first()->id ?? null;

        $this->userType = UserType::where(['type_name' => 'Client User'])->first();
        $this->accountStatus = AccountStatus::where(['status' => 'Inactive'])->first();
    }

    /* -----------------------------------------------------------------
     |  Validation
     * -----------------------------------------------------------------*/
    protected function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'min:3', 'max:255'],
            'email'             => ['required', 'email', 'unique:users,email'],
            'phone'             => ['required', 'string', 'unique:users,phone', 'max:32'],
            'password'          => ['required', 'confirmed', 'min:8,max:32'],
            'role_id'           => ['required', 'exists:roles,id'],
            'account_status_id' => ['required', 'exists:account_statuses,id'],
            'avatar'            => ['nullable', 'image', 'max:1024'],
        ];
    }

    protected function messages(): array
    {
        return [
            'role_id.required'            => 'Please select a role.',
            'role_id.exists'              => 'Selected role is invalid.',
            'account_status_id.required'  => 'Please select an account status.',
            'account_status_id.exists'    => 'Selected account status is invalid.',
            'phone.required'              => 'The phone field is required.',
        ];
    }

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    /* -----------------------------------------------------------------
     |  Actions
     * -----------------------------------------------------------------*/
    public function register()
    {
        $data = $this->validate();

        unset($data['password_confirmation']);

        $data['password'] = Hash::make($data['password']);

        $data['user_type_id'] = $this->userType->id;
        $data['vehicle_owner_id'] = auth()->user()->vehicleOwner->id;
        $data["account_status_id"] = $this->accountStatus->id;
        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        try {
            $user = User::create($data);

            $this->reset([
                'name',
                'email',
                'phone',
                'password',
                'password_confirmation',
                'avatar'
            ]);

            // dispatch(new AccountVerificationMailJob($user));
            AccountVerificationMailJob::dispatch($user)->onQueue('emails');
            session()->flash(
                'message',
                'User created successfully'
            );
        } catch (\Throwable $e) {
            session()->flash(
                'error',
                'Failed to create user. error: ' . $e->getCode() . ":" . $e->getMessage()
            );
        }
    }
    public function render()
    {
        return view('livewire.client.users.create-user', [
            'roles'            => $this->roles,
            // 'account_statuses' => $this->account_statuses,
        ])->layout('layouts.app');
    }
}
