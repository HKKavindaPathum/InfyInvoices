@extends('layouts.app')
@section('title')
    {{ __('messages.country.countries') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:country-table lazy />
        </div>
    </div>

    @include('countries.add_modal')
    @include('countries.edit_modal')
@endsection
