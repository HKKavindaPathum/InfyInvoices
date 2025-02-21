<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/media/logos/favicon.ico') }}" type="image/png">
    <title>{{ __('messages.quote.quote_pdf') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/invoice-pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }

        @if (getCurrencySymbol() == '€')
            .euroCurrency {
                font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
            }
        @endif
    </style>
</head>

<body style="padding: 30px 25px !important;">
    @php $styleCss = 'style'; @endphp
    <div>
        <div>
            <div class="logo ml-4"><img width="100px" src="{{ getLogoUrl() }}" alt="logo-image"></div>
        </div>
        <div class="card-body">
            <table class="table table-bordered w-100">
                <thead class="bg-light">
                    <tr>
                        <th class="py-1 text-uppercase" style="width:33.33% !important;">
                            {{ __('messages.common.from') }}</th>
                        <th class="py-1 text-uppercase" style="width:33.33% !important;">{{ __('messages.common.to') }}
                        </th>
                        <th class="py-1 text-uppercase" style="width:33.33% !important;">
                            {{ __('messages.quote.quote_name') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-1">
                            <b>{{ __('messages.common.name') . ':' }}&nbsp;</b>{!! $setting['company_name'] !!}<br>
                            <b>{{ __('messages.common.address') . ':' }}&nbsp;</b>{!! $setting['company_address'] !!}<br>
                            <b>{{ __('messages.user.phone') . ':' }}&nbsp;</b>{{ $setting['company_phone'] }}<br>
                            @if (!empty($setting['gst_no']))
                                <b>{{ getVatNoLabel() . ':' }}&nbsp;</b>{{ $setting['gst_no'] }}
                            @endif
                        </td>
                        <td class="py-1" style=" overflow:hidden; word-wrap: break-word; word-break: break-all;">
                            <b>{{ __('messages.common.name') . ':' }}&nbsp;</b>{{ $client->user->full_name }}<br>
                            <b>{{ __('messages.common.email') . ':' }}</b>
                            <span style="width:200px; word-break: break-word !important;">
                                {{ $client->user->email }}</span><br>
                            <b>{{ __('messages.common.address') . ':' }}&nbsp;</b>{{ $client->address }}
                            @if (!empty($client->vat_no))
                                <br><b>{{ getVatNoLabel() . ':' }}&nbsp;</b>{{ $client->vat_no }}
                            @endif
                        </td>
                        <td class="py-1">
                            <div class="text-nowrap"><b>{{ __('messages.quote.quote_id') . ':' }}</b>
                                &nbsp;#{{ $quote->quote_id }}</div>
                            <div class="text-nowrap">
                                <b>{{ __('messages.quote.quote_date') . ':' }}</b>
                                &nbsp;#{{ \Carbon\Carbon::parse($quote->quote_date)->translatedFormat(currentDateFormat()) }}
                            </div>
                            <div class="text-nowrap">
                                <b>{{ __('messages.quote.due_date') . ':' }}</b>
                                &nbsp;#{{ \Carbon\Carbon::parse($quote->due_date)->translatedFormat(currentDateFormat()) }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="table-responsive-sm pt-3">
                <table class="table table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-1" style="width:5%;">#</th>
                            <th class="py-1 text-uppercase">{{ __('messages.product.product') }}</th>
                            <th class="py-1 text-uppercase text-center" style="width:10%;">
                                {{ __('messages.invoice.qty') }}</th>
                            <th class="py-1 text-uppercase text-nowrap text-center" style="width:18%;">
                                {{ __('messages.product.unit_price') }}
                            </th>
                            <th class="py-1 text-uppercase  number-align text-nowrap" style="width:18%;">
                                {{ __('messages.invoice.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($quote) && !empty($quote))
                            @foreach ($quote->quoteItems as $key => $quoteItems)
                                <tr>
                                    <td class="py-1">{{ $key + 1 }}</td>
                                    <td class="py-1">
                                        {{ isset($quoteItems->product->name) ? $quoteItems->product->name : $quoteItems->product_name ?? __('messages.common.n/a') }}
                                        @if (!empty($quoteItems->product->description) && $setting['show_product_description'] == 1)
                                            <br><span
                                                style="font-size: 12px; word-break: break-all">{{ $quoteItems->product->description }}</span>
                                        @endif
                                    </td>
                                    <td class="py-1 text-center text-nowrap">{{ $quoteItems->quantity }}</td>
                                    <td class="py-1 text-center text-nowrap euroCurrency">
                                        {{ isset($quoteItems->price) ? getCurrencyAmount($quoteItems->price, true) : __('messages.common.n/a') }}
                                    </td>
                                    <td class="py-1 number-align text-nowrap euroCurrency">
                                        {{ isset($quoteItems->total) ? getCurrencyAmount($quoteItems->total, true) : __('messages.common.n/a') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <table class="mb-4 w-100">
                <tr>
                    <td class="w-70">
                    </td>
                    <td class="w-30">
                        <table class="w-100">
                            <tbody class="text-end">
                                <tr>
                                    <td>
                                        <strong>{{ __('messages.invoice.sub_total') . ':' }}</strong>
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="euroCurrency">{{ getCurrencyAmount($quote->amount, true) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ __('messages.invoice.discount') . ':' }}</strong>
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($quote->discount == 0)
                                            <span>{{ __('messages.common.n/a') }}</span>
                                        @else
                                            @if (isset($quote) && $quote->discount_type == \App\Models\Quote::FIXED)
                                                <span
                                                    class="euroCurrency">{{ isset($quote->discount) ? getCurrencyAmount($quote->discount, true) : __('messages.common.n/a') }}</span>
                                            @else
                                                {{ $quote->discount }}<span
                                                    {{ $styleCss }}="font-family: DejaVu Sans">&#37;</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.quote.total') . ':' }}</td>
                                    <td class="text-nowrap">
                                        <span
                                            class="euroCurrency">{{ getCurrencyAmount($quote->final_amount, true) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <div class="alert alert-primary text-muted" role="alert">
                <b class="text-dark">{{ __('messages.client.notes') . ':' }}</b> {!! nl2br($quote->note ?? __('messages.common.n/a')) !!}
            </div>
            <div class="alert alert-light text-muted" role="alert">
                <b class="text-dark">{{ __('messages.invoice.terms') . ':' }}</b> {!! nl2br($quote->term ?? __('messages.common.n/a')) !!}
            </div>
        </div>
    </div>
</body>

</html>
