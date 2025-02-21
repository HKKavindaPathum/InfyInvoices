@extends('layouts.app')
@section('title')
    {{ __('messages.admins') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <livewire:user-table lazy />
        </div>
    </div>
@endsection
