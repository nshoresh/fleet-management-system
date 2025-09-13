<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RestPasswordModal extends Component
{
    public User $user;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'password' => 'required|confirmed|string|min:8|max:25'
    ];

    public function mount($id)
    {
        $this->user = User::find($id);
    }

    public function resetPassword()
    {
        $this->validate();
        $this->user->password = Hash::make($this->password);
        $this->user->save();

        session()->flash(
            'success',
            'Password reset successfully'
        );

        $this->reset('password', 'password_confirmation');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.admin.users.rest-password-modal');
    }
}
