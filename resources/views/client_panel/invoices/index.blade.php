@extends('client_panel.layouts.app')
@section('title')
    {{ __('messages.invoices') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:client-invoice-table lazy />
        </div>
    </div>
    @include('invoices.send_whatsapp_modal')
    {{ Form::hidden('status', $status, ['id' => 'status']) }}
@endsection
