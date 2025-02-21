<?php

namespace App\Livewire;

use Livewire\Component;

class CurrencyReport extends Component
{
    public $totalInvoices;
    public $paidInvoices;
    public $dueInvoices;

    public function mount($currencyData)
    {
        $this->totalInvoices = $currencyData['totalInvoices'];
        $this->paidInvoices = $currencyData['paidInvoices'];
        $this->dueInvoices = $currencyData['dueInvoices'];
    }

    public function placeholder()
    {
        return view('livewire.currency_report_skeleton');
    }

    public function render()
    {
        return view('livewire.currency-report');
    }
}
