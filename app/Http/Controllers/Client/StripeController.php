<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\AppBaseController;
use App\Models\Invoice;
use App\Repositories\StripeRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class StripeController extends AppBaseController
{
    /**
     * @var StripeRepository
     */
    private $stripeRepository;

    public function __construct(StripeRepository $stripeRepository)
    {
        $this->stripeRepository = $stripeRepository;
    }

    public function createSession(Request $request)
    {
        $amount = $request->get('amount');
        $payable_amount = $request->get('payable_amount');
        $transactionNotes = $request->get('transactionNotes');
        $invoice = Invoice::with('client.user')->where('id', $request->get('invoiceId'))->firstOrFail();
        $invoiceId = $invoice->invoice_id;
        $client = $invoice->client->user;
        $user = $request->user() ?? $client;
        $userEmail = $user->email;

        try {
            setStripeApiKey();
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $userEmail,
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => 'BILL OF PRODUCT #'.$invoiceId,
                                'description' => 'BILL OF PRODUCT #'.$invoiceId,
                            ],
                            'unit_amount' => (getInvoiceCurrencyCode($invoice->currency_id) != 'JPY') ? $amount * 100 : $amount,
                            'currency' => getInvoiceCurrencyCode($invoice->currency_id),
                        ],
                        'quantity' => 1,
                    ],
                ],
                'metadata' => [
                    'description' => $transactionNotes,
                ],
                'billing_address_collection' => 'auto',
                'client_reference_id' => $request->get('invoiceId'),
                'mode' => 'payment',
                'success_url' => url('client/payment-success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url('client/failed-payment?error=payment_cancelled'),
            ]);
            $result = [
                'sessionId' => $session['id'],
            ];

            return $this->sendResponse($result, 'Session created successfully.');
        } catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    /**
     * @return Application|RedirectResponse|Redirector
     *
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $sessionId = $request->get('session_id');

        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }

        $this->stripeRepository->clientPaymentSuccess($sessionId);

        $sessionData = \Stripe\Checkout\Session::retrieve($sessionId);
        $invoiceId = $sessionData->client_reference_id;

        /** @var Invoice $invoice */
        $invoice = Invoice::with(['payments', 'client'])->findOrFail($invoiceId);

        Flash::success('Payment successfully done.');
        if (! Auth()->check()) {
            return redirect(route('invoice-show-url', $invoice->invoice_id));
        }

        return redirect(route('client.invoices.index'));
    }

    public function handleFailedPayment(): RedirectResponse
    {
        Flash::error('Your Payment is Cancelled');

        return redirect()->route('client.invoices.index');
    }
}
