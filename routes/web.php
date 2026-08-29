<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontController::class, 'beranda'])->name('beranda');

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
});

Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});