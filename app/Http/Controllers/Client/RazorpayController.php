<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\AppBaseController;
use App\Mail\ClientMakePaymentMail;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Razorpay\Api\Api;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RazorpayController extends AppBaseController
{
    public function onBoard(Request $request): JsonResponse
    {
        $invoice = Invoice::with('client.user')->where('id', $request->invoice_id)->firstOrFail();
        $client = $invoice->client->user;
        $user = Auth::check() ? Auth::user() : $client;
        $invoiceId = $invoice->invoice_id;
        $razorpayKey = getSettingValue('razorpay_key');
        $razorpaySecret = getSettingValue('razorpay_secret');
        $api = new Api(isset($razorpayKey) ? $razorpayKey : config('payments.razorpay.key'),
            isset($razorpaySecret) ? $razorpaySecret : config('payments.razorpay.secret'));
        $orderData = [
            'receipt' => "1",
            'amount' => $request->amount * 100, // 100 = 1 rupees
            'currency' => getInvoiceCurrencyCode($invoice->currency_id),
            'notes' => [
                'email' => $user->email,
                'name' => $user->full_name,
                'invoiceID' => $request->invoice_id,
            ],
        ];
        $razorpayOrder = $api->order->create($orderData);

        $data['id'] = $razorpayOrder->id;
        $data['amount'] = $request->amount;
        $data['name'] = $user->full_name;
        $data['email'] = $user->email;
        $data['invoiceId'] = $request->invoice_id;
        $data['invoice_id'] = $invoiceId;
        $data['description'] = $request->get('notes');

        return $this->sendResponse($data, 'Payment create successfully');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $input = $request->all();
        Log::info('RazorPay Payment Successfully');
        Log::info($input);
        $razorpayKey = getSettingValue('razorpay_key');
        $razorpaySecret = getSettingValue('razorpay_secret');
        $api = new Api($razorpayKey ?? config('payments.razorpay.key'),
            $razorpaySecret ?? config('payments.razorpay.secret'));
        if (count($input) && ! empty($input['razorpay_payment_id'])) {
            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $generatedSignature = hash_hmac('sha256', $payment['order_id'].'|'.$input['razorpay_payment_id'],
                    $razorpaySecret ?? config('payments.razorpay.secret'));

                if ($generatedSignature != $input['razorpay_signature']) {
                    return redirect()->back();
                }
                DB::beginTransaction();
                // Create Transaction Here
                $invoiceId = $payment['notes']['invoiceID'];
                $transactionNote = $payment['description'];
                $paymentAmount = $payment['amount'] / 100;
                $invoice = Invoice::with(['client.user', 'payments'])->whereId($invoiceId)->firstOrFail();

                if ($invoice->status == Payment::PARTIALLYPAYMENT) {
                    $totalAmount = ($invoice->final_amount - $invoice->payments->sum('amount'));
                } else {
                    $totalAmount = $invoice->final_amount;
                }

                if (round($totalAmount, 2) == $paymentAmount) {
                    $invoice->status = Payment::FULLPAYMENT;
                    $invoice->save();
                } elseif (round($totalAmount, 2) != $paymentAmount) {
                    $invoice->status = Payment::PARTIALLYPAYMENT;
                    $invoice->save();
                }

                $transaction = [
                    'transaction_id' => $payment->id,
                    'amount' => $paymentAmount,
                    'user_id' => $invoice->client->user->id,
                    'status' => 'paid',
                    'meta' => $payment->toArray(),
                ];
                $transaction = Transaction::create($transaction);

                $PaymentData = [
                    'invoice_id' => $invoiceId,
                    'amount' => $payment['amount'] / 100,
                    'payment_mode' => Payment::RAZORPAY,
                    'payment_date' => Carbon::now(),
                    'transaction_id' => $transaction->id,
                    'notes' => $transactionNote,
                    'is_approved' => Payment::APPROVED,
                ];
                $payment = Payment::create($PaymentData);

                //notification
                $title = 'Payment '.getInvoiceCurrencyIcon($invoice->currency_id).$paymentAmount.' received successfully for #'.$invoice->invoice_id.'.';

                addNotification([
                    Notification::NOTIFICATION_TYPE['Invoice Payment'],
                    getAdminUser()->id,
                    $title,
                ]);

                $invoiceData = [];
                $invoiceData['amount'] = $payment->amount;
                $invoiceData['payment_date'] = $payment->payment_date;
                $invoiceData['invoice_id'] = $invoice->id;
                $invoiceData['invoice'] = $invoice;

                if (getSettingValue('mail_notification')) {
                    Mail::to(getAdminUser()->email)->send(new ClientMakePaymentMail($invoiceData));
                }
                Flash::success('Payment successfully done.');

                DB::commit();
                if (! Auth()->check()) {
                    return redirect(route('invoice-show-url', $invoice->invoice_id));
                }

                return redirect(route('client.invoices.index'));
            } catch (Exception $e) {
                DB::rollBack();
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        }

        return redirect()->back();
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function paymentFailed(Request $request): RedirectResponse
    {
        $data = $request->get('data');
        Log::info('payment failed');
        Log::info($data);

        Flash::error('Your Payment is Cancelled.');

        return redirect(route('client.invoices.index'));
    }

    public function paymentSuccessWebHook(Request $request)
    {
        $input = $request->all();
        Log::info('webHook Razorpay');
        Log::info($input);
        if (isset($input['event']) && $input['event'] == 'payment.captured' && isset($input['payload']['payment']['entity'])) {
            $payment = $input['payload']['payment']['entity'];
        }

        return false;
    }
}
