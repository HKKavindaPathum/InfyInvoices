<div class="d-flex" wire:ignore>
    @if (Route::currentRouteName() == 'transactions.index')
        <div class="my-3 my-sm-3">
            <div class="date-ranger-picker">
                <input class="form-control text-center removeFocus" id="transactionDateRangePicker">
            </div>
        </div>
    @endif
    <div class="ms-auto mt-3">
        <div class="ms-0 ms-md-2">
            <div class="dropdown d-flex align-items-center me-4 me-md-2">
                <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0"
                    type="button" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false"
                    id="transactionFilterBtn">
                    <i class='fas fa-filter'></i>
                </button>
                <div class="dropdown-menu py-0" aria-labelledby="transactionFilterBtn">
                    <div class="text-start border-bottom py-4 px-7">
                        <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
                    </div>
                    <div class="p-5">
                        <div class="mb-5">
                            <label
                                class="form-label fs-6 fw-bold">{{ __('messages.payment.payment_method') . ':' }}</label>
                            {{ Form::select('payment_mode',collect($filterHeads[0])->sortBy('key')->toArray(),null,['class' => 'form-select role-selector payment-mode-filter', 'data-control' => 'select2']) }}
                        </div>
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">{{ __('messages.common.status') . ':' }}</label>
                            <br>
                            {{ Form::select('is_approved',collect($filterHeads[1])->sortBy('key')->toArray(),null,['class' => 'form-select role-selector payment-status-filter', 'data-control' => 'select2']) }}
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" id="transactionResetFilter"
                                class="btn btn-secondary">{{ __('messages.common.reset') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dropdown my-3 my-sm-3">
        <button class="btn btn-success text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ __('messages.common.export') }}
        </button>
        <ul class="dropdown-menu export-dropdown">
            <a href="{{ getLogInUser()->hasRole('admin') ? route('admin.transactionsExcel') : route('client.transactionsExcel') }}"
                class="dropdown-item" >
                <i class="fas fa-file-excel me-1"></i> {{ __('messages.invoice.excel_export') }}
            </a>
            <a href="{{ getLogInUser()->hasRole('admin') ? route('admin.export.transactions.pdf') : route('client.export.transactions.pdf') }}"
                class="dropdown-item" >
                <i class="fas fa-file-pdf me-1"></i> {{ __('messages.pdf_export') }}
            </a>
        </ul>
    </div>
</div>
