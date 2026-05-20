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
        
        $rwData = $this->getFloodData();

        // Mengarah ke resources/views/warga/peta.blade.php sesuai screenshot folder kamu
        return view('warga.peta', compact('rwData'));
    }

    // Portal Peta untuk Camat / Kecamatan
    public function indexCamat()
    {
        // Ambil semua laporan yang memiliki titik koordinat valid
        $laporan_banjir = LaporanBanjir::whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->get();

        // Oper data laporan ke file tampilan blade (Heatmap Map)
        return view('kecamatan.peta', compact('laporan_banjir'));
    }

    // Data Dummy Laporan Banjir Bojongsoang
    private function getFloodData()
    {
        return [
            ['id' => '07', 'nama' => 'Cipagalo', 'status' => 'PARAH', 'kk' => 120, 'tinggi' => 180, 'color' => 'red'],
            ['id' => '12', 'nama' => 'Lengkong', 'status' => 'PARAH', 'kk' => 120, 'tinggi' => 130, 'color' => 'red'],
            ['id' => '13', 'nama' => 'Bojongsari', 'status' => 'SEDANG', 'kk' => 120, 'tinggi' => 80, 'color' => 'orange'],
        ];
    }
}