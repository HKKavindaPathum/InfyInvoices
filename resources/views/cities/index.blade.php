@extends('layouts.app')
@section('title')
    {{__('messages.city.cities')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:city-table lazy/>
        </div>
    </div>

    @include('cities.add_modal')
    @include('cities.edit_modal')
@endsection
