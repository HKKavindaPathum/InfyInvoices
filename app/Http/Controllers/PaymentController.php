<?php

namespace App\Http\Controllers;

use App\Exports\AdminTransactionsExport;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PaymentController extends AppBaseController
{
    public function index(): View|Factory|Application
    {
        return view('transactions.index');
    }

    public function exportTransactionsExcel(): BinaryFileResponse
    {
        return Excel::download(new AdminTransactionsExport(), 'transaction.xlsx');
    }

    public function showPaymentNotes($id): JsonResponse
    {
        $paymentNotes = Payment::where('id', $id)->first();

        return $this->sendResponse($paymentNotes->notes, __('messages.flash.note_retrieved_successfully'));
    }

    public function changeTransactionStatus(Request $request): mixed
    {
        $input = $request->all();

        /** @var Payment $payment */
        $payment = Payment::whereId($input['id'])->wherePaymentMode(Payment::MANUAL)->with('invoice')->firstOrFail();

        if ($input['status'] == Payment::MANUAL) {
            $payment->update([
                'is_approved' => $input['status'],
            ]);
            $this->updatePayment($payment);

            return $this->sendSuccess(__('messages.flash.manual_payment_approved_successfully'));
        }

        $payment->update([
            'is_approved' => $input['status'],
        ]);
        $this->updatePayment($payment);

        return $this->sendSuccess(__('messages.flash.manual_payment_denied_successfully'));
    }

    private function updatePayment(Payment $payment): void
    {
        $paymentInvoice = $payment->invoice;
        $totalPayment = Payment::whereInvoiceId($paymentInvoice->id)->whereIsApproved(Payment::APPROVED)->sum('amount');
        $status = Invoice::PARTIALLY;
        if ($payment->amount == $paymentInvoice->final_amount || $totalPayment == $paymentInvoice->final_amount) {
            $status = $payment->is_approved == Payment::APPROVED ? Invoice::PAID : Invoice::UNPAID;
        } elseif ($totalPayment == 0) {
            $status = Invoice::UNPAID;
        }
        $paymentInvoice->update([
            'status' => $status,
        ]);
    }

    public function downloadAttachment($transactionId)
    {
        /** @var Payment $transaction */
        $transaction = Payment::with('media')->findOrFail($transactionId);
        $attachment = $transaction->media->first();

        if (getLogInUser()->hasrole(Role::CLIENT)) {
            if ($transaction->invoice->client->user_id !== getLogInUserId()) {
                Flash::error(__('messages.flash.seems_you_are_not_allowed_to_access_this_record'));

                return redirect()->back();
            }
        }

        if ($attachment) {
            return $attachment;
        }

        return null;
    }

    public function exportTransactionsPdf(): Response
    {
        ini_set('max_execution_time', 36000000);
        $data['payments'] = Payment::with(['invoice.client.user'])->orderBy('created_at', 'desc')->get();
        $transactionsPdf = Pdf::loadView('transactions.export_transactions_pdf', $data);

        return $transactionsPdf->download('Transactions.pdf');
    }
}
