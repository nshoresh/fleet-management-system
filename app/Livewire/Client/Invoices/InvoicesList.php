<?php

namespace App\Livewire\Client\Invoices;

use Livewire\Component;

class InvoicesList extends Component
{
    public function render()
    {
        return view('livewire.client.invoices.invoices-list')
            ->layout('layouts.app');
    }
}
