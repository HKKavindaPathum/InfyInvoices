<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/media/logos/favicon.ico') }}" type="image/png">
    <title>{{ __('messages.invoice.invoice_pdf') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/invoice-pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }

        @page {
            margin-top: 40px !important;
        }

        @if (getInvoiceCurrencyIcon($invoice->currency_id) == '€')
            .euroCurrency {
                font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
            }
        @endif
    </style>
</head>

<body style="padding: 0rem;">
    <div class="preview-main client-preview istanbul-template">
        <div class="d" id="boxes">
            <div class="d-inner">
                <div class="position-relative" style="padding:0 1.5rem;">
                    <div class="bg-img" style="position:absolute; left:0; top:-40px;">
                        <img src="{{ asset('images/istanbul-bg-img.png') }}" alt="istanbul-bg-img" />
                    </div>
                    <div class="invoice-header px-3" style="z-index:2; margin-top:-25px;">
                        <table class="overflow-hidden w-100">
                            <tr>
                                <td class="heading-text pb-10 pe-10 w-30">
                                    <div class="position-relative z-10">
                                        <h1 class="m-0 text-white"
                                            style="font-size: 32px; font-weight:700; letter-spacing:2px">
                                            {{ __('messages.common.invoice') }}
                                        </h1>
                                    </div>
                                </td>
                                <td class="text-end" style="padding-top: 1.0rem;">
                                    <div>
                                        <img src="{{ getLogoUrl() }}" class="img-logo" alt="logo">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <div class="px-3">
                            <div class="my-4 text-end ml-auto">
                                <p class="mb-1 fs-6 fw-6">
                                    <span>{{ __('messages.invoice.invoice_id') . ':' }}</span>
                                    <span class="font-gray-600">
                                        #{{ $invoice->invoice_id }}
                                    </span>
                                </p>
                                <p class="mb-1 fs-6 fw-6">
                                    <span>{{ __('messages.invoice.invoice_date') . ':' }}</span>
                                    <span class="font-gray-600">
                                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->translatedFormat(currentDateFormat()) }}
                                    </span>
                                </p>
                                <p class="fs-6 fw-6">
                                    <span>{{ __('messages.invoice.due_date') . ':' }}</span>
                                    <span
                                        class="font-gray-600">{{ \Carbon\Carbon::parse($invoice->due_date)->translatedFormat(currentDateFormat()) }}</span>
                                </p>
                            </div>
                            <table class="mb-10 mb-3 w-100">
                                <tbody>
                                    <tr style="vertical-align:top;">
                                        <td width="33%" class="pe-15">
                                            <p class="fs-6 mb-2 font-gray-900">
                                                <b>{{ __('messages.common.from') . ':' }}</b>
                                            </p>
                                            <p class=" mb-1 font-color-gray fw-bold fs-6">
                                                {{ __('messages.common.name') . ':' }}&nbsp; <span
                                                    class="font-gray-900">{!! $setting['company_name'] !!}</span></p>
                                            <p class=" mb-1  fs-6">
                                                <span
                                                    class="font-gray-600">{{ __('messages.common.address') . ':' }}</span>
                                                {!! $setting['company_address'] !!}
                                            </p>
                                            @if (isset($setting['show_additional_address_in_invoice']) && $setting['show_additional_address_in_invoice'] == 1)
                                                <p class=" m-0  fs-6">
                                                    {{ $setting['zipcode'] . ', ' . $setting['city'] . ', ' . $setting['state'] . ', ' . $setting['country'] }}
                                                </p>
                                            @endif
                                            <p class=" mb-1 fs-6">
                                                <span
                                                    class="font-gray-600">{{ __('messages.user.phone') . ':' }}</span>
                                                {{ $setting['company_phone'] }}
                                            </p>
                                            @if (isset($setting['show_additional_address_in_invoice']) && $setting['show_additional_address_in_invoice'] == 1)
                                                <p class=" m-0 fs-6">
                                                    <span
                                                        class="font-gray-600">{{ __('messages.invoice.fax_no') . ':' }}</span>
                                                    {{ $setting['fax_no'] }}
                                                <p>
                                            @endif
                                            @if (!empty($setting['gst_no']))
                                                <p class=" mb-1  font-color-gray fs-6">
                                                    {{ getVatNoLabel() . ':' }}
                                                    <span class="font-gray-900">{{ $setting['gst_no'] }} </span>
                                                </p>
                                            @endif
                                        </td>
                                        <td width="35%" class="ps-5rem">
                                            <p class="fs-6 mb-2 font-gray-900">
                                                <b>{{ __('messages.common.to') . ':' }}</b>
                                            </p>
                                            <p class="mb-1 fs-6">
                                                <span
                                                    class="font-gray-600">{{ __('messages.common.name') . ':' }}</span>
                                                {{ $client->user->full_name }}
                                            </p>
                                            <p class="mb-1 fs-6">
                                                <span
                                                    class="font-gray-600">{{ __('messages.common.email') . ':' }}</span>
                                                {{ $client->user->email }}
                                            </p>
                                            <p class="mb-1 fs-6">
                                                <span
                                                    class="font-gray-600">{{ __('messages.common.address') . ':' }}</span>
                                                {{ $client->address }}
                                            </p>
                                            @if (!empty($client->vat_no))
                                                <p class="mb-1 fs-6">
                                                    <span class="font-gray-600">{{ getVatNoLabel() . ':' }}</span>
                                                    {{ $client->vat_no }}
                                                </p>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-3">
                            <table class="invoice-table w-100">
                                <thead style="background-color: {{ $invoice_template_color }};">
                                    <tr>
                                        <th class="p-2 fs-5" style="width:5% !important;">#</th>
                                        <th class="p-2 fs-5 in-w-2">
                                            {{ __('messages.product.product') }}</th>
                                        <th class="p-2 fs-5 text-center" style="width:9% !important;">
                                            {{ __('messages.invoice.qty') }}</th>
                                        <th class="p-2 fs-5 text-center text-nowrap" style="width:15% !important;">
                                            {{ __('messages.product.unit_price') }}</th>
                                        <th class="p-2 fs-5 text-center text-nowrap" style="width:13% !important;">
                                            {{ __('messages.invoice.tax') . '(in %)' }}</th>
                                        <th class="p-2 fs-5 text-end text-nowrap" style="width:14% !important;">
                                            {{ __('messages.invoice.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($invoice))
                                        @foreach ($invoice->invoiceItems as $key => $invoiceItems)
                                            <tr>
                                                <td class="p-2" style="width:5%; vertical-align: top;">
                                                    <span>{{ $key + 1 }}</span>
                                                </td>
                                                <td class="p-2 in-w-2" style="vertical-align: top;">
                                                    <p class="fw-bold mb-0">
                                                        {{ isset($invoiceItems->product->name) ? $invoiceItems->product->name : $invoiceItems->product_name ?? __('messages.common.n/a') }}
                                                    </p>
                                                    @if (
                                                        !empty($invoiceItems->product->description) &&
                                                            (isset($setting['show_product_description']) && $setting['show_product_description'] == 1))
                                                    @endif
                                                    @if (
                                                        !empty($invoiceItems->product->description) &&
                                                            (isset($setting['show_product_description']) && $setting['show_product_description'] == 1))
                                                        <span
                                                            style="font-size: 12px; word-break: break-all !important">{{ $invoiceItems->product->description }}</span>
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center text-nowrap font-gray-600"
                                                    style="width:9% !important; vertical-align: top;">
                                                    {{ number_format($invoiceItems->quantity, 2) }}
                                                </td>
                                                <td class="p-2 text-center text-nowrap font-gray-600"
                                                    style="width:15% !important; vertical-align: top;">
                                                    {{ isset($invoiceItems->price) ? getInvoiceCurrencyAmount($invoiceItems->price, $invoice->currency_id, true) : __('messages.common.n/a') }}
                                                </td>
                                                <td class="p-2 text-center text-nowrap font-gray-600"
                                                    style="width:13% !important; vertical-align: top;">
                                                    @foreach ($invoiceItems->invoiceItemTax as $keys => $tax)
                                                        {{ $tax->tax ?? '--' }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="p-2 text-end text-nowrap font-gray-600"
                                                    style="width:14% !important; vertical-align: top;">
                                                    {{ isset($invoiceItems->total) ? getInvoiceCurrencyAmount($invoiceItems->total, $invoice->currency_id, true) : __('messages.common.n/a') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="my-10 mt-5">
                                <table class="w-100">
                                    <tr>
                                        <td class="w-50">
                                            @if (!empty($invoice->paymentQrCode))
                                                <p class="m-0 fs-6"
                                                    style="color:
                                        {{ $invoice_template_color }}">
                                                    <b>{{ __('messages.payment_qr_codes.payment_qr_code') }}</b>
                                                </p>
                                                <img class="mt-2 ml-3" src="{{ $invoice->paymentQrCode->qr_image }}"
                                                    height="110" width="110" alt="qr-code-image">
                                            @endif
                                        </td>
                                        <td class="w-50">
                                            <table class="w-100">
                                                <tbody>
                                                    <tr>
                                                        <td class="py-1 px-2 font-orange text-nowrap"
                                                            style="color:
                                        {{ $invoice_template_color }}">
                                                            <strong>{{ __('messages.invoice.sub_total') . ':' }}</strong>
                                                        </td>
                                                        <td
                                                            class="text-end font-gray-600 py-1 px-2 fw-bold text-nowrap">
                                                            {{ getInvoiceCurrencyAmount($invoice->amount, $invoice->currency_id, true) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1 px-2 font-orange text-nowrap"
                                                            style="color:
                                        {{ $invoice_template_color }}">
                                                            <strong>{{ __('messages.invoice.discount') . ':' }}</strong>
                                                        </td>
                                                        <td
                                                            class="text-end font-gray-600 py-1 px-2 fw-bold text-nowrap">
                                                            @if ($invoice->discount == 0)
                                                                <span>{{ __('messages.common.n/a') }}</span>
                                                            @else
                                                                @if (isset($invoice) && $invoice->discount_type == \App\Models\Invoice::FIXED)
                                                                    <span
                                                                        class="euroCurrency">{{ isset($invoice->discount) ? getInvoiceCurrencyAmount($invoice->discount, $invoice->currency_id, true) : __('messages.common.n/a') }}</span>
                                                                @else
                                                                    {{ $invoice->discount }}<span
                                                                        style="font-family: DejaVu Sans">&#37;</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        @php
                                                            $itemTaxesAmount = $invoice->amount + array_sum($totalTax);
                                                            $invoiceTaxesAmount =
                                                                ($itemTaxesAmount *
                                                                    $invoice->invoiceTaxes->sum('value')) /
                                                                100;
                                                            $totalTaxes = array_sum($totalTax) + $invoiceTaxesAmount;
                                                        @endphp
                                                        <td class="py-1 px-2 font-orange text-nowrap"
                                                            style="color:
                                        {{ $invoice_template_color }}">
                                                            <strong>{{ __('messages.invoice.tax') . ':' }}</strong>
                                                        </td>
                                                        <td
                                                            class="text-end font-gray-600 py-1 px-2 fw-bold text-nowrap">
                                                            {!! numberFormat($totalTaxes) != 0
                                                                ? '<span class="euroCurrency">' . getInvoiceCurrencyAmount($totalTaxes, $invoice->currency_id, true) . '</span>'
                                                                : __('messages.common.n/a') !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1 px-2 font-orange text-nowrap"
                                                            style="color:
                                        {{ $invoice_template_color }}">
                                                            <strong>{{ __('messages.invoice.total') . ':' }}</strong>
                                                        </td>
                                                        <td
                                                            class="text-end font-gray-600 py-1 px-2 fw-bold text-nowrap">
                                                            {{ getInvoiceCurrencyAmount($invoice->final_amount, $invoice->currency_id, true) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="border-top-gray">
                                                    <tr>
                                                        <td class="p-2 font-orange text-nowrap"
                                                            style="color:
                                        {{ $invoice_template_color }}">
                                                            <strong>
                                                                {{ __('messages.admin_dashboard.total_due') . ':' }}</strong>
                                                        </td>
                                                        <td class="text-end font-gray-900 p-2 text-nowrap">
                                                            {{ getInvoiceCurrencyAmount(getInvoiceDueAmount($invoice->id), $invoice->currency_id, true) }}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-5">
                                @if (!empty($invoice->note))
                                <div class="mb-5">
                                    <h6 class="fw-6 mb5">
                                        {{ __('messages.client.notes') . ':' }}</h6>
                                    <p class="font-gray-600">{!! nl2br($invoice->note ?? __('messages.common.not_available')) !!}
                                    </p>
                                </div>
                                @endif
                                @if (!empty($invoice->term))
                                <div class="w-75 mb-8">
                                    <h6 class="fw-6 mb5">
                                        {{ __('messages.invoice.terms') . ':' }}
                                    </h6>
                                    <p class="font-gray-600">
                                        {!! nl2br($invoice->term ?? __('messages.common.not_available')) !!} </p>
                                </div>
                                @endif
                                <div class="w-25 text-end" style="position:relative; top:-50px; margin-left:auto;">
                                    <h6 class="fw-6 mb-0"
                                        style="color:
                                            {{ $invoice_template_color }}">
                                        {{ __('messages.common.regards') . ':' }}
                                    </h6>
                                    <p class="fs-6 font-gray-600">
                                        {{ html_entity_decode($setting['app_name']) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
