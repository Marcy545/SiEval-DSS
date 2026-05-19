<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\SendOtpResetPassword;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // 1. Menampilkan halaman Lupa Password (Input Email)
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Aksi generate 6 digit OTP dan mengirimkannya via Brevo (Notification)
    public function sendResetLink(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.exists' => 'Alamat email tidak terdaftar di sistem SiEval.'
            ]
        );

        // Generate 6 digit angka acak untuk kode OTP
        $otp = rand(100000, 999999);

        // Bersihkan data OTP lama milik email tersebut jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Simpan OTP yang di-hash ke database demi keamanan data
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($otp), 
            'created_at' => Carbon::now()
        ]);

        // Ambil data user, lalu kirim email OTP via Brevo menggunakan Notification
        $user = User::where('email', $request->email)->first();
        $user->notify(new SendOtpResetPassword($otp));

        // PENTING: Pindahkan email ke session flash biasa agar bertahan sampai form OTP di-submit
        $request->session()->put('reset_email', $request->email);

        // Redirect ke route input OTP
        return redirect()->route('password.reset', ['token' => 'verification'])
            ->with('status', 'Kode OTP berhasil dikirim ke Gmail Anda!');
    }

    // 3. Menampilkan halaman Verifikasi OTP (otp.blade.php)
    public function showResetForm(Request $request, $token)
    {
        // Mengambil email dari session flash (bawaan redirect) atau request query biasa
        $email = session('reset_email') ?? $request->email;

        return view('auth.otp', [
            'token' => $token, 
            'email' => $email
        ]);
    }

    // 4. Aksi Cek Validasi OTP (Proses POST dari halaman OTP)
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|digits:6', // PASTIKAN DI SINI KEMBALI KELIHAN 6 DIGIT
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus berjumlah 6 digit angka.',
            'email.exists' => 'Sesi email tidak valid.',
        ]);

        // Ambil record OTP dari database
        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // Validasi 1: OTP cocok atau tidak
        if (!$record || !Hash::check($request->otp, $record->token)) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah atau tidak valid.']);
        }

        // Validasi 2: Masa kedaluwarsa (15 menit)
        $isExpired = Carbon::parse($record->created_at)->addMinutes(15)->isPast();
        if ($isExpired) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        // OTP SUKSES: Simpan data verifikasi ke session agar aman dari manipulasi URL
        $request->session()->put('otp_verified_email', $request->email);
        $request->session()->put('otp_verified_token', $request->token);

        // Alihkan (Redirect) menggunakan method GET ke halaman form password baru
        return redirect()->route('password.new_form');
    }

    // 5. Menampilkan halaman Buat Password Baru (Pemisah method GET agar tidak error)
    public function showNewPasswordForm()
    {
        // Proteksi keamanan: Jika belum lolos verifikasi OTP, tendang balik ke awal
        if (!session()->has('otp_verified_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan lakukan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.reset-password', [
            'token' => session('otp_verified_token'),
            'email' => session('otp_verified_email')
        ]);
    }

    // 6. Aksi final update password baru ke database
// 6. Aksi final update password baru ke database
    public function updatePassword(Request $request)
    {
        // 1. Ambil email langsung dari session sukses OTP kemarin
        $email = session('otp_verified_email');

        // Proteksi jika session hilang atau di-refresh paksa
        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi reset password Anda telah habis. Silakan ulangi dari input email.']);
        }

        // 2. Validasi input password saja (Tidak perlu validasi email & OTP lagi)
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.regex' => 'Password harus berupa kombinasi huruf dan angka.',
        ]);

        // 3. Tarik data user berdasarkan email dari session
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['password' => 'User dengan email tersebut tidak ditemukan di sistem.']);
        }

        // 4. Eksekusi simpan password baru ter-hash ke DB
        $user->password = Hash::make($request->password);
        $user->save(); // <--- Ini yang akan memastikan data masuk ke DB

        // 5. Hapus token/OTP lama di tabel password_resets agar tidak bisa dipakai lagi
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // 6. Bersihkan seluruh sisa session OTP
        session()->forget(['otp_verified_email', 'otp_verified_token', 'reset_email']);

        // 7. Lempar ke halaman login dengan pesan sukses banner hijau
        return redirect()->route('login')->with('status', 'Password Anda sukses diperbarui! Silakan login.');
    }
}