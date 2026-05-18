<?php

use App\Http\Controllers\AuthController; // Sesuaikan dengan namespace AuthController Hybrid-mu
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetaBanjirController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanBanjirController;
/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Pastikan nama file di resources/views adalah landing.blade.php atau welcome.blade.php
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

    /*
    |--------------------------------------------------------------------------
    | Portal Admin Kecamatan (Camat) ➔ role: kecamatan
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkRole:kecamatan'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('kecamatan.dashboard');
        Route::get('/history', [DashboardController::class, 'history'])->name('kecamatan.history');
        Route::get('/kecamatan/peta-banjir', [PetaBanjirController::class, 'indexCamat'])->name('kecamatan.peta');
        Route::get('/kecamatan/laporan/{id}', [DashboardController::class, 'show'])->name('kecamatan.detail_laporan');
    });

    /*
    |--------------------------------------------------------------------------
    | Portal Warga / Ketua RW ➔ role: rw
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkRole:rw'])->group(function () {
        Route::get('/rw/laporan', [LaporanBanjirController::class, 'create'])->name('rw.laporan.create');
    
    // Rute POST untuk memproses pengiriman data form laporan
    Route::post('/rw/laporan', [LaporanBanjirController::class, 'store'])->name('rw.laporan.store');
    });
});