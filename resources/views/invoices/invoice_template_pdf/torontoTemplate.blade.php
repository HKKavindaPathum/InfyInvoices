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

        @if (getInvoiceCurrencyIcon($invoice->currency_id) == '€')
            .euroCurrency {
                font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
            }
        @endif
    </style>
</head>

<body style="padding: 0rem 0rem !important;">
    @php $styleCss = 'style'; @endphp
    <div class="mb-8 w-100 position-relative" style="background-color:#F9F9F9; padding: 3rem 2rem ;">
        <table class="w-100">
            <tr>
                <td style="vertical-align:top; width: 45% !important;">
                    <div>
                        <img width="100px" src="{{ getLogoUrl() }}" alt="">
                    </div>
                    @if (!empty($invoice->paymentQrCode))
                        <div style="margin-top:67%;">
                            <img src="{{ $invoice->paymentQrCode->qr_image }}" height="100" width="100"
                                alt="qr-code-image">
                        </div>
                    @endif
                </td>
                <td style="vertical-align:top; width: 55% !important; padding: 0rem 2rem 0rem 0rem ;">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th class="f-b" style="width: 50% !important;">
                                    <h4 {{ $styleCss }}="color: {{ $invoice_template_color }}">
                                        <strong>{{ __('messages.common.invoice') }}</strong>
                                    </h4>
                                </th>
                                <th class="f-b" style="width: 50% !important;">
                                    <h4 {{ $styleCss }}="color: {{ $invoice_template_color }}">
                                        #{{ $invoice->invoice_id }}</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 50% !important;">
                                    <p class="m-0 fw-bold fs-6"><b>{{ __('messages.invoice.invoice_date') }}</b></p>
                                    <p>{{ \Carbon\Carbon::parse($invoice->invoice_date)->translatedFormat(currentDateFormat()) }}
                                    </p>
                                </td>
                                <td style="width: 50% !important;">
                                    <p class="m-0 fw-bold fs-6"><b>{{ __('messages.invoice.due_date') }}</b></p>
                                    <p>{{ \Carbon\Carbon::parse($invoice->due_date)->translatedFormat(currentDateFormat()) }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="pr-5"
                                    style="vertical-align:top !important; width:50% !important; overflow:hidden; word-wrap: break-word; word-break: break-all;">
                                    <p class="m-0 fw-bold fs-6"><b>{{ __('messages.common.from') }}</b></p>
                                    <span>{{ $setting['company_name'] }}</span><br>
                                    <span>
                                        {!! $setting['company_address'] !!}<br>
                                        @if (isset($setting['show_additional_address_in_invoice']) && $setting['show_additional_address_in_invoice'] == 1)
                                            <div>
                                                {{ $setting['zipcode'] . ', ' . $setting['city'] . ', ' . $setting['state'] . ', ' . $setting['country'] }}
                                            </div>
                                        @endif
                                    </span><br>
                                    <span>{{ $setting['company_phone'] }}</span>
                                    @if (!empty($setting['gst_no']))
                                        <span>{{ $setting['gst_no'] }} </span>
                                    @endif
                                </td>
                                <td
                                    style="vertical-align:top !important; width:50% !important; overflow:hidden; word-wrap: break-word; word-break: break-all;">
                                    <p class="m-0 fw-bold fs-6"><b>{{ __('messages.common.to') }}</b></p>
                                    <span>{{ $client->user->full_name }}</span><br>
                                    <span>{{ $client->user->email }}</span><br>
                                    <span>{{ $client->address }}</span>
                                    @if (!empty($client->vat_no))
                                        <br><span>{{ $client->vat_no }}</span><br>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="table-responsive-sm p-4">
        <table class="w-100">
            <thead {{ $styleCss }}="border-bottom: 1px solid {{ $invoice_template_color }}">
                <tr>
                    <th class="py-1" {{ $styleCss }}="color: {{ $invoice_template_color }}; width:5%;">#</th>
                    <th class="py-1 in-w-2 text-uppercase" {{ $styleCss }}="color: {{ $invoice_template_color }}">
                        {{ __('messages.product.product') }}</th>
                    <th class="py-1 text-uppercase"
                        {{ $styleCss }}="color: {{ $invoice_template_color }}; width:9%;">
                        {{ __('messages.invoice.qty') }}</th>
                    <th class="py-1 text-center text-uppercase text-nowrap"
                        {{ $styleCss }}="color: {{ $invoice_template_color }}; width:15%;">
                        {{ __('messages.product.unit_price') }}</th>
                    <th class="py-1 text-center text-uppercase text-nowrap"
                        {{ $styleCss }}="color: {{ $invoice_template_color }}; width:14%;">
                        {{ __('messages.invoice.tax') . '(in %)' }}</th>
                    <th class="py-1 text-end text-uppercase text-nowrap"
                        {{ $styleCss }}="color: {{ $invoice_template_color }}; width:14%; text-align: end !important;">
                        {{ __('messages.invoice.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($invoice) && !empty($invoice))
                    @foreach ($invoice->invoiceItems as $key => $invoiceItems)
                        <tr>
                            <td class="py-1"><span>{{ $key + 1 }}</span></td>
                            <td class="py-1 in-w-2">
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
                                        style="font-size: 12px; word-break: break-all">{{ $invoiceItems->product->description }}</span>
                                @endif
                            </td>
                            <td class="py-1">{{ number_format($invoiceItems->quantity, 2) }}</td>
                            <td class="py-1 text-center text-nowrap">
                                {{ isset($invoiceItems->price) ? getInvoiceCurrencyAmount($invoiceItems->price, $invoice->currency_id, true) : __('messages.common.n/a') }}
                            </td>
                            <td class="py-1 text-center text-nowrap">
                                @foreach ($invoiceItems->invoiceItemTax as $keys => $tax)
                                    {{ $tax->tax ?? '--' }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td class="py-1 text-end text-nowrap">
                                {{ isset($invoiceItems->total) ? getInvoiceCurrencyAmount($invoiceItems->total, $invoice->currency_id, true) : __('messages.common.n/a') }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <table class="w-100  pl-3 pr-4">
        <tr>
            <td style="width:49%;"></td>
            <td {{ $styleCss }}="border-top: 1px solid {{ $invoice_template_color }}; width:51%;">
                <table class="w-100">
                    <tbody>
                        <tr>
                            <td class="py-1 text-nowrap">
                                <strong>{{ __('messages.invoice.sub_total') . ':' }}</strong>
                            </td>
                            <td class="py-1 text-nowrap number-align text-nowrap">
                                {{ getInvoiceCurrencyAmount($invoice->amount, $invoice->currency_id, true) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1 text-nowrap">
                                <strong>{{ __('messages.invoice.discount') . ':' }}</strong>
                            </td>
                            <td class="text-nowrap number-align py-1 text-nowrap">
                                @if ($invoice->discount == 0)
                                    <span>{{ __('messages.common.n/a') }}</span>
                                @else
                                    @if (isset($invoice) && $invoice->discount_type == \App\Models\Invoice::FIXED)
                                        <b
                                            class="euroCurrency">{{ isset($invoice->discount) ? getInvoiceCurrencyAmount($invoice->discount, $invoice->currency_id, true) : __('messages.common.n/a') }}</b>
                                    @else
                                        {{ $invoice->discount }}<span
                                            {{ $styleCss }}="font-family: DejaVu Sans">&#37;</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            @php
                                $itemTaxesAmount = $invoice->amount + array_sum($totalTax);
                                $invoiceTaxesAmount = ($itemTaxesAmount * $invoice->invoiceTaxes->sum('value')) / 100;
                                $totalTaxes = array_sum($totalTax) + $invoiceTaxesAmount;
                            @endphp
                            <td class="fw-bold py-1 text-nowrap">
                                <strong>{{ __('messages.invoice.tax') . ':' }}</strong>
                            </td>
                            <td class="text-nowrap number-align py-1">
                                {!! numberFormat($totalTaxes) != 0
                                    ? '<b class="euroCurrency">' . getInvoiceCurrencyAmount($totalTaxes, $invoice->currency_id, true) . '</b>'
                                    : __('messages.common.n/a') !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1 text-nowrap">
                                <strong>{{ __('messages.invoice.total') . ':' }}</strong>
                            </td>
                            <td class="text-nowrap number-align py-1">
                                <b
                                    class="euroCurrency">{{ getInvoiceCurrencyAmount($invoice->final_amount, $invoice->currency_id, true) }}</b>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot {{ $styleCss }}="border-top: 1px solid {{ $invoice_template_color }}">
                        <tr>
                            <td class="pt-2 text-nowrap">
                                <strong>{{ __('messages.admin_dashboard.total_due') . ':' }}</strong>
                            </td>
                            <td class="text-nowrap number-align pt-2">
                                <b
                                    class="euroCurrency">{{ getInvoiceCurrencyAmount(getInvoiceDueAmount($invoice->id), $invoice->currency_id, true) }}</b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
    <div class="p-4 mt-5">
        <div class="notes-terms">
            @if (!empty($invoice->note))
                <p><b>{{ __('messages.client.notes') . ':' }}</b><br><span class="text-color">
                        {!! nl2br($invoice->note ?? __('messages.common.not_available')) !!}</span></p>
            @endif
            @if (!empty($invoice->term))
                <p><b>{{ __('messages.invoice.terms') . ':' }}</b><br>
                    <span class="text-color">
                        {!! nl2br($invoice->term ?? __('messages.common.not_available')) !!}</span>
                </p>
            @endif
        </div>
        <div class="regards">
            <p><b>{{ __('messages.setting.regards') . ':' }}</b><br>
                <b
                    {{ $styleCss }}="color: {{ $invoice_template_color }}">{{ html_entity_decode($setting['app_name']) }}</b>
            </p>
        </div>
    </div>

</body>

</html>
