<div class="dropup position-static" wire:key="{{ $row->id }}">

    <a class="px-2" href="{{ route('invoices.pdf', $row->id) }}" target="_blank"><i
            class="fa-solid fa-download fs-2"></i></a>

    <button wire:key="invoice-{{ $row->id }}" type="button" title="Action"
        class="dropdown-toggle hide-arrow btn px-2 text-primary fs-3 pe-0" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    @php
        $isEdit = $row->status == 2 || $row->status == 3 ? 1 : 0;
        $isPaid = $row->status == 2 || $row->status == 0 ? 1 : 0;
        $isDraft = $row->status == 0 ? 0 : 1;
    @endphp
    <ul class="dropdown-menu min-w-170px" aria-labelledby="dropdownMenuButton1">
        @if ($isEdit != 1)
            <li>
                <a href="{{ route('invoices.edit', $row->id) }}" class="dropdown-item text-hover-primary me-1 edit-btn"
                    data-bs-toggle="tooltip" title="{{ __('messages.common.edit') }}" >
                    {{ __('messages.common.edit') }}
                </a>
            </li>
        @endif
        <li>
            <a href="#" data-id="{{ $row->id }}"
                class="delete-btn dropdown-item me-1 text-hover-primary invoice-delete-btn" data-bs-toggle="tooltip"
                title="{{ __('messages.common.delete') }}">
                {{ __('messages.common.delete') }}
            </a>
        </li>
        @if ($isPaid != 1)
            <li>
                <a href="#" data-id="{{ $row->id }}"
                    class="reminder-btn dropdown-item me-1 text-hover-primary" data-bs-toggle="tooltip"
                    title="{{ __('messages.invoice.payment_reminder_mail') }}">
                    {{ __('messages.common.reminder') }}
                </a>
            </li>
        @endif
        @if ($isDraft)
            <li>
                <a href="javascript:void(0)" data-url="{{ route('invoice-show-url', $row->invoice_id) }}"
                    class="dropdown-item text-hover-primary me-1 edit-btn  invoice-url" data-bs-toggle="tooltip"
                    title="{{ __('messages.invoice.copy_invoice_url') }}"
                    onclick="copyToClipboard($(this).data('url'))">
                    {{ __('messages.invoice.invoice_url') }}
                </a>
            </li>
        @endif
        @if (empty($row->parent_id))
            <li>
                <a href="javascript:void(0)" data-id="{{ $row->id }}"
                    class="dropdown-item text-hover-primary me-1 update-recurring" data-bs-toggle="tooltip"
                    title="{{ $row->recurring_status ? __('messages.invoice.stop_recurring') : __('messages.invoice.start_recurring') }}">
                    {{ $row->recurring_status ? __('messages.invoice.stop_recurring') : __('messages.invoice.start_recurring') }}
                </a>
            </li>
        @endif
        @if ($isPaid != 1)
        <li>
            <a href="javascript:void(0)"
               data-id="{{ $row->id }}"
               data-phone="{{ $row->client->user->contact }}"
               data-region-code="{{ $row->client->user->region_code }}"
               class="dropdown-item text-hover-primary me-1 open-send-whatapp-invoice"
               data-bs-toggle="tooltip"
               title="{{ __('messages.invoice.send_whatsapp') }}">
                {{ __('messages.invoice.send_whatsapp') }}
            </a>
        </li>
        @endif
    </ul>
</div>
