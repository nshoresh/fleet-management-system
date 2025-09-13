<?php

namespace App\Livewire\Users;

use Livewire\Component;

class Table extends Component
{
    public function render()
    {
        return view('livewire.users.table')->layout('layouts.app');
    }
}
