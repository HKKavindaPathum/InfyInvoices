@extends('client_panel.layouts.app')
@section('title')
    {{ __('messages.dashboard') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:client-dashboard lazy />
    </div>
@endsection
