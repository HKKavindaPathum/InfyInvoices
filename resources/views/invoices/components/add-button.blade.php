<div class="dropdown my-3 my-sm-3 me-2">
    <button class="btn btn-success text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        {{ __('messages.common.export') }}
    </button>
    <ul class="dropdown-menu export-dropdown">
        <a href="{{ route('admin.invoicesExcel') }}" class="dropdown-item" >
            <i class="fas fa-file-excel me-1"></i> {{ __('messages.invoice.excel_export') }}
        </a>
        <a href="{{ route('admin.invoices.pdf') }}" class="dropdown-item" >
            <i class="fas fa-file-pdf me-1"></i> {{ __('messages.pdf_export') }}
        </a>
    </ul>
</div>
<div class="my-3 my-sm-3">
    <a href="{{ route('invoices.create') }}"
        class="btn btn-primary">{{ __('messages.invoice.new_invoice') }}</a>
</div>
