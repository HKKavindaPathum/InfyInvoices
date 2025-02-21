<?php

namespace App\Exports;

use App\Models\AdminPayment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminPaymentsExport implements FromView
{
    public function __construct(public $date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $timeEntryDate = explode(' - ', $this->date);
        $startDate = Carbon::parse($timeEntryDate[0])->format('Y-m-d');
        $endDate = Carbon::parse($timeEntryDate[1])->format('Y-m-d');
        $adminPayments = AdminPayment::with(['invoice.client.user'])->whereBetween('payment_date', [$startDate, $endDate])->orderBy('created_at','desc')->get();

        return view('excel.admin_payments_excel', compact('adminPayments'));
    }
}
