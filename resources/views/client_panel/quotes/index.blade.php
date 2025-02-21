@extends('client_panel.layouts.app')
@section('title')
    {{ __('messages.quotes') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:client-quote-table lazy />
        </div>
    </div>
@endsection
