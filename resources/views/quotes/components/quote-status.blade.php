@if ($row->status_label === 'Draft')
    <span class="badge bg-light-warning fs-7">{{ __('messages.draft') }}</span>
@else
    <span class="badge bg-light-success fs-7">{{ __('messages.converted') }}</span>
@endif
