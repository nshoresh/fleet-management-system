<?php

namespace App\Livewire\Client\Users;

use Livewire\Component;

class ViewUser extends Component
{
    public function render()
    {
        return view('livewire.client.users.view-user')
            ->layout('layouts.app');
    }
}
