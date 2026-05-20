<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER ACTIONS
    |--------------------------------------------------------------------------
    */

    public function showRegister(Request $request)
    {
        // default role = rw
        $role = $request->query('role', 'rw');

        return view('auth.register', compact('role'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'rw_desa'  => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'required|numeric|digits_between:10,14',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'
            ],
        ], [
            'rw_desa.required'      => 'Nama wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'no_hp.numeric'         => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between'  => 'Nomor HP harus 10-14 digit.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.regex'        => 'Password wajib kombinasi huruf dan angka.',
        ]);

        User::create([
            'name'     => $request->rw_desa,
            'rw_desa'  => $request->rw_desa,
            'role'     => $request->role ?? 'rw',
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login', [
            'role' => $request->role ?? 'rw'
        ])->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN ACTIONS
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request)
    {
        $role = $request->query('role', 'rw');

        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $loginAs = $request->query('role', $request->input('role'));

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            $user = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | PROTEKSI ROLE
            |--------------------------------------------------------------------------
            */

            if ($loginAs && $user->role !== $loginAs) {

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $targetLabel = $loginAs === 'rw'
                    ? 'Ketua RW'
                    : 'Kecamatan';

                return redirect()->route('login', [
                    'role' => $loginAs
                ])->with(
                    'error',
                    "Akun Anda tidak terdaftar sebagai {$targetLabel}."
                );
            }

            $request->session()->regenerate();

            /*
            |--------------------------------------------------------------------------
            | REDIRECT BERDASARKAN ROLE
            |--------------------------------------------------------------------------
            */

            if ($user->role === 'kecamatan') {

                return redirect()->route('kecamatan.dashboard');
            }

            if ($user->role === 'rw') {

                return redirect()->route('rw.laporan.create');
            }

            // fallback
            return redirect('/');
        }

        return back()->with(
            'error',
            'Email atau password salah!'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $role = Auth::check()
            ? Auth::user()->role
            : 'rw';

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login', [
            'role' => $role
        ]);
    }
}