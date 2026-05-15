<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VIEW LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

public function register(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI RW DESA
    |--------------------------------------------------------------------------
    */

    if (!$request->rw_desa) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'RW dan Desa wajib diisi'
            ], 422);
        }

        return back()->withErrors([
            'message' => 'RW dan Desa wajib diisi'
        ])->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI EMAIL
    |--------------------------------------------------------------------------
    */

    if (!$request->email) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Email wajib diisi'
            ], 422);
        }

        return back()->withErrors([
            'message' => 'Email wajib diisi'
        ])->withInput();
    }

    if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Format email tidak valid'
            ], 422);
        }

        return back()->withErrors([
            'message' => 'Format email tidak valid'
        ])->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL SUDAH ADA
    |--------------------------------------------------------------------------
    */

    $checkEmail = User::where('email', $request->email)->first();

    if ($checkEmail) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Email sudah terdaftar'
            ], 409);
        }

        return back()->withErrors([
            'message' => 'Email sudah terdaftar'
        ])->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI PASSWORD
    |--------------------------------------------------------------------------
    */

    if (!$request->password) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Password wajib diisi'
            ], 422);
        }

        return back()->withErrors([
            'message' => 'Password wajib diisi'
        ])->withInput();
    }

    if (!preg_match('/^[0-9]{6}$/', $request->password)) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Password harus 6 digit angka'
            ], 422);
        }

        return back()->withErrors([
            'message' => 'Password harus 6 digit angka'
        ])->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER BERHASIL
    |--------------------------------------------------------------------------
    */

    $user = User::create([

        'rw_desa' => $request->rw_desa,

        'email' => $request->email,

        'password' => Hash::make($request->password),

    ]);

    /*
    |--------------------------------------------------------------------------
    | RESPONSE API
    |--------------------------------------------------------------------------
    */

    if ($request->is('api/*')) {

        return response()->json([

            'success' => true,

            'message' => 'Register berhasil',

            'data' => $user

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSE WEB
    |--------------------------------------------------------------------------
    */

    return redirect('/login')
        ->with('success', 'Register berhasil');
}

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI EMAIL
        |--------------------------------------------------------------------------
        */

        if (!$request->email) {

            return back()->with('error', 'Email wajib diisi');
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

            return back()->with('error', 'Format email tidak valid');
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PASSWORD
        |--------------------------------------------------------------------------
        */

        if (!$request->password) {

            return back()->with('error', 'Password wajib diisi');
        }

        if (!preg_match('/^[0-9]{6}$/', $request->password)) {

            return back()->with('error', 'Password harus 6 digit angka');
        }

        /*
        |--------------------------------------------------------------------------
        | CEK EMAIL
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return back()->with('error', 'Email tidak terdaftar');
        }

        /*
        |--------------------------------------------------------------------------
        | CEK PASSWORD
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->password, $user->password)) {

            return back()->with('error', 'Password salah');
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN BERHASIL
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        /*
        |--------------------------------------------------------------------------
        | RESPONSE API
        |--------------------------------------------------------------------------
        */

        if ($request->is('api/*')) {

            return response()->json([

                'success' => true,

                'message' => 'Login berhasil',

                'data' => $user

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE WEB
        |--------------------------------------------------------------------------
        */

        return redirect('/dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        if ($request->is('api/*')) {

            return response()->json([

                'success' => true,

                'message' => 'Logout berhasil'

            ], 200);
        }

        return redirect('/login');
    }
}