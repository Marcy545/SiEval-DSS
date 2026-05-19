<?php

use App\Http\Controllers\AuthController; // Sesuaikan dengan namespace AuthController Hybrid-mu
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetaBanjirController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanBanjirController;
use App\Http\Controllers\PasswordResetController;


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
        Route::get('/kecamatan/laporan/foto/{filename}', [DashboardController::class, 'showFoto'])->name('kecamatan.laporan.foto');
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

// 1. Step Input Email Lupa Password
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// 1. Halaman Input OTP (Method: GET) -> URL pakai /verify-otp/...
Route::get('/verify-otp/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

// 2. Aksi Cek Validasi OTP (Method: POST) -> UBAH URL-nya menjadi /submit-otp-verification
Route::post('/submit-otp-verification', [PasswordResetController::class, 'verifyOtp'])->name('password.verify');

// 3. Halaman Form Pengisian Password Baru (Method: GET)
Route::get('/reset-password-form', [PasswordResetController::class, 'showNewPasswordForm'])->name('password.new_form');

// 5. Eksekusi Penggantian Password Baru ke Database (POST)
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');