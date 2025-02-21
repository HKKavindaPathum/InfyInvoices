    @extends('layouts.app')
    @section('title')
        {{ __('messages.dashboard') }}
    @endsection
    @section('content')
        <div class="container-fluid">
            <div class="d-flex flex-column">
                <div class="row">
                    <div class="col-12">
                        @include('flash::message')
                        <livewire:dashboard lazy />
                    </div>
                    <div class="col-12 mb-4">
                        <div>
                            <div class="card mt-3">
                                <div class="card-body p-5">
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="mb-0">{{ __('messages.admin_dashboard.income_overview') }}</h3>
                                        <div class="ms-auto">
                                            <div id="rightData" class="date-ranger-picker">
                                                <input class="form-control removeFocus text-center " id="time_range" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-6 p-0">
                                        <div class="">
                                            <div id="yearly_income_overview-container" class="pt-2">
                                                <canvas id="yearly_income_chart_canvas" height="200"
                                                    width="905"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-12 mb-5 mb-xl-0">
                        <div class="card">
                            <div class="card-header pb-0 px-10">
                                <h3 class="mb-0">{{ __('messages.admin_dashboard.payment_overview') }}</h3>
                            </div>
                            <div class="card-body pt-7">
                                <div id="payment-overview-container" class="justify-align-center">
                                    <canvas id="payment_overview"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-12">
                        <div class="card">
                            <div class="card-header pb-0 px-10">
                                <h3 class="mb-0">{{ __('messages.admin_dashboard.invoice_overview') }}</h3>
                            </div>
                            <div class="card-body pt-7">
                                <div id="invoice-overview-container" class="justify-align-center">
                                    <canvas id="invoice_overview"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::hidden('currency', getCurrencySymbol(), ['id' => 'currency']) }}
    @endsection
