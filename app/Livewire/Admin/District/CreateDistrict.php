<?php

namespace App\Livewire\Admin\District;

use Livewire\Component;

class CreateDistrict extends Component
{
    public function render()
    {
        return view('livewire.admin.district.create-district')->layout('layouts.app');
    }
}
