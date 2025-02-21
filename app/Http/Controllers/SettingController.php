<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\InvoiceSetting;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class SettingController extends AppBaseController
{
    /** @var SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Request $request): \Illuminate\View\View
    {
        $defaultSettings = $this->settingRepository->editSettingsData();
        $sectionName = ($request->section === null) ? 'general' : $request->section;

        return view("settings.$sectionName", compact('sectionName'), $defaultSettings);
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $this->settingRepository->updateSetting($request->all());
        Flash::success(__('messages.flash.setting_updated_successfully'));

        return redirect()->back();
    }

    //Invoice Update
    public function invoiceUpdate(Request $request): RedirectResponse
    {
        $this->settingRepository->updateInvoiceSetting($request->all());
        Flash::success(__('messages.flash.invoice_template_updated_successfully'));

        return redirect('admin/settings?section=setting-invoice');
    }

    public function editInvoiceTemplate($key): mixed
    {
        $invoiceTemplate = InvoiceSetting::where('key', $key)->get();

        return $this->sendResponse($invoiceTemplate, 'InvoiceTemplate retrieved successfully.');
    }

    /**
     * @return Application|Factory|View
     */
    public function invoiceSettings(): \Illuminate\View\View
    {
        $data['settings'] = $this->settingRepository->getSyncList();

        return view('settings.invoice-settings', $data);
    }
}
