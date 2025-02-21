@extends('layouts.app')
@section('title')
    {{ __('messages.invoice.invoice_details') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                @php $isEdit = $invoice->status == 2 || $invoice->status == 3 ? 1 : 0; @endphp
                @if ($isEdit != 1)
                    <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}"
                        class="btn btn-primary me-4">{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('invoices.show_fields', ['isPublicView' => true])
        </div>
    </div>
    @include('transactions.payment-notes-modal')
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/invoice/invoice_payment_history.js') }}"></script>
    <script src="{{ asset('assets/js/invoice/invoice_send.js') }}"></script>
@endsection
