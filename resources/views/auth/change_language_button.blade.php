@php
    $language = !empty(checkLanguageSession()) ? checkLanguageSession() : getDefaultLanguage();
@endphp
<ul class="nav nav-pills justify-content-end cursor-pointer mt-4 me-4">
    <li class="nav-item dropdown">
        <a class="btn btn-primary w-150px mb-5 indicator m-3" data-bs-toggle="dropdown" href="javascript:void(0)"
            role="button" aria-expanded="false">{{ getUserLanguages()[$language] }}
        </a>
        <ul class="dropdown-menu w-70px">
            @foreach (getUserLanguages() as $key => $value)
                <li class="{{ checkLanguageSession() == $key ? 'active' : '' }}">
                    <a class="dropdown-item  px-5 language-select {{ checkLanguageSession() == $key ? 'bg-primary text-white' : 'text-dark' }}"
                        data-id="{{ $key }}">{{ $value }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
</ul>
