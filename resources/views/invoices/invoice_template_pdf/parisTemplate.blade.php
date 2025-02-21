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
    <div class="preview-main client-preview paris-template">
        <div class="d" id="boxes">
            <div class="d-inner bg-img">
                <div class="position-relative" style="padding:0 1.5rem;">
                    <div class="bg-img" style="position:absolute; left:0; top:-40px;  min-width:220px;">
                        <img src="{{ asset('images/paris-bg-img.png') }}" class="w-100" alt="paris-bg-img" />
                    </div>
                    <div class="px-3" style="margin-top:-40px; z-index:2;">
                        <table class="w-100">
                            <tr>
                                <td padding-right:8px;">
                                    <div>
                                        <img src="{{ getLogoUrl() }}" class="img-logo" alt="logo">
                                    </div>
                                </td>
                                <td class="heading-text" style="vertical-align:bottom; padding:1.5rem 0;">
                                    <div class="text-end">
                                        <h1 class="m-0" style="color:{{ $invoice_template_color }}">
                                            {{ __('messages.common.invoice') }}</h1>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div>
                            <table class="w-100 mt-2">
                                <tr>
                                    <td class="text-end">
                                        <p class="mb-1 fw-6"><strong
                                                class="font-gray-900">{{ __('messages.invoice.invoice_id') . ':' }}&nbsp;
                                            </strong>
                                            <span class="font-gray-600">#{{ $invoice->invoice_id }}</span>
                                        </p>
                                        <p class="mb-1 fw-6"><strong
                                                class="font-gray-900">{{ __('messages.invoice.invoice_date') . ':' }}&nbsp;
                                            </strong>
                                            <span
                                                class="font-gray-600">{{ \Carbon\Carbon::parse($invoice->invoice_date)->translatedFormat(currentDateFormat()) }}</span>
                                        </p>
                                        <p class="mb-1 fw-6"><strong
                                                class="font-gray-900">{{ __('messages.invoice.due_date') . ':' }}&nbsp;
                                            </strong>
                                            <span
                                                class="font-gray-600">{{ \Carbon\Carbon::parse($invoice->due_date)->translatedFormat(currentDateFormat()) }}</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div class="overflow-auto">
                                <table class="mt-4 w-100">
                                    <tbody>
                                        <tr style="vertical-align:top;">
                                            <td width="40%" class="pe-3">
                                                <p class="mb-2" style="color:{{ $invoice_template_color }}">
                                                    <strong>{{ __('messages.common.from') . ':' }}</strong>
                                                </p>
                                                <p class="mb-1 font-black-900 fw-bold" style="white-space:nowrap;">
                                                    <strong>{{ __('messages.common.name') . ':' }}&nbsp;</strong>{!! $setting['company_name'] !!}
                                                </p>
                                                <p class=" mb-1 font-black-900" style="max-width:220px;">
                                                    <strong>{{ __('messages.common.address') . ':' }}</b>&nbsp;</strong>
                                                    {!! $setting['company_address'] !!}
                                                </p>
                                                @if (isset($setting['show_additional_address_in_invoice']) && $setting['show_additional_address_in_invoice'] == 1)
                                                    <p class="mb-1 font-black-900">
                                                        {{ $setting['zipcode'] . ', ' . $setting['city'] . ', ' . $setting['state'] . ', ' . $setting['country'] }}
                                                    </p>
                                                @endif
                                                <p class="mb-1 font-black-900" style="white-space:nowrap;">
                                                    <strong>{{ __('messages.user.phone') . ':' }}
                                                    </strong>{{ $setting['company_phone'] }}
                                                </p>
                                                @if (isset($setting['show_additional_address_in_invoice']) && $setting['show_additional_address_in_invoice'] == 1)
                                                    <p class="mb-1 font-black-900" style="white-space:nowrap;">
                                                        <strong>{{ __('messages.invoice.fax_no') . ':' }}
                                                        </strong>{{ $setting['fax_no'] }}
                                                    </p>
                                                @endif
                                                    @if (!empty($setting['gst_no']))
                                                    <p class="mb-1 font-black-900" style="white-space:nowrap;">
                                                        <strong>{{ getVatNoLabel() . ':' }}
                                                        </strong>{{ $setting['gst_no'] }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td width="30%" class="pe-3">
                                                <p class="mb-2"
                                                    style="white-space:nowrap;color:{{ $invoice_template_color }}">
                                                    <strong>{{ __('messages.common.to') . ':' }}</strong>
                                                </p>
                                                <p class="mb-1 font-black-900 fw-bold" style="white-space:nowrap;">
                                                    <strong>{{ __('messages.common.name') . ':' }}&nbsp;</strong>{{ $client->user->full_name }}
                                                </p>
                                                <p class="mb-1 font-black-900 fw-bold" style="white-space:nowrap;">
                                                    <strong>{{ __('messages.common.email') . ':' }}&nbsp;</strong>{{ $client->user->email }}
                                                </p>
                                                <p class="mb-1 font-black-900 fw-bold">
                                                    <strong>{{ __('messages.common.address') . ':' }}&nbsp;</strong>{{ $client->address }}
                                                </p>
                                                @if (!empty($client->vat_no))
                                                    <p class="mb-1 font-black-900 fw-bold" style="white-space:nowrap;">
                                                        <strong>{{ getVatNoLabel() . ':' }}&nbsp;</strong>{{ $client->vat_no }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td width="30%" class="text-center">
                                                <p class="mb-2" style="color:{{ $invoice_template_color }}">
                                                    <strong>{{ __('messages.common.scan_to_pay') . ':' }}</strong>
                                                </p>
                                                <div>
                                                    @if (!empty($invoice->paymentQrCode) & !empty($invoice->paymentQrCode->qr_image))
                                                        <img src="{{ $invoice->paymentQrCode->qr_image }}"
                                                            height="110" width="110" alt="qr-code-image">
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="overflow-auto w-100 mt-4">
                                <table class="invoice-table w-100">
                                    <thead style="background-color: {{ $invoice_template_color }}">
                                        <tr>
                                            <th class="p-10px fs-5"><b>#</b></th>
                                            <th class="p-10px fs-5 in-w-2"><b>{{ __('messages.product.product') }}</b>
                                            </th>
                                            <th class="p-10px fs-5 text-center"><b>{{ __('messages.invoice.qty') }}</b>
                                            </th>
                                            <th class="p-10px fs-5 text-center text-nowrap">
                                                <b>{{ __('messages.product.unit_price') }}</b>
                                            </th>
                                            <th class="p-10px fs-5 text-center text-nowrap">
                                                <b>{{ __('messages.invoice.tax') . '(in %)' }}</b>
                                            </th>
                                            <th class="p-10px fs-5 text-end text-nowrap">
                                                <b>{{ __('messages.invoice.amount') }}</b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($invoice))
                                            @foreach ($invoice->invoiceItems as $key => $invoiceItems)
                                                <tr>
                                                    <td class="p-10px"><span><b>{{ $key + 1 }}</b></span></td>
                                                    <td class="p-10px font-gray-600 in-w-2">
                                                        <p class="fw-6 mb-0 font-black-900">
                                                            {{ isset($invoiceItems->product->name) ? $invoiceItems->product->name : $invoiceItems->product_name ?? __('messages.common.n/a') }}
                                                        </p>
                                                        @if (
                                                            !empty($invoiceItems->product->description) &&
                                                                (isset($setting['show_product_description']) && $setting['show_product_description'] == 1))
                                                            <span
                                                                style="font-size: 12px; word-break: break-all !important">{{ $invoiceItems->product->description }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="p-10px font-gray-600 text-center">
                                                        {{ number_format($invoiceItems->quantity, 2) }}</td>
                                                    <td class="p-10px font-gray-600 text-center tex-nowrap">
                                                        {{ isset($invoiceItems->price) ? getInvoiceCurrencyAmount($invoiceItems->price, $invoice->currency_id, true) : __('messages.common.n/a') }}
                                                    </td>
                                                    <td class="p-10px font-gray-600 text-center">
                                                        @foreach ($invoiceItems->invoiceItemTax as $keys => $tax)
                                                            {{ $tax->tax ?? '--' }}
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="p-10px font-gray-600 text-end text-nowrap">
                                                        {{ isset($invoiceItems->total) ? getInvoiceCurrencyAmount($invoiceItems->total, $invoice->currency_id, true) : __('messages.common.n/a') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <table style="width:250px; margin-left:auto;">
                                    <tbody style="border-bottom:1px solid #cecece">
                                        <tr>
                                            <td class="pb-2" style="color:{{ $invoice_template_color }}">
                                                <strong>{{ __('messages.invoice.sub_total') . ':' }}</strong>
                                            </td>
                                            <td class="text-end font-gray-600 pb-2 fw-bold">
                                                {{ getInvoiceCurrencyAmount($invoice->amount, $invoice->currency_id, true) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pb-2" style="color:{{ $invoice_template_color }}">
                                                <strong>{{ __('messages.invoice.discount') . ':' }}</strong>
                                            </td>
                                            <td class="text-end font-gray-600 pb-2 fw-bold">
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
                                                    ($itemTaxesAmount * $invoice->invoiceTaxes->sum('value')) / 100;
                                                $totalTaxes = array_sum($totalTax) + $invoiceTaxesAmount;
                                            @endphp
                                            <td class="pb-2" style="color:{{ $invoice_template_color }}">
                                                <strong>{{ __('messages.invoice.tax') . ':' }}</strong>
                                            </td>
                                            <td class="text-end font-gray-600 pb-2 fw-bold">
                                                {!! numberFormat($totalTaxes) != 0
                                                    ? '<span class="euroCurrency">' . getInvoiceCurrencyAmount($totalTaxes, $invoice->currency_id, true) . '</span>'
                                                    : __('messages.common.n/a') !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="total-amount">
                                        <tr>
                                            <td class="py-2" style="color:{{ $invoice_template_color }}">
                                                <strong>{{ __('messages.invoice.total') . ':' }}</strong>
                                            </td>
                                            <td class="text-end py-2">
                                                {{ getInvoiceCurrencyAmount($invoice->final_amount, $invoice->currency_id, true) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-5">
                                @if (!empty($invoice->note))
                                <div class="mb-5 mt-sm-0 mt-2">
                                    <h6 class="font-gray-900 mb5">
                                        <b>{{ __('messages.client.notes') . ':' }}</b>
                                    </h6>
                                    <p class="font-gray-600">
                                        {!! nl2br($invoice->note ?? __('messages.common.not_available')) !!}
                                    </p>
                                </div>
                                @endif
                                <table class="w-100">
                                    <tr>
                                        @if (!empty($invoice->term))
                                        <td class="w-50">
                                            <div>
                                                <h6 class="font-gray-900 mb5">
                                                    <b>{{ __('messages.invoice.terms') . ':' }}</b>
                                                </h6>
                                                <p class="font-gray-600 mb-0">
                                                    {!! nl2br($invoice->term ?? __('messages.common.not_available')) !!}
                                                </p>
                                            </div>
                                        </td>
                                        @endif
                                        <td style="vertical-align:bottom; width:25%;" class="text-end">
                                            <div>
                                                <h6 class="fw-6 mb5 pt-3">
                                                    {{ __('messages.setting.regards') . ':' }}
                                                </h6>
                                                <p class="fw-6 mb-0" style="color:{{ $invoice_template_color }}">
                                                    {{ html_entity_decode($setting['app_name']) }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
