<footer class="border-top w-100 pt-4 mt-7">
    <div class="d-flex justify-content-between">
        <p class="fs-6 text-gray-600">{{ __('messages.common.all_rights_reserved') }} ©{{ \Carbon\Carbon::now()->year }}
            <a href="{{ url('/') }}" class="text-decoration-none">{{ getAppName() }}</a>
        </p>
        <div>v{{ getCurrentVersion() }}</div>
    </div>
</footer>
