<?php

namespace App\Livewire\Admin\Regions;

use Livewire\Component;

class ViewRegion extends Component
{
    public function render()
    {
        return view('livewire.admin.regions.view-region')->layout('layouts.app');
    }
}
