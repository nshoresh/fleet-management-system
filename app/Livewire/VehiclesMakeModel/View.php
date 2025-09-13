<?php

namespace App\Livewire\VehiclesMakeModel;

use Livewire\Component;

class View extends Component
{
    public function render()
    {
        return view('livewire.vehicles-make-model.view')->layout('layouts.app');
    }
}
