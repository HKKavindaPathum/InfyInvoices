<div class="row gx-10 mb-5">
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('first_name', __('messages.client.first_name').':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('first_name', isset($user) ? $user->first_name : null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.first_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('last_name', __('messages.client.last_name').':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('last_name', isset($user) ? $user->last_name : null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.last_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('email', __('messages.client.email').':', ['class' => 'form-label required mb-3']) }}
            {{ Form::email('email', isset($user) ? $user->email : null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.client.email'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('contact', __('messages.client.contact_no').':', ['class' => 'form-label mb-3']) }}
            {{ Form::tel('contact', $user->contact ?? getSettingValue('country_code'), ['class' => 'form-control form-control-solid', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
            {{ Form::hidden('region_code',isset($user) ? $user->region_code : null,['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide text-success fw-400 fs-small mt-2">✓ &nbsp;{{ __('messages.placeholder.valid_number') }}</span>
            <span id="error-msg" class="hide text-danger fw-400 fs-small mt-2"></span>
        </div>
    </div>
    <div class="col-md-6 mb-5">
        <div class="fv-row">
            <div class="">
                {{ Form::label('password',__('messages.client.password').':' ,['class' => 'form-label mb-3']) }}
                <div class="position-relative">
                    <input class="form-control form-control-solid"
                           type="password" placeholder={{__('messages.client.password')}} name="password"
                           autocomplete="off"
                           aria-label="Password" data-toggle="password">
                    <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                                <i class="bi bi-eye-slash-fill"></i>
                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-5">
        <div class="fv-row">
            <div class="">
                {{ Form::label('confirmPassword',__('messages.client.confirm_password').':' ,['class' => 'form-label mb-3']) }}
                <div class="position-relative">
                    <input class="form-control form-control-solid"
                           type="password"
                           placeholder="{{__('messages.client.confirm_password')}}" name="password_confirmation"
                           autocomplete="off" aria-label="Password" data-toggle="password">
                    <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                               <i class="bi bi-eye-slash-fill"></i>
                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3" io-image-input="true">
        <label for="exampleInputImage" class="form-label">{{ __('messages.client.profile') }}:</label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="exampleInputImage"
                     style="background-image: url('{{ !empty($user->profile_image) ? $user->profile_image : asset('assets/images/avatar.png') }}')">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                      title="Change Profile">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            <input type="file" id="profile_image" name="profile" class="image-upload d-none"
                                   accept=".png, .jpg, .jpeg"/>
                    </label>
                </span>
            </div>
        </div>
        <div class="form-text">{{ __('messages.flash.allowed_file_types_png_jpg_jpeg') }}</div>
    </div>
</div>
<div class="float-end d-flex">
    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-3']) }}
    <a href="{{ route('users.index') }}" type="reset"
       class="btn btn-secondary btn-active-light-primary">{{__('messages.common.cancel')}}</a>
</div>
