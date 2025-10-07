<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DailyController;

Route::get('/', function () {
    return redirect()->route('login');
});




Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
     Route::get('/home', [HomeController::class, 'index'])->name('home');
     Route::get('daily/report', [DailyController::class, 'report'])->name('daily.report');
     Route::resource('daily', DailyController::class);
});
