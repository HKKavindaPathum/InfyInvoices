@extends('layouts.app')
@section('title')
    {{ __('messages.taxes') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:tax-table lazy />
        </div>
        @include('taxes.create_modal')
        @include('taxes.edit_modal')
    </div>
@endsection
