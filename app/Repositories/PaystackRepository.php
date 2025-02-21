<?php

namespace App\Repositories;

use App\Mail\ClientMakePaymentMail;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PaystackRepository
 */
class PaystackRepository
{
    public function paymentSuccess($invoiceId, $transactionId, $amount, $metaData)
    {
        try {
            DB::beginTransaction();

            /** @var Invoice $invoice */
            $invoice = Invoice::with(['payments', 'client'])->findOrFail($invoiceId);
            $userId = Auth::check() ? getLogInUserId() : $invoice->client->user_id;

            $transactionData = [
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'user_id' => $userId,
                'status' => 'paid',
                'meta' => $metaData,
            ];

            $transaction = Transaction::create($transactionData);

            if ($invoice->status == Payment::PARTIALLYPAYMENT) {
                $totalAmount = ($invoice->final_amount - $invoice->payments->sum('amount'));
            } else {
                $totalAmount = $invoice->final_amount;
            }

            $note = session('note');

            $paymentData = [
                'invoice_id' => $invoiceId,
                'amount' => $amount,
                'payment_mode' => Payment::PAYSTACK,
                'payment_date' => Carbon::now(),
                'transaction_id' => $transaction->id,
                'notes' => $note,
                'is_approved' => Payment::APPROVED,
            ];

            // update invoice bill
            Payment::create($paymentData);
            session()->forget('note');

            if (round($totalAmount, 2) == $amount) {
                $invoice->status = Payment::FULLPAYMENT;
                $invoice->save();
            } else {
                if (round($totalAmount, 2) != $amount) {
                    $invoice->status = Payment::PARTIALLYPAYMENT;
                    $invoice->save();
                }
            }

            $this->saveNotification($paymentData, $invoice);
            $invoiceData = [];
            $invoiceData['amount'] = $paymentData['amount'];
            $invoiceData['payment_date'] = $paymentData['payment_date'];
            $invoiceData['invoice_id'] = $invoice->id;
            $invoiceData['invoice'] = $invoice;

            if (getSettingValue('mail_notification')) {
                Mail::to(getAdminUser()->email)->send(new ClientMakePaymentMail($invoiceData));
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function saveNotification($input, $invoice)
    {
        $adminUserId = getAdminUser()->id;
        $invoice = Invoice::find($input['invoice_id']);
        $title = 'Payment '.getInvoiceCurrencyIcon($invoice->currency_id).$input['amount'].' received successfully for #'.$invoice->invoice_id.'.';
        addNotification([
            Notification::NOTIFICATION_TYPE['Invoice Payment'],
            $adminUserId,
            $title,
        ]);
    }
}
