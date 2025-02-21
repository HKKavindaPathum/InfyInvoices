<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ getAppName() }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(getSettingValue('favicon_icon')) }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!-- General CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/page.css') }}">
    @if (!Auth::user()->dark_mode)
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins.css') }}">
        <link href="{{ mix('assets/css/full-screen.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.dark.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins.dark.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/phone-number-dark.css') }}">
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    @endif
    @livewireStyles
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables-thirdparty.min.css') }}">

    @livewireScripts
    <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js') }}"></script>
	<script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js') }}"></script>

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
        @if (!empty($stripeKey))
            let stripe = Stripe('{{ $stripeKey ?? config('services.stripe.key') }}');
        @endif
        let invoiceStripePaymentUrl = '{{ route('client.stripe-payment') }}';
        let getUserLanguages = "{{ getCurrentLanguageName() }}";
        Lang.setLocale(getUserLanguages);
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
    <script src="{{ mix('assets/js/pages.js') }}"></script>
</head>
@php $styleCss = 'style'; @endphp

<body class="overflow-x-hidden">
    @yield('phone_js')
    <div class="d-flex flex-column flex-root vh-100">
        <div class="d-flex flex-row flex-column-fluid">
            @include('client_panel.layouts.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid">
                <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                    @include('layouts.header')
                </div>
                <div class='content d-flex flex-column flex-column-fluid pt-7'>
                    @yield('header_toolbar')
                    <div class='d-flex flex-column-fluid'>
                        @yield('content')
                    </div>
                </div>
                <div class='container-fluid'>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
    @include('profile.changePassword')
    @include('profile.changelanguage')
</body>

</html>
