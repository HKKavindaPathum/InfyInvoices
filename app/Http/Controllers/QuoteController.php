<?php

namespace App\Http\Controllers;

use App\Exports\AdminQuotesExport;
use App\Http\Requests\CreateQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Quote;
use App\Repositories\QuoteRepository;
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
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class QuoteController extends AppBaseController
{
    /** @var QuoteRepository */
    public $quoteRepository;

    public function __construct(QuoteRepository $quoteRepo)
    {
        $this->quoteRepository = $quoteRepo;
    }

    /**
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $statusArr = Quote::STATUS_ARR;
        $status = $request->status;

        return view('quotes.index', compact('statusArr', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $data = $this->quoteRepository->getSyncList();

        return view('quotes.create')->with($data);
    }

    public function store(CreateQuoteRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->status = Quote::DRAFT;
            $quote = $this->quoteRepository->saveQuote($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($quote,__('messages.flash.quote_saved_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show(Quote $quote): \Illuminate\View\View
    {
        $quoteData = $this->quoteRepository->getQuoteData($quote);

        return view('quotes.show')->with($quoteData);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Quote $quote)
    {
        if ($quote->status == Quote::CONVERTED) {
            Flash::error(__('messages.flash.converted_quote_can_not_editable'));

            return redirect()->route('quotes.index');
        }
        $data = $this->quoteRepository->prepareEditFormData($quote);

        return view('quotes.edit', compact('quote'))->with($data);
    }

    public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $quote = $this->quoteRepository->updateQuote($quote->id, $input);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($quote, __('messages.flash.quote_updated_successfully'));
    }

    public function destroy(Quote $quote): JsonResponse
    {
        $quote->delete();

        return $this->sendSuccess(__('messages.flash.quote_deleted_successfully'));
    }

    public function getProduct($productId): JsonResponse
    {
        $product = Product::pluck('unit_price', 'id')->toArray();

        return $this->sendResponse($product, __('messages.flash.product_price_retrieved_successfully'));
    }

    public function convertToPdf(Quote $quote): Response
    {
        ini_set('max_execution_time', 36000000);
        $quote->load('client.user', 'invoiceTemplate', 'quoteItems.product', 'quoteItems');
        $quoteData = $this->quoteRepository->getPdfData($quote);
        $invoiceTemplate = $this->quoteRepository->getDefaultTemplate($quote);
        $pdf = Pdf::loadView("quotes.quote_template_pdf.$invoiceTemplate", $quoteData);

        return $pdf->stream('quote.pdf');
    }

    public function convertToInvoice(Request $request): mixed
    {
        $quoteId = $request->quoteId;
        $quote = Quote::whereId($quoteId)->firstOrFail();

        $quoteDatas = $this->quoteRepository->getQuoteData($quote);
        $quoteData = $quoteDatas['quote'];
        $quoteItems = $quoteDatas['quote']['quoteItems'];

        if (! empty(getInvoiceNoPrefix())) {
            $quoteData['quote_id'] = getInvoiceNoPrefix().'-'.$quoteData['quote_id'];
        }
        if (! empty(getInvoiceNoSuffix())) {
            $quoteData['quote_id'] .= '-'.getInvoiceNoSuffix();
        }

        $invoice['invoice_id'] = $quoteData['quote_id'];
        $invoice['client_id'] = $quoteData['client_id'];
        $invoice['invoice_date'] = Carbon::parse($quoteData['quote_date'])->format(currentDateFormat());
        $invoice['due_date'] = Carbon::parse($quoteData['due_date'])->format(currentDateFormat());
        $invoice['amount'] = $quoteData['amount'];
        $invoice['final_amount'] = $quoteData['final_amount'];
        $invoice['discount_type'] = $quoteData['discount_type'];
        $invoice['discount'] = $quoteData['discount'];
        $invoice['note'] = $quoteData['note'];
        $invoice['term'] = $quoteData['term'];
        $invoice['template_id'] = $quoteData['template_id'];
        $invoice['recurring'] = $quoteData['recurring'];
        $invoice['status'] = Invoice::DRAFT;

        $invoice = Invoice::create($invoice);

        foreach ($quoteItems as $quoteItem) {
            $invoiceItem = InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $quoteItem['product_id'],
                'product_name' => $quoteItem['product_name'],
                'quantity' => $quoteItem['quantity'],
                'price' => $quoteItem['price'],
                'total' => $quoteItem['total'],
            ]);
        }

        Quote::whereId($quoteId)->update(['status' => Quote::CONVERTED]);

        return $this->sendSuccess(__('messages.flash.converted_to_invoice_successfully'));
    }

    public function exportQuotesExcel(): BinaryFileResponse
    {
        return Excel::download(new AdminQuotesExport(), 'quote-excel.xlsx');
    }

    public function getPublicQuotePdf($quoteId)
    {
        $quote = Quote::whereQuoteId($quoteId)->firstOrFail();
        $quote->load('client.user', 'invoiceTemplate', 'quoteItems.product', 'quoteItems');

        $quoteData = $this->quoteRepository->getPdfData($quote);
        $invoiceTemplate = $this->quoteRepository->getDefaultTemplate($quote);
        $pdf = Pdf::loadView("quotes.quote_template_pdf.$invoiceTemplate", $quoteData);

        return $pdf->stream('quote.pdf');
    }

    public function showPublicQuote($quoteId): View|Factory|Application
    {
        $quote = Quote::with('client.user')->whereQuoteId($quoteId)->first();
        $quoteData = $this->quoteRepository->getQuoteData($quote);
        $quoteData['statusArr'] = Quote::STATUS_ARR;
        $quoteData['status'] = $quote->status;
        $quoteData['userLang'] = $quote->client->user->language;
        $language = $quote->client->user->language ?? 'en';
        App::setLocale($language);

        return view('quotes.public-quote.public_view')->with($quoteData);
    }

    public function exportQuotesPdf(): Response
    {
        ini_set('max_execution_time', 36000000);
        $data['quotes'] = Quote::with('client.user')->orderBy('created_at', 'desc')->get();
        $quotesPdf = Pdf::loadView('quotes.export_quotes_pdf', $data);

        return $quotesPdf->download('Quotes.pdf');
    }
}
