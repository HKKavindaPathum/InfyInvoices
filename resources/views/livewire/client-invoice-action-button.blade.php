<div class="d-flex justify-content-center">
    @if ($row->status_label != 'Paid')
        <a class="btn px-0 text-info fs-3 py-2" data-bs-toggle="tooltip" title="{{ __('messages.invoice.make_payment') }}"
            href="{{ route('clients.payments.show', $row->id) }}" data-id="{{ $row->id }}" ><i
                class="fa-solid fa-money-bill"></i></a>
    @endif
    <div class="dropup position-static mx-3" wire:key="{{ $row->id }}">
        <button wire:key="client-invoice-{{ $row->id }}" type="button" title="Action"
            class="dropdown-toggle hide-arrow btn px-0 text-primary fs-3 pe-0" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>
        <ul class="dropdown-menu min-w-170px" aria-labelledby="dropdownMenuButton1">
            <li>
                <a class="dropdown-item" href="{{ route('clients.invoices.pdf', $row->id) }}" data-bs-toggle="tooltip"
                    title="{{ __('messages.invoice.download') }}" target="_blank">{{ __('messages.invoice.download') }}
                </a>
            </li>
            @if ($row->status_label != 'Paid')
                <li>
                    <a href="javascript:void(0)" data-id="{{ $row->id }}"
                        class="dropdown-item text-hover-primary me-1 open-send-whatapp-invoice" data-bs-toggle="tooltip"
                        title="{{ __('messages.invoice.send_whatsapp') }}">
                        {{ __('messages.invoice.send_whatsapp') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
