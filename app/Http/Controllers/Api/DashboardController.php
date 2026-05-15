<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD VIEW
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        return view('dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORY VIEW
    |--------------------------------------------------------------------------
    */

    public function history()
    {
        return view('history');
    }
}