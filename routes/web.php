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
use App\Http\Controllers\Marketing\VisitController;
use App\Http\Controllers\Marketing\ContactController;
use App\Http\Controllers\Master\SettingController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\DocumentController;
use App\Http\Controllers\Master\InstansiController;
use App\Http\Controllers\Master\JabatanController;
use App\Http\Controllers\Master\DivisiController;
use App\Http\Controllers\Master\UserController;

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
    Route::get('/profil', [HomeController::class, 'profile'])->name('profil');
    Route::post('/profil-update', [HomeController::class, 'profileUpdate'])->name('profil.update');
    Route::get('daily/report', [DailyController::class, 'report'])->name('daily.report');
    Route::get('data-user/{id}', [CutiController::class, 'getData']);
    Route::get('halaman-data', [CutiController::class, 'dataSemua'])->name('halaman.data');
    Route::get('halaman-verifikasi/{id}', [CutiController::class, 'halamanTerima'])->name('halaman.cuti');
    Route::get('halaman-print/{id}', [CutiController::class, 'print'])->name('halaman.print');
    Route::get('halaman-preview/{id}', [CutiController::class, 'preview'])->name('halaman.preview');
    Route::post('verifikasi-cuti/{id}', [CutiController::class, 'terimaCuti'])->name('terima.cuti');
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

Route::prefix('marketing')->group(function () {
    Route::get('visit/contact', [VisitController::class, 'contact']);
    Route::post('get/contact', [VisitController::class, 'contact']);
    Route::resource('visit', VisitController::class);
    Route::resource('contact', ContactController::class);
});

Route::prefix('master')->group(function () {
    Route::resource('setting', SettingController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('document', DocumentController::class);
    Route::resource('instansi', InstansiController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('divisi', DivisiController::class);
    Route::get('user/password/{id}', [UserController::class, 'password'])->name('user.password');
    Route::post('user/password', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::resource('user', UserController::class);
});
// Route::group(    ['prefix' => 'admin','middleware' => ['auth', 'role:5,6'],],function () {
//         Route::resource('aset', AsetController::class);
//         Route::resource('surat', SuratController::class);
//     });
