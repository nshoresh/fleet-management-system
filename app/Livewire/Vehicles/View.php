<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;

class View extends Component
{
    public function render()
    {
        return view('livewire.vehicles.view')->layout('layouts.app');
    }
}
