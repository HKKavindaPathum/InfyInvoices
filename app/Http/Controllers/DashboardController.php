<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Laracasts\Flash\Flash;

class DashboardController extends AppBaseController
{
    /* @var DashboardRepository */
    public $dashboardRepository;

    /**
     * DashboardController constructor.
     */
    public function __construct(DashboardRepository $dashboardRepo)
    {
        $this->dashboardRepository = $dashboardRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('dashboard.index');
    }

    public function paymentOverview(): mixed
    {
        $data = $this->dashboardRepository->getPaymentOverviewData();

        return $this->sendResponse($data, __('messages.flash.payment_overview_status_retrieved_successfully'));
    }

    public function invoiceOverview(): mixed
    {
        $data = $this->dashboardRepository->getInvoiceOverviewData();

        return $this->sendResponse($data,__('messages.flash.payment_overview_status_retrieved_successfully'));
    }

    public function getYearlyIncomeChartData(Request $request): JsonResponse
    {
        $input = $request->all();

        $data = $this->dashboardRepository->prepareYearlyIncomeChartData($input);

        return $this->sendResponse($data,__('messages.flash.yearly_income_overview_chart_data_retrieved_successfully'));
    }

    public function clearCache(): RedirectResponse
    {
        Artisan::call('cache:clear');
        Flash::success(__('messages.flash.application_cache_cleared'));

        return redirect()->back();
    }

    public function currencyReports(): \Illuminate\View\View
    {
        $currencyData = $this->dashboardRepository->getAdminCurrencyData();

        return view('dashboard.currency_reports', compact('currencyData'));
    }
}
