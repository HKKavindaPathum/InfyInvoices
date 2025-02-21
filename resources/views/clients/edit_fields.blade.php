<div class="row gx-10 mb-5">
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('first_name', __('messages.client.first_name') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('first_name', $client->user->first_name ?? null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.first_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('last_name', __('messages.client.last_name') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('last_name', $client->user->last_name ?? null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.last_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('email', __('messages.client.email') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::email('email', $client->user->email ?? null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.email'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('contact', __('messages.client.contact_no') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::tel('contact', $client->user->contact ?? getSettingValue('country_code'), ['class' => 'form-control form-control-solid', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'phoneNumber']) }}
            {{ Form::hidden('region_code', $client->user->region_code ?? null, ['id' => 'prefix_code']) }}
            <span id="valid-msg" class="hide text-success fw-400 fs-small mt-2">✓ &nbsp;
                {{ __('messages.placeholder.valid_number') }}</span>
            <span id="error-msg" class="hide text-danger fw-400 fs-small mt-2"></span>
        </div>
    </div>
    {{-- <div class="col-lg-6 mb-5">
        <div class="fv-row">
            <div>
                {{ Form::label('password', __('messages.client.password') . ':', ['class' => 'form-label mb-3']) }}
                <div class="position-relative">
                    <input class="form-control" type="password" placeholder="{{ __('messages.client.password') }}"
                        name="password" autocomplete="off" aria-label="password" data-toggle="password">
                    <span
                        class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <div class="fv-row">
            <div>
                {{ Form::label('confirmPassword', __('messages.client.confirm_password') . ':', ['class' => 'form-label mb-3']) }}
                <div class="position-relative">
                    <input class="form-control" type="password"
                        placeholder="{{ __('messages.client.confirm_password') }}" name="password_confirmation"
                        autocomplete="off" aria-label="Password" data-toggle="password">
                    <span
                        class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('website', __('messages.client.website') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::text('website', $client->website ?? null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.website')]) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('postal_code', __('messages.client.postal_code') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('postal_code', $client->postal_code ?? null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.postal_code'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="mb-5">
            {{ Form::label('country', __('messages.client.country') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::select('country_id', $countries, $client->country_id ?? null, ['id' => 'countryId', 'class' => 'form-select io-select2 ', 'placeholder' => __('messages.client.country'), 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="mb-5">
            {{ Form::label('state', __('messages.client.state') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::select('state_id', [], null, ['id' => 'stateId', 'class' => 'form-select io-select2 ', 'placeholder' => __('messages.client.state'), 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-lg-3 city-select-input">
        <div class="mb-5">
            {{ Form::label('city', __('messages.client.city') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::select('city_id', [], null, ['id' => 'cityId', 'class' => 'form-select io-select2 ', 'placeholder' => __('messages.client.city'), 'data-control' => 'select2']) }}
        </div>
    </div>

    <div class="col-lg-3 city-text-input d-none">
        <div class="mb-5">
            {{ Form::label('city', __('messages.client.city') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::text('city_name', null, ['id' => 'cityId', 'class' => 'form-control ', 'placeholder' => __('messages.client.city')]) }}
        </div>
    </div>
    <div class="col-lg-1 mt-5">
        <button type="button" class="btn btn-primary ms-3 mt-3" id="addCityBtn">
            <i class="fa-solid fa-pen-to-square"></i>
        </button>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('address', __('messages.client.address') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::textarea('address', $client->address ?? null, ['class' => 'form-control form-control-solid', 'rows' => '5', 'placeholder' => __('messages.client.address'), 'rows' => '5']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('notes', __('messages.client.notes') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::textarea('note', $client->note ?? null, ['class' => 'form-control form-control-solid', 'rows' => '5', 'placeholder' => __('messages.client.notes'), 'rows' => '5']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('company_name', __('messages.setting.company_name') . ':', ['class' => 'form-label mb-3']) }}
        {{ Form::text('company_name', $client->company_name ?? null, ['class' => 'form-control', 'placeholder' => __('messages.setting.company_name')]) }}
    </div>
    <div class="col-xl-3 col-lg-2 mb-7">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputImage" class="form-label">{{ __('messages.client.profile') . ':' }}</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="previewImage"
                        {{ $styleCss }}="background-image: url('{{ !empty($client->user->profile_image) ? $client->user->profile_image : asset('web/media/avatars/150-26.jpg') }}')">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                        title="Change Profile">
                        <label>
                            <i class="fa-solid fa-pen" id="previewImage"></i>
                            <input type="file" id="profile_image" name="profile" class="image-upload d-none"
                                accept="image/*" />
                            <input type="hidden" name="avatar_remove">
                        </label>
                    </span>
                </div>
            </div>
            <div class="form-text">{{ __('messages.flash.allowed_file_types_png_jpg_jpeg') }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 mb-7">
        {{ Form::label('vat_no', $vatNoLabel . ':', ['class' => 'form-label mb-3']) }}
        {{ Form::text('vat_no', $client->vat_no ?? null, ['class' => 'form-control', 'placeholder' => $vatNoLabel]) }}
    </div>
    <div class="d-flex justify-content-end mt-5">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('clients.index') }}" type="reset"
            class="btn btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
    </div>
