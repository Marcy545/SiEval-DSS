<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Pengaman pertama: Jika belum login, tendang ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Pengaman kedua: Jika role user ada di dalam daftar yang diizinkan rute, LOLOSKAN!
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 3. JIKA SALAH KAMAR (User memaksa masuk ke rute yang bukan haknya)
        // Kita kunci arah kembalinya secara statis dan absolut berdasarkan role di DB:
        $userRole = Auth::user()->role;

        if ($userRole === 'kecamatan') {
            // Jika Camat tersesat ke halaman RW, kembalikan ke /dashboard
            return redirect('/dashboard')->with('error', 'Akses ditolak. Anda tidak diizinkan membuka halaman tersebut.');
        }

        if ($userRole === 'rw') {
            // Jika RW tersesat ke halaman Camat, kembalikan ke /laporan
            return redirect('/laporan')->with('error', 'Akses ditolak. Halaman tersebut khusus untuk Admin Kecamatan.');
        }

        // Fallback terakhir jika ada role tak dikenal
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}