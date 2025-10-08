<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\CutiBersamaController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\AsetController;

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
     Route::get('data-user/{id}', [CutiController::class, 'getData']);
    Route::get('halaman-data', [CutiController::class, 'dataSemua'])->name('halaman.data');
    Route::get('halaman-verifikasi/{id}', [CutiController::class, 'halamanTerima'])->name('halaman.cuti');
    Route::get('halaman-print/{id}', [CutiController::class, 'print'])->name('halaman.print');
    Route::get('halaman-preview/{id}', [CutiController::class, 'preview'])->name('halaman.preview');
    Route::get( 'verifikasi-cuti/{id}', [CutiController::class, 'terimaCuti'])->name('terima.cuti');
     Route::resource('daily', DailyController::class);
     Route::resource('cuti', CutiController::class);
    Route::resource('cuti-bersama', CutiBersamaController::class);
    // Route::resource('surat', SuratController::class);

});
Route::prefix('admin')->group(function () {
    Route::resource('surat', SuratController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('aset', AsetController::class);
});
