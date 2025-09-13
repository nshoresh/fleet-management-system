<?php

namespace App\Livewire\Client\Invoices;

use Livewire\Component;

class InvoiceMakePayment extends Component
{
    public function render()
    {
        return view('livewire.client.invoices.invoice-make-payment')
            ->layout('layouts.app');
    }
}
