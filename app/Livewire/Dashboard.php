<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalInvoices;
    public $totalClients;
    public $totalProducts;
    public $paidInvoices;
    public $unpaidInvoices;
    public $partiallyPaid;
    public $overdueInvoices;

    public function mount()
    {
        $invoice = Invoice::all();
        $this->totalInvoices = $invoice->count();
        $this->totalClients = Client::count();
        $this->totalProducts = Product::count();
        $this->paidInvoices = $invoice->where('status', Invoice::PAID)->count();
        $this->unpaidInvoices = $invoice->where('status', Invoice::UNPAID)->count();
    }

    public function placeholder()
    {
        return view('livewire.dashboard_skeleton');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
