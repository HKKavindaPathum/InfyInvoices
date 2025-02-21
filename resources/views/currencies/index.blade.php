@extends('layouts.app')
@section('title')
    Currency
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:currency-table lazy />
        </div>
    </div>
    @include('currencies.create_modal')
    @include('currencies.edit_modal')
@endsection
