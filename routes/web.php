<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/home', function () {
    return view('home');
})->name('home');
