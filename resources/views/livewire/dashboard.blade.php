<div>
    <div class="row">
        {{-- Clients Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('clients.index') }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-primary shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                    <div class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user display-4 card-icon text-white"></i>
                    </div>
                    <div class="text-end text-white">
                        <h2 class="fs-1-xxl fw-bolder text-white">
                            {{ formatTotalAmount($totalClients) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">
                            {{ __('messages.admin_dashboard.total_clients') }}</h3>
                    </div>
                </div>
            </a>
        </div>
        {{-- Total Invoices Amount Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('currency.reports') }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-success shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-center my-3">
                    <div class="text-white mt-3 text-center">
                        <h2 class="fs-1-xxl fw-bolder text-white">
                            {{ __('messages.admin_dashboard.total_amount') }}
                        </h2>
                        <span class="text-white">{{ __('messages.common.click_here') }}</span>
                    </div>
                </div>
            </a>
        </div>
        {{-- Recieved Amount Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('currency.reports') }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-info shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-center my-3">
                    <div class="text-white mt-3 text-center">
                        <h2 class="fs-1-xxl fw-bolder text-white">
                            {{ __('messages.admin_dashboard.total_paid') }}
                        </h2>
                        <span class="text-white">{{ __('messages.common.click_here') }}</span>
                    </div>
                </div>
            </a>
        </div>
        {{-- Partially Paid Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('currency.reports') }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-warning shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-center my-3">
                    <div class="text-white mt-3 text-center">
                        <h2 class="fs-1-xxl fw-bolder text-white">
                            {{ __('messages.admin_dashboard.total_due') }}
                        </h2>
                        <span class="text-white">{{ __('messages.common.click_here') }}</span>
                    </div>
                </div>
            </a>
        </div>
        {{-- Products Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('products.index') }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-secondary shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                    <div class="bg-gray-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fas fa-cube display-4 card-icon text-dark"></i>
                    </div>
                    <div class="text-end text-dark">
                        <h2 class="fs-1-xxl fw-bolder text-dark">
                            {{ formatTotalAmount($totalProducts) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">
                            {{ __('messages.admin_dashboard.total_products') }}</h3>
                    </div>
                </div>
            </a>
        </div>
        {{-- Total Invoices Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('invoices.index') }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-danger shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                    <div class="bg-red-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-invoice display-4 card-icon text-white"></i>
                    </div>
                    <div class="text-end text-white">
                        <h2 class="fs-1-xxl fw-bolder text-white">
                            {{ formatTotalAmount($totalInvoices) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">
                            {{ __('messages.admin_dashboard.total_invoices') }}</h3>
                    </div>
                </div>
            </a>
        </div>
        {{-- Paid Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('invoices.index', ['status' => 2]) }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-dark shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                    <div class="bg-gray-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-clipboard-check display-4 card-icon {{ \Illuminate\Support\Facades\Auth::user()->dark_mode ? 'text-black' : 'text-white' }}"></i>
                    </div>
                    <div
                        class="text-end {{ \Illuminate\Support\Facades\Auth::user()->dark_mode ? 'text-black' : 'text-white' }}">
                        <h2
                            class="fs-1-xxl fw-bolder {{ \Illuminate\Support\Facades\Auth::user()->dark_mode ? 'text-black' : 'text-white' }}">
                            {{ formatTotalAmount($paidInvoices) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">
                            {{ __('messages.admin_dashboard.total_paid_invoices') }}</h3>
                    </div>
                </div>
            </a>
        </div>
        {{-- Unapid Widget --}}
        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
            <a href="{{ route('invoices.index', ['status' => 1]) }}" class="mb-xl-8 text-decoration-none">
                <div
                    class="bg-primary shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                    <div class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fas fa-exclamation-triangle display-4 card-icon text-white"></i>
                    </div>
                    <div class="text-end text-white">
                        <h2 class="fs-1-xxl fw-bolder text-white">
                            {{ formatTotalAmount($unpaidInvoices) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">
                            {{ __('messages.admin_dashboard.total_unpaid_invoices') }}</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
