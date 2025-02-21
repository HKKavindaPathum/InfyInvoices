<?php

namespace App\Repositories;

use App\Models\PaymentQrCode;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PaymentQrCodeRepository
 */
class PaymentQrCodeRepository extends BaseRepository
{
    public $fieldSearchable = [
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return PaymentQrCode::class;
    }

    public function store($input)
    {
        try {
            DB::beginTransaction();
            $paymentQrCode = PaymentQrCode::create($input);

            if (isset($input['qr_image']) && ! empty($input['qr_image'])) {
                $paymentQrCode->addMedia($input['qr_image'])->toMediaCollection(PaymentQrCode::PAYMENT_QR_CODE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updatePaymentQRCode($input, $paymentQrCode): bool
    {
        try {
            DB::beginTransaction();
            $paymentQrCode->update($input);

            if (isset($input['qr_image']) && ! empty($input['qr_image'])) {
                $paymentQrCode->clearMediaCollection(PaymentQrCode::PAYMENT_QR_CODE);
                $paymentQrCode->addMedia($input['qr_image'])->toMediaCollection(PaymentQrCode::PAYMENT_QR_CODE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
