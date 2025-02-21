<?php

namespace App\Http\Controllers\Client;

use App\Exports\ClientQuotesExport;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateClientQuoteRequest;
use App\Http\Requests\UpdateClientQuoteRequest;
use App\Models\Product;
use App\Models\Quote;
use App\Repositories\ClientQuoteRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class QuoteController extends AppBaseController
{
    /** @var ClientQuoteRepository */
    public $clientQuoteRepository;

    public function __construct(ClientQuoteRepository $quoteRepo)
    {
        $this->clientQuoteRepository = $quoteRepo;
    }

    public function index(): \Illuminate\View\View
    {
        return view('client_panel.quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $data = $this->clientQuoteRepository->getSyncList();

        return view('client_panel.quotes.create')->with($data);
    }

    public function store(CreateClientQuoteRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $request->status = Quote::DRAFT;
            $quote = $this->clientQuoteRepository->saveQuote($input);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($quote, 'Quote saved successfully.');
    }

    public function show($id)
    {
        $quote = Quote::find($id);
        $quoteData = $this->clientQuoteRepository->getQuoteData($quote);
        if ($quote->client->user_id != Auth::id()) {
            return abort(404);
        }

        return view('client_panel.quotes.show')->with($quoteData);
    }

    /**
     * @return Application|Factory|View|RedirectResponse|\never
     */
    public function edit($id)
    {
        $quote = Quote::find($id);
        if ($quote->status == Quote::CONVERTED) {
            Flash::error('Converted quote can not editable.');

            return redirect()->route('quotes.index');
        }

        if ($quote->client->user_id != Auth::id()) {
            return abort(404);
        }

        $data = $this->clientQuoteRepository->prepareEditFormData($quote);

        return view('client_panel.quotes.edit', compact('quote'))->with($data);
    }

    public function update(UpdateClientQuoteRequest $request, Quote $quote): JsonResponse
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $quote = $this->clientQuoteRepository->updateQuote($quote->id, $input);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($quote, 'Quote updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $quote = Quote::find($id);
        if ($quote->client->user_id != Auth::id()) {
            return $this->sendError('Seems, you are not allowed to access this record.');
        }
        $quote->delete();

        return $this->sendSuccess('Quote Deleted successfully.');
    }

    public function getProduct(): JsonResponse
    {
        $product = Product::toBase()->pluck('unit_price', 'id')->toArray();

        return $this->sendResponse($product, 'Product Price retrieved successfully.');
    }

    public function convertToPdf(Quote $quote): Response
    {
        $clientId = Auth::user()->client->id;
        ini_set('max_execution_time', 36000000);
        $quote->load('client.user', 'invoiceTemplate', 'quoteItems.product', 'quoteItems');

        if ($clientId != $quote->client_id) {
            abort(404);
        }

        $quoteData = $this->clientQuoteRepository->getPdfData($quote);
        $quoteTemplate = $this->clientQuoteRepository->getDefaultTemplate($quote);
        $pdf = Pdf::loadView("quotes.quote_template_pdf.$quoteTemplate", $quoteData);

        return $pdf->stream('quote.pdf');
    }

    public function exportQuotesExcel(): BinaryFileResponse
    {
        return Excel::download(new ClientQuotesExport(), 'quote-excel.xlsx');
    }

    public function exportQuotesPdf(): Response
    {
        $data['quotes'] = Quote::with('client.user')->where('client_id', Auth::user()
                            ->client->id)->orderBy('created_at', 'desc')->get();
        $clientQuotesPdf = Pdf::loadView('quotes.export_quotes_pdf', $data);

        return $clientQuotesPdf->download('Client-Quotes.pdf');
    }
}
