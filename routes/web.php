<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetaBanjirController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Group untuk RW / Kecamatan
    Route::middleware(['checkRole:rw'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/history', [DashboardController::class, 'history'])->name('history');
        Route::get('/rw/peta-banjir', [PetaBanjirController::class, 'indexRW'])->name('peta');
    });

    // Group untuk Warga
    Route::middleware(['checkRole:warga'])->group(function () {
        Route::get('/peta-banjir', [PetaBanjirController::class, 'indexWarga'])->name('warga.peta');
    });
});