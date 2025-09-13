<?php

namespace App\Livewire\Client\Payments;

use Livewire\Component;

class ViewPayment extends Component
{
    public function render()
    {
        return view('livewire.client.payments.view-payment')
            ->layout('layouts.app');
    }
}
