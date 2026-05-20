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
    | VIEW LOGIN & REGISTER (Hanya Web)
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request)
    {
        // Default pintu login sekarang adalah 'rw'
        $role = $request->query('role', 'rw'); 
        return view('auth.login', compact('role'));
    }

    public function showRegister()
    {
        // Register murni hanya untuk role 'rw'
        return view('auth.register', ['role' => 'rw']);
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER (HYBRID) - KHUSUS KETUA RW
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        // 1. Validasi Otomatis (Camat sudah tidak ada di sini)
        $request->validate([
            'rw_desa'  => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|digits:6|regex:/^[0-9]{6}$/',
        ], [
            'rw_desa.required'  => 'Nama lengkap RW & Desa wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.digits'   => 'Password harus 6 digit angka.',
            'password.regex'    => 'Password hanya boleh berisi angka.',
        ]);

        // 2. Simpan Data (Otomatis role dikunci menjadi 'rw')
        $user = User::create([
            'name'     => $request->rw_desa,
            'rw_desa'  => $request->rw_desa,
            'role'     => 'rw',
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Response API
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Registrasi RW berhasil',
                'data'    => $user
            ], 201);
        }

        // 4. Response Web
        return redirect()->route('login', ['role' => 'rw'])
            ->with('success', 'Registrasi RW berhasil, silakan login.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN (HYBRID)
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Cek User & Password
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah'
                ], 401);
            }
            return back()->with('error', 'Email atau password salah')->withInput();
        }

        // 3. Validasi Pintu Masuk Role (Cross-Role Protection)
        $loginAs = $request->query('role', $request->input('role'));
        
        if ($loginAs && $user->role !== $loginAs) {
            $targetLabel = $loginAs === 'rw' ? 'Warga / Ketua RW' : 'Camat / Kecamatan';
            $errorMsg = "Akun Anda tidak terdaftar sebagai $targetLabel.";
            
            if ($request->is('api/*')) {
                return response()->json(['success' => false, 'message' => $errorMsg], 403);
            }
            return back()->with('error', $errorMsg)->withInput();
        }

        // 4. Response API (Menggunakan Token Sanctum)
        if ($request->is('api/*')) {
            // Hapus token lama agar tidak menumpuk
            $user->tokens()->delete(); 
            
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success'      => true,
                'message'      => 'Login berhasil',
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'data'         => $user
            ], 200);
        }

        // 5. Response Web (Menggunakan Session)
        Auth::login($user);
        $request->session()->regenerate();

        // Pengalihan berdasarkan role terbaru
        if ($user->role === 'kecamatan') {
            return redirect()->intended('/dashboard'); // Camat diarahkan ke Dashboard
        }
        
        return redirect()->intended('/peta-banjir'); // Ketua RW diarahkan ke Peta Banjir
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT (HYBRID)
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        // 1. Response API (Hapus Token)
        if ($request->is('api/*')) {
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ], 200);
        }

        // 2. Response Web (Hapus Session)
        $role = Auth::check() ? Auth::user()->role : 'rw';
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login', ['role' => $role]);
    }
}