<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-middleware', function () {
    $kernel = app('Illuminate\Contracts\Http\Kernel');
    dd($kernel->getRouteMiddleware());
});
