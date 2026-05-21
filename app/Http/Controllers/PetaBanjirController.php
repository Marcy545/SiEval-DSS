<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanBanjir;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaBanjirController extends Controller
{
    // Portal Peta untuk Ketua RW
    public function indexRW()
    {
        // TIDAK PERLU Cek Auth::user()->role lagi di sini, sudah dijaga oleh Middleware!
        
        // Mengarah ke resources/views/warga/peta.blade.php sesuai screenshot folder kamu
        return view('warga.peta');
    }

    // Portal Peta untuk Camat / Kecamatan
    public function indexCamat(Request $request)
    {
        // Mulai kueri awal: Ambil semua laporan yang memiliki titik koordinat valid
        $query = LaporanBanjir::whereNotNull('latitude')
                              ->whereNotNull('longitude');

        // =========================================================
        // 🔥 LOGIKA FILTERING TANGGAL, BULAN, DAN TAHUN
        // =========================================================
        
        // 1. Filter Tanggal / Hari (1 - 31)
        if ($request->filled('tanggal') && $request->tanggal !== 'all') {
            $query->whereDay('created_at', $request->tanggal);
        }

        // 2. Filter Bulan (1 - 12)
        if ($request->filled('bulan') && $request->bulan !== 'all') {
            $query->whereMonth('created_at', $request->bulan);
        }

        // 3. Filter Tahun (2025, 2026, dst)
        if ($request->filled('tahun') && $request->tahun !== 'all') {
            $query->whereYear('created_at', $request->tahun);
        }

        // Eksekusi Kueri
        $laporan_banjir = $query->get();

        // Oper data laporan ke file tampilan blade (Heatmap Map)
        return view('kecamatan.peta', compact('laporan_banjir'));
    }
}