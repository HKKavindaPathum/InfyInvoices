<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice | {{ getAppName() }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(getSettingValue('favicon_icon')) }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!-- General CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/page.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins.css') }}">
    <link href="{{ mix('assets/css/full-screen.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-turbolinks-eval="false" data-turbo-eval="false">
    </script>
    <script src="{{ asset('assets/js/third-party.js') }}"></script>
    <script src="{{ asset('messages.js') }}"></script>
    <script data-turbo-eval="false">
        let sweetAlertIcon = "{{ asset('images/remove.png') }}";
        let decimalsSeparator = "{{ getSettingValue('decimal_separator') }}";
        let thousandsSeparator = "{{ getSettingValue('thousand_separator') }}";
        let changePasswordUrl = "{{ route('user.changePassword') }}";
        let currentDateFormat = "{{ currentDateFormat() }}";
        let momentDateFormat = "{{ momentJsCurrentDateFormat() }}";
        let currency = "{{ getCurrencySymbol() }}";
        let getUserLanguages = "{{ $userLang }}";
        let currentRouteName = "{{ Route::currentRouteName() }}";
        Lang.setLocale(getUserLanguages)
        @if (!empty($stripeKey))
            let stripe = Stripe('{{ $stripeKey ?? config('services.stripe.key') }}');
        @endif
        let invoiceStripePaymentUrl = '{{ route('client.stripe-payment') }}';
        let options = {
            'key': "{{ config('payments.razorpay.key') }}",
            'amount': 0, //  100 refers to 1
            'currency': 'INR',
            'name': "{{ getAppName() }}",
            'order_id': '',
            'description': '',
            'image': '{{ asset(getLogoUrl()) }}', // logo here
            'callback_url': "{{ route('razorpay.success') }}",
            'prefill': {
                'email': '', // client email here
                'name': '', // client name here
                'invoiceId': '', //invoice id
            },
            'readonly': {
                'name': 'true',
                'email': 'true',
                'invoiceId': 'true',
            },
            'theme': {
                'color': '#4FB281',
            },
            'modal': {
                'ondismiss': function() {
                    $('#paymentForm').modal('hide');
                    displayErrorMessage('Payment not completed.');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
            },
        };
    </script>
    @routes
    <script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom.js') }}"></script>
    <script src="{{ mix('assets/js/client_panel/invoice/invoice.js') }}"></script>
</head>
@php $styleCss = 'style'; @endphp

<body>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row">
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                        <div class="p-12">
                            @include('flash::message')
                            <div class="card">
                                {{ Form::open(['id' => 'clientPaymentForm']) }}
                                <div class="card-body">
                                    <div class="alert alert-danger display-none hide" id="editValidationErrorsBox">
                                    </div>
                                    {{ Form::hidden('invoice_id', $totalPayable['id'], ['id' => 'client_invoice_id']) }}
                                    <div class="row">
                                        <div class="form-group col-sm-6 mb-5">
                                            {{ Form::label('payable_amount', __('messages.payment.payable_amount') . ':', ['class' => 'form-label mb-3']) }}
                                            <div class="input-group mb-5">
                                                {{ Form::text('payable_amount', $totalPayable['total_amount'], ['id' => 'payable_amount', 'class' => 'form-control ', 'readonly']) }}
                                                <a class="input-group-text bg-secondary cursor-default text-decoration-none"
                                                    href="javascript:void(0)">
                                                    <span>{{ getInvoiceCurrencyIcon($invoice->currency_id) }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 mb-5">
                                            {{ Form::label('payment_type', __('messages.payment.payment_type') . ':', ['class' => 'form-label required mb-3']) }}
                                            {{ Form::select('payment_type', $paymentType, null, ['id' => 'client_payment_type', 'class' => 'form-select', 'placeholder' => 'Select Payment Type', 'required']) }}
                                        </div>
                                        <div class="form-group col-sm-6 mb-5 amount">
                                            {{ Form::label('amount', __('messages.invoice.amount') . ':', ['class' => 'form-label required mb-3']) }}
                                            {{ Form::number('amount', null, ['id' => 'amount', 'class' => 'form-control', 'step' => 'any', 'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '')", 'required']) }}
                                            <span id="error-msg" class="text-danger"></span>
                                        </div>
                                        <div class="form-group col-sm-6 mb-5">
                                            {{ Form::label('payment_mode', __('messages.payment.payment_method') . ':', ['class' => 'form-label required mb-3']) }}
                                            {{ Form::select('payment_mode', $paymentMode, null, ['id' => 'client_payment_mode', 'class' => 'form-select', 'placeholder' => 'Select Payment Method', 'required']) }}
                                        </div>
                                        <div class="form-group col-sm-6 mb-5" id="transaction">
                                            {{ Form::label('transactionId', __('messages.payment.transaction_id') . ':', ['class' => 'form-label mb-3']) }}
                                            {{ Form::text('transaction_id', null, ['id' => 'transactionId', 'class' => 'form-control']) }}
                                        </div>
                                        <div class="form-group col-sm-12 mb-5">
                                            {{ Form::label('notes', __('messages.invoice.note') . ':', ['class' => 'form-label required mb-3']) }}
                                            {{ Form::textarea('notes', null, ['id' => 'payment_note', 'class' => 'form-control', 'rows' => '5', 'required']) }}
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer pt-0">
                                    {{ Form::button(__('messages.common.pay'), ['type' => 'submit', 'class' => 'btn btn-primary me-2', 'id' => 'btnPay', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing...", 'data-new-text' => __('messages.common.pay')]) }}
                                    <a href="{{ route('client.invoices.index') }}" type="reset"
                                        class="btn btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
