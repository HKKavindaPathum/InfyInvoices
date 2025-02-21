<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log Viewer
    |--------------------------------------------------------------------------
    | Log Viewer can be disabled, so it's no longer accessible via browser.
    |
    */
    'enabled' => env('LOG_VIEWER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Log Viewer Domain
    |--------------------------------------------------------------------------
    | You may change the domain where Log Viewer should be active.
    | If the domain is empty, all domains will be valid.
    |
    */

    'route_domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Log Viewer Route
    |--------------------------------------------------------------------------
    | Log Viewer will be available under this URL.
    |
    */

    'route_path' => 'admin/log-viewer',

    /*
    |--------------------------------------------------------------------------
    | Back to system URL
    |--------------------------------------------------------------------------
    | When set, displays a link to easily get back to this URL.
    | Set to `null` to hide this link.
    |
    | Optional label to display for the above URL.
    |
    */

    'back_to_system_url' => config('app.url', null),

    'back_to_system_label' => null, // Displayed by default: "Back to {{ app.name }}"

    /*
    |--------------------------------------------------------------------------
    | Log Viewer route middleware.
    |--------------------------------------------------------------------------
    | The middleware should enable session and cookies support in order for the Log Viewer to work.
    | The 'web' middleware will be applied automatically if empty.
    |
    */

    'middleware' => ['web', 'auth', 'role:admin'],

    /*
    |--------------------------------------------------------------------------
    | Include file patterns
    |--------------------------------------------------------------------------
    |
    */

    'include_files' => [
        '*.log',
        '**/*.log',
        // You can include paths to other log types as well, such as apache, nginx, and more.
        '/var/log/httpd/*',
        '/var/log/nginx/*',
        // MacOS Apple Silicon logs
        '/opt/homebrew/var/log/nginx/*',
        '/opt/homebrew/var/log/httpd/*',
        '/opt/homebrew/var/log/php-fpm.log',
        '/opt/homebrew/var/log/postgres*log',
        '/opt/homebrew/var/log/redis*log',
        '/opt/homebrew/var/log/supervisor*log',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude file patterns.
    |--------------------------------------------------------------------------
    | This will take precedence over included files.
    |
    */

    'exclude_files' => [
        //'my_secret.log'
    ],

    /*
    |--------------------------------------------------------------------------
    |  Shorter stack trace filters.
    |--------------------------------------------------------------------------
    | Lines containing any of these strings will be excluded from the full log.
    | This setting is only active when the function is enabled via the user interface.
    |
    */

    'shorter_stack_trace_excludes' => [
        '/vendor/symfony/',
        '/vendor/laravel/framework/',
        '/vendor/barryvdh/laravel-debugbar/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Log matching patterns
    |--------------------------------------------------------------------------
    | Regexes for matching log files
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Chunk size when scanning log files lazily
    |--------------------------------------------------------------------------
    | The size in MB of files to scan before updating the progress bar when searching across all files.
    |
    */

    'lazy_scan_chunk_size_in_mb' => 200,
];
