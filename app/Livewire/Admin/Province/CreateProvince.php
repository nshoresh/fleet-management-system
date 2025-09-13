<?php

namespace App\Livewire\Admin\Province;

use Livewire\Component;

class CreateProvince extends Component
{
    public function render()
    {
        return view('livewire.admin.province.create-province')->layout('layouts.app');
    }
}
