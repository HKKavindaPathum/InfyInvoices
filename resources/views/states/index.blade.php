@extends('layouts.app')
@section('title')
    {{ __('messages.state.states') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:state-table lazy />
        </div>
    </div>

    @include('states.add_modal')
    @include('states.edit_modal')
@endsection
