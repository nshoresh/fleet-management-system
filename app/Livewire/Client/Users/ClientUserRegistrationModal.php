<?php

namespace App\Livewire\Client\Users;

use App\Jobs\AccountVerificationMailJob;
use App\Models\Role;
use App\Models\User;
use App\Models\UserType;
use App\Models\VehicleOwner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ClientUserRegistrationModal extends Component
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
    public $user_type_id;
    public $avatar;
    public UserType $userType;
    // data for <select>s
    public $roles   = [];
    public $account_statuses = [];
    public VehicleOwner $vehicleOwner;

    public $nonSystemUsers = [];


    public function mount($id)
    {

        $this->vehicleOwner = VehicleOwner::find($id);
        $this->userType = UserType::where(['type_name' => 'Client User'])
            ->firstOr();
        $this->user_type_id = $this->userType->id;
        $this->account_status_id = 1;
        $this->nonSystemUsers = Role::nonSystem()->get();
    }
    protected function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'min:3', 'max:255'],
            'email'             => ['required', 'email', 'unique:users,email'],
            'phone'             => ['required', 'string', 'max:32'],
            'password'          => ['required', 'confirmed'],
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


    public function register()
    {
        $data = $this->validate();

        unset($data['password_confirmation']);

        $data['password'] = Hash::make($data['password']);
        $data['user_type_id'] = $this->user_type_id;
        if ($this->avatar) {
            $data['avatar'] = $this->avatar
                ->store('avatars', 'public');
        }

        try {
            $user = $this->vehicleOwner->users()
                ->create($data);

            if ($user) {
                $this->reset([
                    'name',
                    'email',
                    'phone',
                    'password',
                    'password_confirmation',
                    'avatar'
                ]);
                AccountVerificationMailJob::dispatch($user)->onQueue('emails');
                session()->flash(
                    'message',
                    'User created successfully'
                );
                $this->dispatch('UserCreated');
            }
            session()->flash(
                'message',
                'Failed to create user. Please try again.'
            );
        } catch (\Throwable $e) {
            session()->flash(
                'error',
                'Failed to create user. Please try again. error: ' . $e->getCode() . ':' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        // dd($this->vehicleOwner);
        return view('livewire.client.users.client-user-registration-modal');
    }
}
