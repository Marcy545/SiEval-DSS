<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBanjir;
use App\Services\FloodScoringService;

class DashboardController extends Controller
{
    public function index()
    {
        $total_kk = LaporanBanjir::sum('jumlah_kk');
        
        // Menghitung berapa RW unik yang sudah melapor
        $rw_melapor = LaporanBanjir::distinct('rw_kelurahan')->count('rw_kelurahan');
        
        // UPDATE: Total 96 RW dari 6 Desa
        $total_rw = 96; 
        $persentase_laporan = $total_rw > 0 ? round(($rw_melapor / $total_rw) * 100) : 0;

        $laporan_all = LaporanBanjir::all();

        // 1. HITUNG TOTAL KERUGIAN EKONOMI
        $total_kerugian = 0;
        foreach ($laporan_all as $laporan) {
            $total_kerugian += FloodScoringService::calculateEconomicLoss($laporan);
        }

        // 2. HITUNG RASIO SEKTOR TERDAMPAK
        $sum_rumah = LaporanBanjir::sum('rumah_tergenang');
        $sum_toko = LaporanBanjir::sum('toko_terdampak');
        $sum_fasum = LaporanBanjir::whereNotNull('fasum_terdampak')->where('fasum_terdampak', '!=', '')->count();

        // 3. DAFTAR FASILITAS UMUM SAJA (Tanpa dikelompokkan per RW di view nanti)
        $list_fasum = LaporanBanjir::whereNotNull('fasum_terdampak')
                        ->where('fasum_terdampak', '!=', '')
                        ->select('fasum_terdampak')
                        ->get();

        $laporan_terbaru = $laporan_all->sortByDesc('priority_score')->take(5);
        $chart_ketinggian = LaporanBanjir::select('rw_kelurahan', 'ketinggian_air')->orderBy('ketinggian_air', 'desc')->take(6)->get();
        $darurat = LaporanBanjir::where('butuh_evakuasi', 'Ya, Mendesak!')->first();

        return view('kecamatan.dashboard', compact(
            'total_kk', 'rw_melapor', 'total_rw', 'persentase_laporan', 
            'laporan_terbaru', 'chart_ketinggian', 'darurat',
            'total_kerugian', 'sum_rumah', 'sum_toko', 'sum_fasum', 'list_fasum'
        ));
    }

    public function show($id)
    {
        $laporan = LaporanBanjir::findOrFail($id);
        $faktor_penentu = FloodScoringService::getDeterminants($laporan);
        $rekomendasi_ai = FloodScoringService::getAiRecommendation($laporan->priority_score, $laporan);

        $loss_raw = FloodScoringService::calculateEconomicLoss($laporan);
        $kerugian_ekonomi = number_format($loss_raw, 0, ',', '.'); 
        $kecepatan_arus = $laporan->ketinggian_air > 120 ? '75%' : ($laporan->ketinggian_air > 60 ? '45%' : '15%');
        $historis_kejadian = "3 Kali dalam setahun terakhir";

        return view('kecamatan.detail_laporan', compact(
            'laporan', 'faktor_penentu', 'rekomendasi_ai', 
            'kerugian_ekonomi', 'kecepatan_arus', 'historis_kejadian'
        ));
    }

    public function history()
    {
        return view('kecamatan.history'); 
    }
}