<div class="aside-menu-container" id="sidebar">
    <div class="aside-menu-container__aside-logo flex-column-auto">
        <a href="{{ url('/') }}" class="text-decoration-none sidebar-logo d-flex align-items-center" data-bs-toggle="tooltip"
           title="{{ (strlen(getAppName()) > 15 ) ? substr(getAppName(), 0,15).'...' : getAppName() }}">
            <div class="image image-mini me-3">
                <img src="{{ getLogoUrl() }}"
                     class="img-fluid object-contain" alt="profile image">
            </div>
            <span class="text-gray-900 fs-4">{{ (strlen(getAppName()) > 15 ) ? substr(getAppName(), 0,15).'...' : getAppName() }}</span>
        </a>
        <button type="button" class="btn px-0 aside-menu-container__aside-menubar d-lg-block d-none sidebar-btn">
            <i class="fa-solid fa-bars fs-1"></i>
        </button>
    </div>
    <div class="aside-menu-container__sidebar-scrolling overflow-auto">
        <ul class="aside-menu-container__aside-menu nav flex-column">
            @include('layouts.menu')
        </ul>
    </div>
</div>
<div class="bg-overlay" id="sidebar-overly"></div>
