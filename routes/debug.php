<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-domain', function () {
    return [
        'app_url' => config('app.url'),
        'parsed_host' => parse_url(config('app.url'), PHP_URL_HOST),
        'request_host' => request()->getHost(),
        'central_domains' => config('tenancy.central_domains'),
        'php_version' => phpversion(),
    ];
});
