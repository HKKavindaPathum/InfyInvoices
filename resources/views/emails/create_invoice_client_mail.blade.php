@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getLogoUrl()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot

    {{-- Body --}}
    <div>
        <h2>{{ __('messages.dear') }} {{ $clientName }}, <b></b></h2><br>
        <p>{{ __('messages.i_hope_you_are_well') }}.</p>
        <p>{{ __('messages.please_see_attached_the_invoice') }} {{ ' #' . $invoiceNumber }}.
            {{ __('messages.the_invoice_is_due_by') }}
            {{ $dueDate }}.</p>
        <p>{{ __('messages.please_do_not_hesitate_to_get_in_touch') }}.</p>
        <p>{{ __('messages.also_you_can_see_the_attachment_invoice_PDF') }}.</p><br>
        <div style="display: flex;justify-content: center">
            <a href="{{ route('client.invoices.show', ['invoice' => $id]) }}"
                style="padding: 7px 15px;text-decoration: none;font-size: 14px;background-color: #df4645;font-weight: 500;border: none;border-radius: 8px;color: white;margin-right: 5px;">
                {{ __('messages.view_invoice') }}
            </a>
            <a href="{{ route('invoice-show-url', ['invoiceId' => $invoiceId]) }}"
                style="padding: 7px 15px;text-decoration: none;font-size: 14px;background-color: #df4645;font-weight: 500;border: none;border-radius: 8px;color: white; margin-left: 5px;">
                {{ __('messages.public_view') }}
            </a>
        </div>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
