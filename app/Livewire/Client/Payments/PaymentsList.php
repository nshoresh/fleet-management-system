<?php

namespace App\Livewire\Client\Payments;

use Livewire\Component;

class PaymentsList extends Component
{
    public function render()
    {
        return view('livewire.client.payments.payments-list')
            ->layout('layouts.app');
    }
}
