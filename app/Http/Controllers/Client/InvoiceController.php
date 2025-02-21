<?php

namespace App\Http\Controllers\Client;

use App\Exports\ClientInvoicesExport;
use App\Http\Controllers\AppBaseController;
use App\Models\Invoice;
use App\Models\Payment;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InvoiceController extends AppBaseController
{
    /** @var InvoiceRepository */
    public $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request): View|Factory|Application
    {
        $statusArr = Invoice::STATUS_ARR;
        $status = $request->status;
        unset($statusArr[Invoice::DRAFT]);
        $paymentType = Payment::PAYMENT_TYPE;
        $paymentMode = $this->getPaymentGateways();
        $stripeKey = getSettingValue('stripe_key');
        if (empty($stripeKey)) {
            $stripeKey = config('services.stripe.key');
        }

        return view('client_panel.invoices.index', compact('statusArr', 'paymentType', 'paymentMode', 'status', 'stripeKey'));
    }

    /**
     * @return Application|Factory|View|RedirectResponse|\never
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('client');
        if (getLogInUserId() != $invoice->client->user_id) {
            return abort(404);
        }
        if ($invoice->status == Invoice::DRAFT) {
            Flash::error('Invoice Not Found.');

            return redirect()->route('client.invoices.index');
        }

        $invoiceData = $this->invoiceRepository->getInvoiceData($invoice);

        return view('client_panel.invoices.show')->with($invoiceData);
    }

    public function convertToPdf(Invoice $invoice): Response
    {
        $invoice->load('client.user', 'invoiceTemplate', 'invoiceItems.product', 'invoiceItems.invoiceItemTax');
        if (getLogInUserId() != $invoice->client->user->id) {
            abort(404);
        }
        $invoiceData = $this->invoiceRepository->getPdfData($invoice);
        $invoiceTemplate = $this->invoiceRepository->getDefaultTemplate($invoice);
        $pdf = Pdf::loadView("invoices.invoice_template_pdf.$invoiceTemplate", $invoiceData);

        return $pdf->stream('invoice.pdf');
    }

    public function exportInvoicesExcel(): BinaryFileResponse
    {
        return Excel::download(new ClientInvoicesExport(), 'invoice-excel.xlsx');
    }

    public function getPaymentGateways(): array
    {
        $paymentMode = Payment::PAYMENT_MODE;
        $availableMode = [
            Payment::PAYPAL => 'paypal_enabled',
            Payment::RAZORPAY => 'razorpay_enabled',
            Payment::STRIPE => 'stripe_enabled',
        ];
        foreach ($availableMode as $key => $mode) {
            if (! getSettingValue($mode)) {
                unset($paymentMode[$key]);
            }
        }
        unset($paymentMode[Payment::CASH]);
        unset($paymentMode[Payment::ALL]);

        return $paymentMode;
    }

    public function exportInvoicesPdf(): Response
    {
        $data['invoices'] = Invoice::whereClientId(Auth::user()->client->id)
            ->where('status', '!=', Invoice::DRAFT)
            ->with('payments')->orderBy('created_at', 'desc')->get();

        $clientInvoicesPdf = Pdf::loadView('invoices.export_invoices_pdf', $data);

        return $clientInvoicesPdf->download('Client-Invoices.pdf');
    }
}
