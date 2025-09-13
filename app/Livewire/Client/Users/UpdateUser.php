<?php

namespace App\Livewire\Client\Users;

use Livewire\Component;

class UpdateUser extends Component
{
    public function render()
    {
        return view('livewire.client.users.update-user')
            ->layout('layouts.app');
    }
}
