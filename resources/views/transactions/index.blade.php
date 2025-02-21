@extends('layouts.app')
@section('title')
    {{ __('messages.transactions') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <livewire:transaction-table lazy />
        </div>
    </div>
    @include('transactions.payment-notes-modal')
    {{ Form::hidden('currency', getCurrencySymbol(), ['id' => 'currency']) }}
@endsection
