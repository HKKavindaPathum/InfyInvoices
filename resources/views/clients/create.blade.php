@extends('layouts.app')
@section('title')
    {{__('messages.client.add_client')}}
@endsection
@section('content')
    @php $styleCss = 'style'; @endphp
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <h1>@yield('title')</h1>
                    <a class="btn btn-outline-primary float-end"
                       href="{{ route('clients.index') }}">{{ __('messages.common.back') }}</a>
                </div>
                <div class="col-12">
                    @include('layouts.errors')
                </div>
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => 'clients.store','files' => 'true','id'=>'clientForm']) }}
                        @include('clients.fields')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::hidden('is_edit', false ,['id' => 'isEdit']) }}
    {{ Form::hidden('default_avatar_image_url', asset('assets/images/avatar.png'),['id' => 'defaultAvatarImageUrl']) }}
    {{ Form::hidden('country_id', old('country_id'),['id' => 'clientCountryId']) }}
    {{ Form::hidden('state_id', old('state_id') ,['id' => 'clientStateId']) }}
    {{ Form::hidden('city_id', old('city_id') ,['id' => 'clientCityId']) }}
@endsection
@section('phone_js')
    <script>
        phoneNo = "{{ old('region_code').old('contact') }}"
    </script>
@endsection

