<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;

class ClientDashboard extends Component
{
    public $totalInvoices;
    public $totalClients;
    public $totalProducts;
    public $paidInvoices;
    public $unpaidInvoices;

    public function mount()
    {
        $user = getLogInUser();
        $invoice = Invoice::where('client_id', $user->client->id)->where('status', '!=', Invoice::DRAFT)->get();
        $this->totalInvoices = $invoice->count();
        $this->totalProducts = Product::count();
        $this->paidInvoices = $invoice->where('status', Invoice::PAID)->count();
        $this->unpaidInvoices = $invoice->where('status', Invoice::UNPAID)->count();
    }

    public function placeholder()
    {
        return view('livewire.client_dashboard_skeleton');
    }

    public function render()
    {
        return view('livewire.client-dashboard');
    }
}
