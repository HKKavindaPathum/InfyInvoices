@if(\Illuminate\Support\Facades\Auth::user()->hasRole(\App\Models\Role::ROLE_ADMIN))
    @if ($row->is_approved == \App\Models\Payment::PENDING && $row->payment_mode == \App\Models\Payment::MANUAL)
        <div class="d-flex align-items-center">
            <select class="form-select io-select2 approve-status transaction-approve"
                    data-id="{{$row->id}}" data-control="select2">
                <option selected="selected" value="">{{__('messages.setting.select_manual_payment')}}</option>
                <option value="{{\App\Models\Payment::APPROVED}}">{{__('messages.setting.approved')}}</option>
                <option value="{{\App\Models\Payment::REJECTED}}">{{__('messages.setting.denied')}}</option>
            </select>
        </div>
    @elseif ($row->is_approved == \App\Models\Payment::APPROVED )
        <span class="badge bg-light-success">{{__('messages.setting.approved')}}</span>
    @elseif ($row->is_approved == \App\Models\Payment::REJECTED )
    <span class="badge bg-light-danger">{{__('messages.setting.denied')}}</span>
    @else
        N/A
    @endif
@endif
