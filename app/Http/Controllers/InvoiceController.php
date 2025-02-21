<?php

namespace App\Http\Controllers;

use App\Exports\AdminInvoicesExport;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Mail\InvoicePaymentReminderMail;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $this->updateInvoiceOverDueStatus();
        $statusArr = Invoice::STATUS_ARR;
        $status = $request->status;

        return view('invoices.index', compact('statusArr', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory|Application
    {
        $data = $this->invoiceRepository->getSyncList();
        $data['currencies'] = getCurrencies();
        unset($data['statusArr'][0]);

        return view('invoices.create')->with($data);
    }

    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $invoice = $this->invoiceRepository->saveInvoice($request->all());
            if ($request->status != Invoice::DRAFT) {
                $this->invoiceRepository->saveNotification($request->all(), $invoice);
                DB::commit();

                return $this->sendResponse($invoice, __('messages.flash.invoice_saved_and_sent_successfully'));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($invoice, __('messages.flash.invoice_saved_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice): View|Factory|Application
    {
        $invoiceData = $this->invoiceRepository->getInvoiceData($invoice);

        return view('invoices.show')->with($invoiceData);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Invoice $invoice)
    {
        $data = $this->invoiceRepository->prepareEditFormData($invoice);
        $data['selectedInvoiceTaxes'] = $invoice->invoiceTaxes()->pluck('tax_id')->toArray();
        $data['currencies'] = getCurrencies();

        return view('invoices.edit')->with($data);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $invoice = $this->invoiceRepository->updateInvoice($invoice->id, $input);
            $changes = $invoice->getChanges();
            if ($input['invoiceStatus'] == '1') {
                if (count($changes) > 0 && $input['invoiceStatus'] == '1') {
                    $this->invoiceRepository->updateNotification($invoice, $input, $changes);
                }
                if ($input['invoiceStatus'] == '1' && $input['status'] == Invoice::DRAFT) {
                    $this->invoiceRepository->draftStatusUpdate($invoice);
                }
                DB::commit();

                return $this->sendResponse($invoice, __('messages.flash.invoice_updated_and_send_successfully'));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($invoice, __('messages.flash.invoice_updated_successfully'));
    }

    public function destroy(Invoice $invoice): JsonResponse
    {
        $invoice->delete();

        return $this->sendSuccess( __('messages.flash.invoice_deleted_successfully'));
    }

    public function getProduct($productId): JsonResponse
    {
        $product = Product::pluck('unit_price', 'id')->toArray();

        return $this->sendResponse($product,__('messages.flash.product_price_retrieved_successfully.'));
    }

    public function getInvoiceCurrency($currencyId): mixed
    {
        $currency = Currency::whereId($currencyId)->first()->icon;

        return $this->sendResponse($currency, __('messages.flash.invoice_currency_retrieved_successfully'));
    }

    public function convertToPdf(Invoice $invoice): Response
    {
        ini_set('max_execution_time', 36000000);
        $invoice->load(['client.user', 'invoiceTemplate', 'invoiceItems.product', 'invoiceItems.invoiceItemTax', 'invoiceTaxes', 'paymentQrCode']);
        $invoiceData = $this->invoiceRepository->getPdfData($invoice);
        $invoiceTemplate = $this->invoiceRepository->getDefaultTemplate($invoice);

        $pdf = Pdf::loadView("invoices.invoice_template_pdf.$invoiceTemplate", $invoiceData);

        return $pdf->stream('invoice.pdf');
    }

    public function updateInvoiceStatus(Invoice $invoice, $status): mixed
    {
        $this->invoiceRepository->draftStatusUpdate($invoice);

        return $this->sendSuccess(__('messages.flash.Invoice_send_successfully'));
    }

    public function updateInvoiceOverDueStatus()
    {
        $invoice = Invoice::whereStatus(Invoice::UNPAID)->get();
        $currentDate = Carbon::today()->format('Y-m-d');
        foreach ($invoice as $invoices) {
            if ($invoices->due_date < $currentDate) {
                $invoices->update([
                    'status' => Invoice::OVERDUE,
                ]);
            }
        }
    }

    public function invoicePaymentReminder($invoiceId): mixed
    {
        $invoice = Invoice::with(['client.user', 'payments'])->whereId($invoiceId)->firstOrFail();
        $paymentReminder = Mail::to($invoice->client->user->email)->send(new InvoicePaymentReminderMail($invoice));

        return $this->sendResponse($paymentReminder,__('messages.flash.payment_reminder_mail_send_successfully'));
    }

    public function exportInvoicesExcel(): BinaryFileResponse
    {
        return Excel::download(new AdminInvoicesExport(), 'invoice-excel.xlsx');
    }

    public function showPublicInvoice($invoiceId): View|Factory|Application
    {
        $invoice = Invoice::with('client.user')->whereInvoiceId($invoiceId)->firstOrFail();
        $invoiceData = $this->invoiceRepository->getInvoiceData($invoice);
        $invoiceData['statusArr'] = Invoice::STATUS_ARR;
        $invoiceData['status'] = $invoice->status;
        unset($invoiceData['statusArr'][Invoice::DRAFT]);
        $invoiceData['paymentType'] = Payment::PAYMENT_TYPE;
        $invoiceData['paymentMode'] = $this->invoiceRepository->getPaymentGateways();
        $invoiceData['stripeKey'] = getSettingValue('stripe_key');
        $invoiceData['userLang'] = $invoice->client->user->language;
        $language = $invoice->client->user->language ?? 'en';
        App::setLocale($language);

        return view('invoices.public-invoice.public_view')->with($invoiceData);
    }

    public function getPublicInvoicePdf($invoiceId)
    {
        $invoice = Invoice::whereInvoiceId($invoiceId)->firstOrFail();
        $invoice->load('client.user', 'invoiceTemplate', 'invoiceItems.product', 'invoiceItems.invoiceItemTax');
        $invoiceData = $this->invoiceRepository->getPdfData($invoice);
        $invoiceTemplate = $this->invoiceRepository->getDefaultTemplate($invoice);
        $pdf = Pdf::loadView("invoices.invoice_template_pdf.$invoiceTemplate", $invoiceData);

        return $pdf->stream('invoice.pdf');
    }

    public function showPublicPayment($invoiceId): Factory|View|Application
    {
        /** @var PaymentRepository $paymentRepo */
        $paymentRepo = App::make(PaymentRepository::class);

        /** @var Invoice $invoice */
        $invoice = Invoice::with('client.user')->whereInvoiceId($invoiceId)->firstOrFail();
        $totalPayable = $paymentRepo->getTotalPayable($invoice);
        $paymentType = Payment::PAYMENT_TYPE;
        $paymentMode = $this->invoiceRepository->getPaymentGateways();
        $userLang = $invoice->client->user->language;

        $stripeKey = getSettingValue('stripe_key');
        if (empty($stripeKey)) {
            $stripeKey = config('services.stripe.key');
        }

        return view('invoices.public-invoice.payment',
            compact('paymentType', 'paymentMode', 'totalPayable', 'stripeKey', 'invoice','userLang')
        );
    }

    public function updateRecurring(Invoice $invoice)
    {
        $recurringCycle = empty($invoice->recurring_cycle) ? 1 : $invoice->recurring_cycle;
        $invoice->update([
            'recurring_status' => ! $invoice->recurring_status,
            'recurring_cycle' => $recurringCycle,
        ]);

        return $this->sendSuccess(__('messages.flash.recurring_status_updated_successfully'));
    }

    public function exportInvoicesPdf(): Response
    {
        ini_set('max_execution_time', 3600000000);
        $data['invoices'] = Invoice::with('client.user', 'payments')->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('invoices.export_invoices_pdf', $data);

        return $pdf->download('Invoices.pdf');
    }

    public function sendInvoiceOnWhatsapp(Request $request): JsonResponse
    {
        $request->validate([
            'invoice_id' => 'required',
            'phone_number' => 'required',
        ]);

        $data = [];
        $input = $request->all();
        $invoice = Invoice::with(['client.user','payments'])->whereId($input['invoice_id'])->firstOrFail();
        $data['appName'] = getAppName();
        $data['invoice'] = $invoice;
        $data['invoicePdfLink'] = route('public-view-invoice.pdf', ['invoice' => $invoice->invoice_id]);
        $data['phoneNumber'] = '+'.$input['region_code'].$input['phone_number'];

        return $this->sendResponse($data, 'send invoice data retrieved successfully.');
    }
}
