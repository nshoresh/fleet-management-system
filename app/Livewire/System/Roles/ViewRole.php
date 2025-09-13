<?php

namespace App\Livewire\System\Roles;

use Livewire\Component;

class ViewRole extends Component
{
    public function render()
    {
        return view('livewire.system.roles.view-role')
            ->layout('layouts.app');
    }
}
