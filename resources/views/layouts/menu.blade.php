@role('admin')
    <li class="nav-item {{ Request::is('admin/dashboard*', 'admin/currency-reports*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('admin.dashboard') }}">
            <span class="menu-icon">
                <i class="fa-solid fa-chart-pie pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.dashboard') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('users.index') }}">
            <span class="menu-icon">
                <i class="fas fa-user-alt pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.admins') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/client*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('clients.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-users pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.clients') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('category.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-th-list pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.categories') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/taxes*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('taxes.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-percentage pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.taxes') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/products*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('products.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-cube pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.products') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/quotes*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('quotes.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-quote-left pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.quotes') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/invoices*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('invoices.index') }}">
            <span class="menu-icon">
                <i class="fa-solid far fa-file-alt pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.invoices') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/payment-qr-codes*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page"
            href="{{ route('payment-qr-codes.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fa-qrcode pe-3"></i>
            </span>
            <span class="aside-menu-title">{!! __('messages.payment_qr_codes.payment_qr_codes') !!}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/transactions*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('transactions.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-list-ol pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.transactions') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/payments*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('payments.index') }}">
            <span class="menu-icon">
                <i class="fa-solid fas fa-money-check pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.payments') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/template-setting*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('invoiceTemplate') }}">
            <span class="menu-icon">
                <i class="fa-solid far fa-copy pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.invoice_templates') }}</span>
        </a>
    </li>

    <li
        class="nav-item {{ Request::is('admin/settings*', 'admin/currencies*', 'admin/payment-gateway*', 'admin/invoice-settings*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('settings.edit') }}">
            <span class="menu-icon">
                <i class="fa-solid fa fa-cogs pe-3"></i>
            </span>
            <span class="aside-menu-title">{{ __('messages.settings') }}</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/countries*', 'admin/states*', 'admin/cities*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('countries.index') }}">
            <span class="aside-menu-icon pe-3"><i class="fas fa-globe-americas icon-color-bs-purple"></i></span>
            <span class="aside-menu-title">{{ __('messages.country.countries') }}</span>
        </a>
    </li>
@endrole
@role('client')
    @include('client_panel.layouts.menu')
@endrole
