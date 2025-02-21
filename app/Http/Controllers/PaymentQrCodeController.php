<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentQrCodeRequest;
use App\Http\Requests\UpdatePaymentQrCodeRequest;
use App\Models\PaymentQrCode;
use App\Repositories\PaymentQrCodeRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PaymentQrCodeController extends AppBaseController
{
    /** @var PaymentQrCodeRepository */
    public $paymentQrCodeRepository;

    public function __construct(PaymentQrCodeRepository $paymentQrCodeRepo)
    {
        $this->paymentQrCodeRepository = $paymentQrCodeRepo;
    }

    /**
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(): \Illuminate\View\View
    {
        return view('payment_qr_codes.index');
    }

    public function store(CreatePaymentQrCodeRequest $request): mixed
    {
        $input = $request->all();
        $this->paymentQrCodeRepository->store($input);

        return $this->sendSuccess(__('messages.flash.payment_qr_code_saved_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentQrCode $paymentQrCode): mixed
    {
        return $this->sendResponse($paymentQrCode, 'Payment QR Code data retrieved successfully.');
    }

    public function update(UpdatePaymentQrCodeRequest $request, PaymentQrCode $paymentQrCode): mixed
    {
        $input = $request->all();
        $this->paymentQrCodeRepository->updatePaymentQRCode($input, $paymentQrCode);

        return $this->sendSuccess(__('messages.flash.payment_qr_code_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentQrCode $paymentQrCode): mixed
    {
        $paymentQrCode->delete();

        return $this->sendSuccess(__('messages.flash.payment_qr_code_deleted_successfully'));
    }

    public function defaultStatus(PaymentQrCode $paymentQrCode)
    {
        $status = ! $paymentQrCode->is_default;
        PaymentQrCode::query()->update(['is_default' => 0]);
        $paymentQrCode->update(['is_default' => $status]);

        return $this->sendSuccess(__('messages.flash.payment_qr_code_status_updated_successfully'));
    }
}
