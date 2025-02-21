<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ClientInvoicesExport implements FromView
{
    public function view(): View
    {
        $clientInvoices = Invoice::with('payments')->whereClientId(Auth::user()->client->id)
            ->where('status', '!=', Invoice::DRAFT)
            ->orderBy('created_at', 'desc')->get();

        return view('excel.client_invoices_excel', compact('clientInvoices'));
    }
}
