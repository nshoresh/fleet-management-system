<?php

namespace App\Livewire\Client\Invoices;

use Livewire\Component;

class ViewInvoice extends Component
{
    public function render()
    {
        return view('livewire.client.invoices.view-invoice')
            ->layout('layouts.app');
    }
}
