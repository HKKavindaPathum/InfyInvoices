<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminInvoicesExport implements FromView
{
    public function view(): View
    {
        $invoices = Invoice::with('client.user', 'payments')->orderBy('created_at','desc')->get();

        return view('excel.admin_invoices_excel', compact('invoices'));
    }
}
