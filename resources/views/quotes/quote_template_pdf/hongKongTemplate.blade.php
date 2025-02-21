<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/media/logos/favicon.ico') }}" type="image/png">
    <title>{{ __('messages.quote.quote_pdf') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/invoice-pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }

        @page {
            margin-top: 40px !important;
            margin-bottom: 40px !important;
        }

        @if (getCurrencySymbol() == '€')
            .euroCurrency {
                font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
            }
        @endif
    </style>
</head>

<body style="padding: 0rem 0rem !important;">
    <div class="preview-main client-preview hongkong-template">
        <div class="d" id="boxes">
            <div class="d-inner">
                <div class="position-relative" style="padding:0 1.5rem;">
                    <div class="bg-img" style="position:absolute; right:0; top:-40px;">
                        <img src="{{ asset('images/hongkong-bg-img.png') }}" alt="hongkong-bg-img" />
                    </div>
                    <div style="padding:0 1rem; ">
                        <div class="invoice-header pt-10">
                            <table class="overflow-hidden w-100">
                                <tr>
                                    <td>
                                        <div class="pt-4">
                                            <img src="{{ getLogoUrl() }}" class="img-logo" alt="logo">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table class="w-100">
                                <tr>
                                    <td class="heading-text">
                                        <div class="text-end">
                                            <h1 class="m-0"
                                                style="font-size: 32px; font-weight:700; letter-spacing:2px;color:{{ $invoice_template_color }};">
                                                {{ __('messages.quote.quote') }}</h1>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pt-3 overflow-auto">
                            <table class="w-100">
                                <tbody>
                                    <tr style="vertical-align:top;">
                                        <td width="40%" class="pe-3">
                                            <p class="mb-1 font-gray-900 fw-bold">
                                                <b>{{ __('messages.common.to') . ':' }}</b>
                                            </p>
                                            <p class="mb-0 text-gray-600" style="white-space:nowrap;">
                                                {{ __('messages.common.name') . ':' }}&nbsp;<span
                                                    class="font-gray-900">
                                                    {{ $client->user->full_name }}</span>
                                            </p>
                                            <p class="mb-0 text-gray-600" style="white-space:nowrap;">
                                                {{ __('messages.common.email') . ':' }}&nbsp;<span
                                                    class="font-gray-900">{{ $client->user->email }}</span>
                                            </p>
                                            <p class="mb-0 text-gray-600">
                                                {{ __('messages.common.address') . ':' }}&nbsp;<span
                                                    class="font-gray-900">{{ $client->address }}
                                                </span>
                                            </p>
                                            @if (!empty($client->vat_no))
                                                <p class="mb-0 font-gray-600">
                                                    {{ getVatNoLabel() . ':' }}&nbsp;<span
                                                        class="font-gray-900">{{ $client->vat_no }}</span>
                                                </p>
                                            @endif
                                        </td>
                                        <td width="30%" class="pe-3">
                                            <p class=" mb-1 font-gray-900">
                                                <b>{{ __('messages.common.from') . ':' }}</b>
                                            </p>
                                            <p class="mb-0 text-gray-600">
                                                {{ __('messages.setting.company_name') . ':' }}&nbsp;<span
                                                    class="font-gray-900">{{ $setting['company_name'] }}</span>
                                            </p>
                                            <p class="mb-0 text-gray-600">
                                                {{ __('messages.common.address') . ':' }}&nbsp;<span
                                                    class="font-gray-900">{!! $setting['company_address'] !!}</span>
                                            </p>
                                            <p class="mb-0 text-gray-600" style="white-space:nowrap;">
                                                {{ __('messages.user.phone') . ':' }}&nbsp;<span class="font-gray-900">
                                                    {{ $setting['company_phone'] }}</span>
                                            </p>
                                            @if (!empty($setting['gst_no']))
                                                <p class="mb-0 text-gray-600" style="white-space:nowrap;">
                                                    {{ getVatNoLabel() . ':' }}&nbsp;<span class="font-gray-900">
                                                        {{ $setting['gst_no'] }}</span>
                                                </p>
                                            @endif
                                        </td>
                                        <td width="30%" class="text-end">
                                            <p class="mb-0 fw-6" style="white-space:nowrap;"><span
                                                    class="font-gray-900"><b>{{ __('messages.quote.quote_id') . ':' }}</b>
                                                </span><span class="font-gray-600">#{{ $quote->quote_id }}</span>
                                            </p>
                                            <p class="mb-0 fw-6" style="white-space:nowrap;"><span
                                                    class="font-gray-900"><b>{{ __('messages.quote.quote_date') . ':' }}</b>
                                                </span><span
                                                    class="font-gray-600">{{ \Carbon\Carbon::parse($quote->quote_date)->translatedFormat(currentDateFormat()) }}</span>
                                            </p>
                                            <p class=" mb-0 fw-6" style="white-space:nowrap;"><span
                                                    class="font-gray-900"><b>{{ __('messages.quote.due_date') . ':' }}</b>
                                                </span><span
                                                    class="font-gray-600">{{ \Carbon\Carbon::parse($quote->due_date)->translatedFormat(currentDateFormat()) }}
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="overflow-auto mt-5">
                            <table class="invoice-table w-100">
                                <thead style="background-color: {{ $invoice_template_color }}">
                                    <tr>
                                        <th class="p-10px fw-6 fs-5"># </th>
                                        <th class="p-10px fw-6 fs-5 in-w-2">{{ __('messages.product.product') }}</th>
                                        <th class="p-10px fw-6 fs-5 text-center">{{ __('messages.invoice.qty') }}</th>
                                        <th class="p-10px fw-6 fs-5 text-center text-nowrap">
                                            {{ __('messages.product.unit_price') }}</th>
                                        <th class="p-10px fw-6 fs-5 text-end text-nowrap">
                                            {{ __('messages.invoice.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($quote))
                                        @foreach ($quote->quoteItems as $key => $quoteItems)
                                            <tr>
                                                <td class="p-10px font-gray-900 fw-6"><span>{{ $key + 1 }}</span>
                                                </td>
                                                <td class="p-10px font-gray-600 in-w-2">
                                                    <p class="fw-6 mb-0 font-gray-900">
                                                        {{ isset($quoteItems->product->name) ? $quoteItems->product->name : $quoteItems->product_name ?? __('messages.common.n/a') }}
                                                    </p>
                                                    @if (
                                                        !empty($quoteItems->product->description) &&
                                                            (isset($setting['show_product_description']) && $setting['show_product_description'] == 1))
                                                        <span
                                                            style="font-size: 12px; word-break: break-all">{{ $quoteItems->product->description }}</span>
                                                    @endif
                                                </td>
                                                <td class="p-10px font-gray-600 text-center">
                                                    {{ $quoteItems->quantity }}</td>
                                                <td class="p-10px font-gray-600 text-center text-nowrap">
                                                    {{ isset($quoteItems->price) ? getCurrencyAmount($quoteItems->price, true) : __('messages.common.n/a') }}
                                                </td>
                                                <td class="p-10px font-gray-600 text-end text-nowrap">
                                                    {{ isset($quoteItems->total) ? getCurrencyAmount($quoteItems->total, true) : __('messages.common.n/a') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            <table class="w-100">
                                <tr>
                                    <td style="width:60%;">
                                    </td>
                                    <td style="width:40%;">
                                        <table class="w-100 border-0">
                                            <tbody>
                                                <tr>
                                                    <td class="text-nowrap font-gray-900 pb-2 px-2">
                                                        <strong>{{ __('messages.quote.amount') . ':' }}</strong>
                                                    </td>
                                                    <td class="text-nowrap text-end font-gray-600 pb-2 px-2 fw-bold">
                                                        {{ getCurrencyAmount($quote->amount, true) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-nowrap font-gray-900 pb-2 px-2">
                                                        <strong>{{ __('messages.quote.discount') . ':' }}</strong>
                                                    </td>
                                                    <td class="text-nowrap text-end font-gray-600 pb-2 px-2 fw-bold">
                                                        @if ($quote->discount == 0)
                                                            <span>{{ __('messages.common.n/a') }}</span>
                                                        @else
                                                            @if (isset($quote) && $quote->discount_type == \App\Models\Quote::FIXED)
                                                                <span
                                                                    class="euroCurrency">{{ isset($quote->discount) ? getCurrencyAmount($quote->discount, true) : __('messages.common.n/a') }}</span>
                                                            @else
                                                                {{ $quote->discount }}<span
                                                                    style="font-family: DejaVu Sans">&#37;</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="total-amount"
                                                style="background-color: {{ $invoice_template_color }}">
                                                <tr>
                                                    <td class="text-nowrap p-10px">
                                                        <strong>{{ __('messages.quote.total') . ':' }}</strong>
                                                    </td>
                                                    <td class="text-nowrap text-end p-10px">
                                                        <strong>{{ getCurrencyAmount($quote->final_amount, true) }}</strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="mt-5 pt-5">
                            <div class="mb-5 pt-10">
                                <h6 class="font-gray-900 mb5">
                                    <b>{{ __('messages.client.notes') . ':' }}</b>
                                </h6>
                                <p class="font-gray-600">
                                    {!! nl2br($quote->note ?? __('messages.common.n/a')) !!}
                                </p>
                            </div>
                            <div class="w-75">
                                <h6 class="font-gray-900 mb5">
                                    <b>{{ __('messages.invoice.terms') . ':' }}</b>
                                </h6>
                                <p class="font-gray-600 mb-0">
                                    {!! nl2br($quote->term ?? __('messages.common.n/a')) !!}
                                </p>
                            </div>
                            <div class="w-25 text-end"
                                style="position: relative; top:-50px;
                                        margin-left:auto;">
                                <h6 class="mb-0" style="color:{{ $invoice_template_color }}">
                                    <b>{{ __('messages.setting.regards') }}:</b>
                                </h6>
                                <p class="mb-0">{{ html_entity_decode($setting['app_name']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
