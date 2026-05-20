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
    | REGISTER ACTIONS (HANYA UNTUK KETUA RW)
    |--------------------------------------------------------------------------
    */
    
    public function showRegister()
    {
        return view('auth.register', ['role' => 'rw']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'rw_desa'  => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|digits:6',
        ], [
            'rw_desa.required'  => 'Nama lengkap RW & Desa wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.digits'   => 'Password harus 6 digit angka.',
        ]);

        User::create([
            'name'     => $request->rw_desa,
            'rw_desa'  => $request->rw_desa,
            'role'     => 'rw',
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login', ['role' => 'rw'])
            ->with('success', 'Registrasi RW berhasil! Silakan login.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN ACTIONS (BISA RW, BISA KECAMATAN)
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request)
    {
        $role = $request->query('role', 'rw');
        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        // 1. Validasi Input Form
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $loginAs = $request->query('role', $request->input('role'));
        
        // 2. Tangkap status checkbox 'Remember Me'
        $remember = $request->has('remember'); 

        // 3. Proses Autentikasi Utama
        if (Auth::attempt($credentials, $remember)) {
            
            $user = Auth::user();

            // 4. Proteksi Cross-Role (Mencegah RW masuk portal Kecamatan & sebaliknya)
            if ($loginAs && $user->role !== $loginAs) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $targetLabel = $loginAs === 'rw' ? 'Ketua RW' : 'Kecamatan';
                return redirect()->route('login', ['role' => $loginAs])
                    ->with('error', "Akun Anda tidak terdaftar sebagai $targetLabel.");
            }

            // 5. Regenerasi session dilakukan setelah proteksi role aman
            $request->session()->regenerate();

            // 6. Pengalihan rute menggunakan Route Name absolut sesuai role
            if ($user->role === 'kecamatan') {
                return redirect()->route('kecamatan.dashboard');
            }
            
            // --- PERUBAHAN DI SINI ---
            // Jika role adalah 'rw', redirect dialihkan langsung ke form laporan warga
            return redirect()->route('rw.laporan.create');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT ACTION
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $role = Auth::check() ? Auth::user()->role : 'rw'; 

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login', ['role' => $role]);
    }
}