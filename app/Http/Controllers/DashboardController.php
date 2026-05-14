<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Method untuk Route::get('/dashboard')
    public function index()
    {
        return view('dashboard'); 
    }

    // Method untuk Route::get('/history')
    public function history()
    {
        return view('history'); // Pastikan file ini ada
    }
}