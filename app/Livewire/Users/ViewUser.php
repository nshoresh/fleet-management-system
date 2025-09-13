<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\VehicleOwner;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ViewUser extends Component
{
    /** -----------------------------------------------------------
     *  Public properties
     *  ----------------------------------------------------------*/
    public User $user;
    public bool $openResetPasswordMdal = false;

    public VehicleOwner $vehicleOwner; // bound in the route (see below)

    /** -----------------------------------------------------------
     *  Mount ‑ receives the User instance via route‑model binding
     *  ----------------------------------------------------------*/
    public function mount($id): void
    {
        $this->user = User::find($id);
        $this->loadCLient();
    }

    public function loadCLient()
    {
        if ($this->user->isClientUser()) {
            // Check if vehicleOwner relationship exists
            if ($this->user->vehicleOwner) {
                $this->vehicleOwner = $this->user->vehicleOwner;
            }
        }
    }

    public function openPasswordModal()
    {
        $this->openResetPasswordMdal = true;
    }

    public function closePasswordModal()
    {
        $this->openResetPasswordMdal = false;
    }
    /** -----------------------------------------------------------
     *  Render
     *  ----------------------------------------------------------*/
    public function render()
    {
        return view('livewire.client.users.view-user', [
            'user' => $this->user,
        ])->layout('layouts.app');
    }
}
