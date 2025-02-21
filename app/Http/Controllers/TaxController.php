<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaxRequest;
use App\Http\Requests\UpdateTaxRequest;
use App\Models\InvoiceItemTax;
use App\Models\Tax;
use App\Repositories\TaxRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TaxController extends AppBaseController
{
    /** @var TaxRepository */
    public $taxRepository;

    public function __construct(TaxRepository $taxRepo)
    {
        $this->taxRepository = $taxRepo;
    }

    /**
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        return view('taxes.index');
    }

    public function store(CreateTaxRequest $request): mixed
    {
        $input = $request->all();
        if ($input['is_default'] == '1') {
            Tax::where('is_default', '=', 1)->update(['is_default' => 0]);
            $tax = $this->taxRepository->create($input);
        } else {
            $tax = $this->taxRepository->create($input);
        }

        return $this->sendResponse($tax, __('messages.flash.tax_saved_successfully'));
    }

    public function edit(Tax $tax): mixed
    {
        return $this->sendResponse($tax, __('messages.flash.tax_retrieved_successfully'));
    }

    public function update(UpdateTaxRequest $request, $taxId): mixed
    {
        $input = $request->all();
        if ($input['is_default'] == '1') {
            Tax::where('is_default', '=', 1)->update(['is_default' => 0]);
            $this->taxRepository->update($input, $taxId);
        } else {
            $this->taxRepository->update($input, $taxId);
        }

        return $this->sendSuccess(__('messages.flash.tax_updated_successfully'));
    }

    /**
     * @return mixed
     */
    public function destroy(Tax $tax)
    {
        $invoiceModels = [
            InvoiceItemTax::class,
        ];
        $result = canDelete($invoiceModels, 'tax_id', $tax->id);
        if ($result) {
            return $this->sendError(__('messages.flash.tax_can_not_deleted'));
        }
        $tax->delete();

        return $this->sendSuccess(__('messages.flash.tax_deleted_successfully'));
    }

    public function defaultStatus(Tax $tax)
    {
        Tax::where('is_default', '=', 1)->update(['is_default' => 0]);
        $tax->update(['is_default' => ! $tax->is_default]);

        return $this->sendSuccess(__('messages.flash.status_updated_successfully'));
    }
}
