<?php

namespace App\Http\Controllers;

use App\Repositories\paymentGatewayRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class PaymentGatewayController extends Controller
{
    private $paymentGatewayRepository;

    public function __construct(paymentGatewayRepository $paymentGatewayRepo)
    {
        $this->paymentGatewayRepository = $paymentGatewayRepo;
    }

    public function show(Request $request): View
    {
        $paymentGateway = $this->paymentGatewayRepository->edit();
        $sectionName = ($request->section === null) ? 'payment-gateway' : $request->section;

        return view("settings.$sectionName", ['paymentGateway' => $paymentGateway, 'section' => $sectionName]);
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();

        try {
            $this->paymentGatewayRepository->store($input);
            Flash::success(__('messages.flash.setting_updated_successfully'));
        } catch (\Exception $exception) {
            Flash::error($exception->getMessage());
        }

        return redirect(route('payment-gateway.show'));
    }
}
