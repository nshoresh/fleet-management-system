<?php

namespace App\Livewire\Admin\VehicleOwners\Users;

use App\Models\VehicleOwner;
use Livewire\Component;

class UserStats extends Component
{
    public VehicleOwner $vehicle_owner;

    public int $user_count = 0;
    public function mount($id)
    {
        $this->vehicle_owner = VehicleOwner::find($id);
        $this->user_count = $this->vehicle_owner->getUsercountAttribute();
    }
    public function render()
    {
        return view('livewire.admin.vehicle-owners.users.user-stats');
    }
}
