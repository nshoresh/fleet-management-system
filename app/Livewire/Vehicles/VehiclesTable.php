<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;

class VehiclesTable extends Component
{
    public function render()
    {
        return view('livewire.vehicles.vehicles-table')
            ->layout('layouts.app');
    }
}
