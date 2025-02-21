<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Repositories\PaystackRepository;
use Exception;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    /** @var PaystackRepository $paystackRepository */
    public $paystackRepo;

    public function __construct(PaystackRepository $paystackRepository)
    {
        $paystackKey = getSettingValue('paystack_key');
        $paypalSecretKey = getSettingValue('paystack_secret');

        $publicKey = $paystackKey ?? config('paystack.publicKey');
        $secretKey = $paypalSecretKey ?? config('paystack.secretKey');

        config([
            'paystack.publicKey' => $publicKey,
            'paystack.secretKey' => $secretKey,
        ]);

        $this->paystackRepo = $paystackRepository;
    }

    public function redirectToGateway(Request $request)
    {
        $supportedCurrency = ['NGN', 'USD', 'GHS', 'ZAR','KES'];
        $invoiceId = $request->get('invoiceId');
        $amount = $request->get('amount');
        $note = $request->get('note');
        session(['note' => $note]);
        $invoice = Invoice::with('client.user')->find($invoiceId);
        $user = $invoice->client->user;
        $invoiceCurrencyId = $invoice->currency_id;

        if (! in_array(strtoupper(getInvoiceCurrencyCode($invoiceCurrencyId)), $supportedCurrency)) {
            Flash::error(getInvoiceCurrencyCode($invoiceCurrencyId).' is not currently supported.');

            return redirect()->back();
        }

        try {
            $data = [
                'email' => $user->email, // email of recipients
                'amount' => $amount * 100,
                'quantity' => 1, // always 1
                "orderID" => rand(10000, 99999), // generate a random order ID for the client
                'currency' => strtoupper(getInvoiceCurrencyCode($invoiceCurrencyId)),
                'reference' => Paystack::genTranxRef(),
                'metadata' => json_encode(['invoiceId' => $invoiceId]), // this should be related data
            ];

            return Paystack::getAuthorizationUrl($data)->redirectNow();
        } catch (Exception $e) {
            Flash::error(__('messages.flash.paystack_token_expired'));

            return redirect()->back();
        }
    }

    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        if(! $paymentDetails['status']) {
            Flash::error('Payment failed.');

            return redirect(route('client.invoices.index'));
        }

        $invoiceId = $paymentDetails['data']['metadata']['invoiceId'];
        $transactionId = $paymentDetails['data']['reference'];
        $amount = $paymentDetails['data']['amount'] / 100;
        $metaData = json_encode($paymentDetails['data']);

        $this->paystackRepo->paymentSuccess($invoiceId, $transactionId,$amount, $metaData);

        Flash::success('Payment successfully done.');

        if (! Auth()->check()) {
            $invoice = Invoice::find($invoiceId);
            $invoiceUniqueId = $invoice->invoice_id;
            return redirect(route('invoice-show-url', $invoiceUniqueId));
        }

        return redirect(route('client.invoices.index'));
    }
}
