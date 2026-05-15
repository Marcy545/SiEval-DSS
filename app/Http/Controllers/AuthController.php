<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        // Menangkap parameter ?role= dari URL (default ke 'warga')
        $role = $request->query('role', 'warga');
        return view('auth.register', compact('role'));
    }

    public function register(Request $request)
    {
        // Validasi dinamis berdasarkan role yang dipilih
        $request->validate([
            'role' => 'required|in:warga,rw',
            'name' => 'required_if:role,warga',
            'rw_desa' => 'required_if:role,rw',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|digits:6',
        ], [
            'name.required_if' => 'Nama lengkap wajib diisi.',
            'rw_desa.required_if' => 'Nama RW dan Desa wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.digits' => 'Password harus 6 digit angka.',
        ]);

        // Simpan data dengan logika: jika RW, maka name diisi dengan nilai rw_desa
        User::create([
        'name' => $request->role === 'warga' ? $request->name : $request->rw_desa,
        'rw_desa' => $request->role === 'rw' ? $request->rw_desa : null,
        'role' => $request->role,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);

        // Redirect ke login dengan parameter role agar UI login otomatis menyesuaikan
        return redirect()->route('login', ['role' => $request->role])
        ->with('success', 'Registrasi berhasil, silakan login sebagai ' . ($request->role === 'rw' ? 'Kecamatan' : 'Warga'));
    }

    public function showLogin(Request $request)
    {
        $role = $request->query('role', 'warga');
        return view('auth.login', compact('role'));
    }

// app/Http/Controllers/AuthController.php

    public function login(Request $request)
    {
        // 1. Validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil parameter role dari hidden input atau URL (?role=)
        $loginAs = $request->query('role', $request->input('role'));

        // 2. Coba autentikasi email & password
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 3. VALIDASI CROSS-ROLE: Cek apakah role akun cocok dengan pintu login
            if ($loginAs && $user->role !== $loginAs) {
                // Jika tidak cocok, paksa logout dan kembalikan ke login dengan pesan error
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $targetLabel = $loginAs === 'rw' ? 'Kecamatan' : 'Warga';
                return redirect()->route('login', ['role' => $loginAs])
                    ->with('error', "Akun Anda tidak terdaftar sebagai $targetLabel. Silakan gunakan pintu login yang sesuai.");
            }

            // 4. Jika cocok, regenerasi session dan arahkan ke dashboard masing-masing
            $request->session()->regenerate();

            if ($user->role === 'rw') {
                return redirect()->intended('/dashboard');
            }
            
            return redirect()->intended('/peta-banjir');
        }

        // Jika email/password salah
        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        // 1. Simpan role ke variabel sebelum logout
        $role = auth()->user()->role; 

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 2. Redirect ke route login dengan parameter role
        return redirect()->route('login', ['role' => $role]);
    }
}