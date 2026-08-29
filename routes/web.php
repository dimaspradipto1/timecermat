<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Front Stage (Layar Panggung Beranda)
Route::get('/', [FrontController::class, 'beranda'])->name('beranda');
Route::get('/api/stage-data', [FrontController::class, 'getStageData'])->name('stage.data');
Route::post('/api/stage-timer', [FrontController::class, 'updateTimer'])->name('stage.timer');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'authenticate')->name('login.post');
    Route::post('logout', 'logout')->name('logout');
    Route::get('logout', 'logout')->name('logout.get');
});

// Admin Dashboard & Management Routes
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    // Schools CRUD with DataTables & SweetAlert
    Route::post('/dashboard/schools/{school}/adjust-score', [SchoolsController::class, 'adjustScore'])->name('dashboard.schools.adjust-score');
    Route::post('/dashboard/schools/{school}/set-slot', [SchoolsController::class, 'setSlot'])->name('dashboard.schools.set-slot');
    Route::resource('/dashboard/schools', SchoolsController::class, [
        'names' => 'dashboard.schools',
        'parameters' => ['schools' => 'school']
    ]);

    // Users CRUD with DataTables & SweetAlert
    Route::resource('/dashboard/users', UsersController::class, [
        'names' => 'dashboard.users',
        'parameters' => ['users' => 'user']
    ]);
});