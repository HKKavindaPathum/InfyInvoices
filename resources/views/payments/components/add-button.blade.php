<div class="my-3 my-sm-3" wire:ignore>
    <div class="date-ranger-picker me-2">
        <input type="text" class="form-control text-center removeFocus" placeholder="Pick date range"
            id="paymentDateFilter">
    </div>
</div>
<div class="dropdown my-3 my-sm-3 me-2">
    <button class="btn btn-success text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        {{ __('messages.common.export') }}
    </button>
    <ul class="dropdown-menu export-dropdown">
        <a id="adminPaymentExcelExport"  type="button" class="btn btn-outline-success dropdown-item">
            <i class="fas fa-file-excel me-1"></i> {{ __('messages.invoice.excel_export') }}
        </a>
        <a id="adminPaymentPdfExport" type="button" class="btn btn-outline-info me-2 dropdown-item" >
            <i class="fas fa-file-pdf me-1"></i> {{ __('messages.pdf_export') }}
        </a>
    </ul>
</div>
<div>
    <button type="button" class="btn btn-primary addPayment">
        {{ __('messages.payment.add_payment') }}
    </button>
</div>
