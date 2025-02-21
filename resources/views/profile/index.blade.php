@extends('layouts.app')
@section('title')
    {{ __('messages.user.profile_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="col-12">
                @include('layouts.errors')
                @include('flash::message')
                <div class="card">
                    <form id="userProfileEditForm" method="POST" action="{{ route('update.profile.setting') }}"
                        class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label required">{{ __('messages.user.avatar') . ':' }}</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <div class="d-block">
                                        <div class="image-picker">
                                            <div class="image previewImage" id="exampleInputImage"
                                                style="background-image: url('{{ !empty($user->profile_image) ? $user->profile_image : asset('assets/images/avatar.png') }}')">
                                            </div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                data-bs-toggle="tooltip" title="{{ __('messages.change_avatar') }}">
                                                <label>
                                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file" id="profile_image" name="image"
                                                        class="image-upload d-none" accept="image/*" />
                                                    {{ Form::hidden('avatar_remove') }}
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label required">{{ __('messages.user.full_name') . ':' }}</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                            {!! Form::text('first_name', $user->first_name, [
                                                'class' => 'form-control',
                                                'placeholder' => __('messages.client.first_name'),
                                                'required',
                                                'id' => 'editProfileFirstName',
                                            ]) !!}
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                            {!! Form::text('last_name', $user->last_name, [
                                                'class' => 'form-control',
                                                'placeholder' => __('messages.client.last_name'),
                                                'required',
                                                'id' => 'editProfileLastName',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label required">{{ __('messages.user.email') . ':' }}</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    {!! Form::email('email', $user->email, [
                                        'class' => 'form-control',
                                        'placeholder' => __('messages.user.email'),
                                        'required',
                                        'id' => 'isEmailEditProfile',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 form-label mb-3">{{ __('messages.user.contact_number') . ':' }}</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    {{ Form::tel('contact', isset($user) ? $user->contact : null, ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'phoneNumber', 'placeholder' => __('messages.user.phone_number')]) }}
                                    {{ Form::hidden('region_code', isset($user) ? $user->region_code : null, ['id' => 'prefix_code']) }}
                                    <span id="valid-msg" class="hide text-success fw-400 fs-small mt-2">✓
                                        {{ __('messages.placeholder.valid_number') }}</span>
                                    <span id="error-msg" class="hide text-danger fw-400 fs-small mt-2"></span>
                                </div>
                            </div>
                            @hasrole('admin')
                                <div class="float-end mb-6">
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
                                    <a href="{{ route('admin.dashboard') }}" type="reset"
                                        class="btn btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
                                </div>
                            @else
                                <div class="float-end mb-6">
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
                                    <a href="{{ route('client.dashboard') }}" type="reset"
                                        class="btn btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
                                </div>
                            @endrole
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{ Form::hidden('is_edit', true, ['id' => 'isEdit']) }}
@endsection
@section('phone_js')
    <script>
        var phoneNo = "{{ !empty($user) ? $user->region_code . $user->contact : null }}"
    </script>
@endsection
