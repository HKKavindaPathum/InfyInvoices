<div class="my-3 my-sm-3">
    <div class="date-ranger-picker">
        <input class="form-control text-center removeFocus" id="quoteDateRangePicker">
    </div>
</div>
<div wire:ignore>
    <div class="ms-0 ms-md-2">
        <div class="dropdown d-flex align-items-center me-2">
            <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
                data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false" id="quoteFilterBtn">
                <i class='fas fa-filter'></i>
            </button>
            <div class="dropdown-menu py-0" aria-labelledby="quoteFilterBtn">
                <div class="text-start border-bottom py-4 px-7">
                    <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
                </div>
                <div class="p-5">
                    @php
                        $statusArr = collect($filterHeads[0])
                            ->sortBy('key')
                            ->reverse()
                            ->toArray();
                    @endphp
                    <div class="mb-5">
                        <label for="exampleInputSelect2"
                            class="form-label">{{ __('messages.common.status') . ':' }}</label>
                        {{ Form::select('status', getTranslatedData($statusArr), \App\Models\Quote::STATUS_ALL, ['id' => 'quoteStatus', 'class' => 'form-select']) }}
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="reset" id="resetQuoteStatusFilter"
                            class="btn btn-secondary">{{ __('messages.common.reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
