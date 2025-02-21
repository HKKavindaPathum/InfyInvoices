@extends('layouts.auth')
@section('title')
    {{ __('messages.client.reset_password') }}
@endsection
@section('content')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center mt-0">
            <a href="{{ url('/') }}" class="image mb-7 mb-sm-10 image-medium">
                <img alt="Logo" src="{{ getLogoUrl() }}" class="img-fluid object-contain">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto bg-white">
            <h1 class="text-center mb-7">{{ __('messages.client.reset_password') }}</h1>
            <form class="form w-100" method="POST" action="{{ route('client.password.update') }}">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="id" value="{{ Crypt::decrypt($request->id) }}">
                <!-- Password -->
                <div class="fv-row mb-5">
                    <label class="form-label mb-0" for="password">{{ __('messages.user.new_password') }}: </label><span
                        class="required"></span>
                    <div class="position-relative">
                        <input id="password" class="form-control" type="password" name="password" required
                            autocomplete="off" placeholder="{{ __('messages.user.new_password') }}" aria-label="Password"
                            data-toggle="password" />
                        <span
                            class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <!-- Confirm Password -->
                <div class="fv-row mb-10">
                    <label class="form-label mb-0"
                        for="password_confirmation">{{ __('messages.client.confirm_password') }}:</label><span
                        class="required"></span>
                    <div class="position-relative">
                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation"
                            autocomplete="off" placeholder="{{ __('messages.client.confirm_your_password') }}"
                            aria-label="Password" data-toggle="password" />
                        <span
                            class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100 mb-5">
                        <span class="indicator-label">{{ __('messages.client.reset_password') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
