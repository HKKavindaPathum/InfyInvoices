@extends('settings.edit')
@section('title')
    {{ __('messages.settings') }}
@endsection
@section('section')
    @php $styleCss = 'style'; @endphp
    @include('layouts.errors')
    {{ Form::open(['route' => ['settings.update'], 'method' => 'post', 'files' => true, 'id' => 'createSetting']) }}
    <div class="card border-0">
        <div class="card-body">
            <div class="alert alert-danger display-none hide" id="validationErrorsBox"></div>
            <div class="row">
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('app_name', __('messages.setting.app_name') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    {{ Form::text('app_name', $settings['app_name'], ['class' => 'form-control ', 'required', 'id' => 'app_name']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('company_name', __('messages.setting.company_name') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    {{ Form::text('company_name', $settings['company_name'], ['class' => 'form-control ', 'required', 'id' => 'company_name']) }}
                </div>
                <div class="form-group col-sm-4 mb-5 country-code">
                    {{ Form::label('country_phone', __('messages.setting.country_code') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    {{ Form::tel('country_phone', $settings['country_code'], ['class' => 'form-control width-0', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'countryPhone']) }}
                    {{ Form::hidden('country_code', null, ['id' => 'countryCode']) }}
                    {{ Form::hidden('default_country_code', str_replace('+', '', $settings['country_code']), ['id' => 'defaultCountryCode']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('company_phone', __('messages.setting.company_phone') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    <br>
                    {{ Form::tel('company_phone', $settings['company_phone'] ?? getSettingValue('country_code'), ['class' => 'form-control ', 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'required']) }}
                    {{ Form::hidden('prefix_code', null, ['id' => 'prefix_code']) }}
                    <span id="valid-msg" class="hide">✓ &nbsp;
                        {{ __('messages.placeholder.valid_number') }}</span>
                    <span id="error-msg" class="hide"></span>
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('date_format', __('messages.setting.date_format') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    {{ Form::select('date_format', $dateFormats, $settings['date_format'], ['class' => 'form-select ', 'id' => 'dateFormat']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('timezone', __('messages.setting.timezone') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    {{ Form::select('time_zone', $timezones, getCurrentTimeZone(), ['class' => 'form-select ', 'id' => 'timeZone']) }}
                </div>
                <div class="form-group col-sm-3 mb-5">
                    {{ Form::label('payment_auto_approved', __('messages.setting.manual_payment_approval') . ':', ['class' => 'form-label required mb-3']) }}
                    <label class="form-check form-switch form-check-custom mt-3">
                        <input class="form-check-input currencyAfterAmount" type="checkbox" name="payment_auto_approved"
                            id="paymentAutoApproved"
                            {{ isset($settings['payment_auto_approved']) && $settings['payment_auto_approved'] == \App\Models\Setting::PAYMENT_AUTO_APPROVED ? 'checked' : '' }}>
                        <span class="form-check-label text-gray-600"
                            for="currencyAfterAmount">{{ __('messages.setting.auto_approve') }}</span>&nbsp;&nbsp;
                    </label>
                </div>
                <div class="form-group col-sm-3 mb-5">
                    {{ Form::label('time_format', __('messages.setting.time_format') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    <div class="radio-button-group">
                        <div class="btn-group btn-group-toggle m-0" data-toggle="buttons">
                            <input type="radio" name="time_format" id="time_format-0" value="0"
                                {{ isset($settings) ? ($settings['time_format'] == 0 ? 'checked' : '') : 'checked' }}>
                            <label for="time_format-0" class="me-2" role="button">12 Hour</label>

                            <input type="radio" name="time_format" id="time_format-1" value="1"
                                {{ isset($settings) ? ($settings['time_format'] == 0 ? '' : 'checked') : '' }}>
                            <label for="time_format-1" role="button">24 Hour</label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-3 mb-5">
                    {{ Form::label('mail_notifications', __('messages.setting.mail_notifications') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    <div class="radio-button-group">
                        <div class="btn-group btn-group-toggle m-0" data-toggle="buttons">
                            <input type="radio" name="mail_notification" id="mail_notification-0" value="1"
                                {{ isset($settings) ? ($settings['mail_notification'] == 0 ? '' : 'checked') : '' }}>
                            <label for="mail_notification-0" class="me-2"
                                role="button">{{ __('messages.tax.yes') }}</label>
                            <input type="radio" name="mail_notification" id="mail_notification-1" value="0"
                                {{ isset($settings) ? ($settings['mail_notification'] == 0 ? 'checked' : '') : 'checked' }}>
                            <label for="mail_notification-1" role="button">{{ __('messages.tax.no') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-3 mb-5">
                    {{ Form::label('clear_cache', __('messages.clear_cache') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    <div>
                        <a class="btn btn-primary"  aria-current="page"
                            href="{{ route('clear-cache') }}">
                            <span>{{ __('messages.clear_cache') }}</span>
                        </a>
                    </div>
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('country', __('messages.common.country') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('country', $settings['country'], ['class' => 'form-control ', 'id' => 'country']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('state', __('messages.common.state') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('state', $settings['state'], ['class' => 'form-control ', 'id' => 'state']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('city', __('messages.common.city') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('city', $settings['city'], ['class' => 'form-control ', 'id' => 'city']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('zipcode', __('messages.common.zipcode') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('zipcode', $settings['zipcode'], ['class' => 'form-control ', 'id' => 'zipcode']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('fax_no', __('messages.invoice.fax_no') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('fax_no', $settings['fax_no'], ['class' => 'form-control ', 'id' => 'faxNumber']) }}
                </div>
                <div class="form-group col-sm-4 mb-5">
                    {{ Form::label('gst_no', getVatNoLabel() . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('gst_no', $settings['gst_no'] ?? null, ['class' => 'form-control ', 'id' => 'gstNumber', 'placeholder' => 'GSTIN']) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('company_address', __('messages.setting.company_address') . ':', ['class' => 'form-label required fs-6  mb-3']) }}
                    {{ Form::textarea('company_address', $settings['company_address'], ['class' => 'form-control ', 'rows' => 5, 'cols' => 5, 'required', 'id' => 'companyAddress']) }}
                </div>
                <div class="form-group col-sm-3 mb-5">
                    <div class="form-group col-sm-6 mb-5">
                        <div class="mb-3" io-image-input="true">
                            <label for="appLogoPreview"
                                class="form-label required">{{ __('messages.setting.app_logo') . ':' }}</label>
                            <div class="d-block">
                                <div class="image-picker">
                                    <div class="image previewImage" id="appLogoPreview"
                                        {{ $styleCss }}="
                                        background-image: url({{ $settings['app_logo'] != null ? asset($settings['app_logo']) : asset('assets/images/infyom.png') }}
                                            )">
                                    </div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                        title="Change app logo">
                                        <label>
                                            <i class="fa-solid fa-pen" id="appLogoIcon"></i>
                                            <input type="file" id="appLogo" name="app_logo" class="image-upload d-none"
                                                accept="image/*" />
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Company Logo Field -->
                <div class="form-group col-sm-3 mb-5">
                    <div class="mb-3" io-image-input="true">
                        <label for="faviconPreview" class="form-label required">
                            {{ __('messages.setting.fav_icon') . ':' }}</label>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="faviconPreview"
                                    {{ $styleCss }}="
                                background-image: url({{ $settings['favicon_icon'] != null ? asset($settings['favicon_icon']) : asset('assets/images/favicon.png') }}
                                    );">
                                </div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                    title="Change favicon">
                                    <label>
                                        <i class="fa-solid fa-pen" id="faviconImageIcon"></i>
                                        <input type="file" id="favicon_icon" name="favicon_icon"
                                            class="image-upload d-none" accept="image/*" />
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-4 mb-5 mt-2">
                    {{ Form::label('vat_no_label', __('messages.setting.vat_no_label') . ':', ['class' => 'form-label fs-6  mb-3']) }}
                    {{ Form::text('vat_no_label', $settings['vat_no_label'] ?? null, ['class' => 'form-control', 'placeholder' => __('messages.setting.vat_no_label')]) }}
                </div>
                <div class="form-group col-sm-4 mb-5 mt-2">
                    {{ Form::label('default_language', __('messages.setting.default_language') . ':', ['class' => 'form-label']) }}
                    {{ Form::select('default_language', getUserLanguages(), $settings['default_language'] ?? 'en', ['class' => 'form-control form-select', 'required', 'data-control' => 'select2']) }}
                </div>
                <div class="form-group col-sm-4 mb-5 mt-2">
                    {{ Form::label('show_additional_address_in_invoice', __('messages.setting.show_additional_address') . ':', ['class' => 'form-label mb-3']) }}
                    <label class="form-check form-switch form-check-custom mt-3">
                        <input class="form-check-input currencyAfterAmount" type="checkbox"
                            name="show_additional_address_in_invoice" id="ShowAdditionalAddress"
                            {{ isset($settings['show_additional_address_in_invoice']) && $settings['show_additional_address_in_invoice'] == '1' ? 'checked' : '' }}>
                    </label>
                </div>
            </div>
            <!-- Submit Field -->
            <div class="float-end d-flex mt-5">
                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                <a href="{{ route('settings.edit') }}"
                    class="btn  btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
