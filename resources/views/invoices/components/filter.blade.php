<div class="my-3 my-sm-3">
    <div class="date-ranger-picker">
        <input class="form-control text-center removeFocus" id="invoiceDateRangePicker">
    </div>
</div>
<div wire:ignore>
    <div class="ms-0 ms-md-2">
        <div class="dropdown d-flex align-items-center me-4 me-md-2" wire:ignore>
            <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
                id="invoiceFilterBtn" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">
                <p class="text-center">
                    <i class='fas fa-filter'></i>
                </p>
            </button>
            <div class="dropdown-menu py-0" aria-labelledby="invoiceFilterBtn">
                <div class="text-start border-bottom py-4 px-7">
                    <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
                </div>
                <div class="p-5">
                    <div class="mb-5">
                        <label for="filterBtn" class="form-label">{{ __('messages.common.status') }}:</label>
                        {{ Form::select('status', getTranslatedData($filterHeads[0]), \App\Models\Invoice::STATUS_ALL, [
                            'class' => 'form-control form-control-solid form-select',
                            'data-control' => 'select2',
                            'id' => 'invoiceStatus',
                        ]) }}
                    </div>
                    <div class="mb-5">
                        <label for="filterBtn"
                            class="form-label">{{ __('messages.invoice.recurring') . ' ' . __('messages.common.status') }}
                            :</label>
                        {{ Form::select(
                            'recurring_status',
                            collect($filterHeads[1])->sortBy('key')->reverse()->toArray(),
                            null,
                            [
                                'class' => 'form-control form-control-solid form-select',
                                'id' => 'recurringStatus',
                                'placeholder' => 'All',
                            ],
                        ) }}
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary"
                            id="resetInvoiceFilter">{{ __('messages.common.reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
