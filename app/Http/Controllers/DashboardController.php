<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBanjir;
use App\Services\FloodScoringService;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL KK
        |--------------------------------------------------------------------------
        */

        $total_kk = LaporanBanjir::sum('jumlah_kk');

        /*
        |--------------------------------------------------------------------------
        | RW MELAPOR
        |--------------------------------------------------------------------------
        */

        $rw_melapor = LaporanBanjir::distinct('rw_kelurahan')
            ->count('rw_kelurahan');

        $total_rw = 96;

        $persentase_laporan =
            $total_rw > 0
            ? round(($rw_melapor / $total_rw) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | AMBIL LAPORAN + SCORING
        |--------------------------------------------------------------------------
        */

        $laporan_all = LaporanBanjir::all()->map(function ($laporan) {

            $laporan->priority_score =
                FloodScoringService::calculateScore($laporan);

            $laporan->priority_label =
                FloodScoringService::getLabel(
                    $laporan->priority_score
                );

            return $laporan;
        });

        /*
        |--------------------------------------------------------------------------
        | TOTAL KERUGIAN
        |--------------------------------------------------------------------------
        */

        $total_kerugian = 0;

        foreach ($laporan_all as $laporan) {

            $total_kerugian +=
                FloodScoringService::calculateEconomicLoss($laporan);
        }

        /*
        |--------------------------------------------------------------------------
        | SEKTOR TERDAMPAK
        |--------------------------------------------------------------------------
        */

        $sum_rumah = LaporanBanjir::sum('rumah_tergenang');

        $sum_toko = LaporanBanjir::sum('toko_terdampak');

        $sum_fasum = LaporanBanjir::whereNotNull('fasum_terdampak')
            ->where('fasum_terdampak', '!=', '')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | LIST FASUM
        |--------------------------------------------------------------------------
        */

        $list_fasum = LaporanBanjir::whereNotNull('fasum_terdampak')
            ->where('fasum_terdampak', '!=', '')
            ->select('fasum_terdampak')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP PRIORITAS
        |--------------------------------------------------------------------------
        */

        $laporan_terbaru = $laporan_all
            ->sortByDesc('priority_score')
            ->take(5);

        /*
        |--------------------------------------------------------------------------
        | CHART
        |--------------------------------------------------------------------------
        */

        $chart_ketinggian = $laporan_all
            ->sortByDesc('ketinggian_air')
            ->take(6);

        /*
        |--------------------------------------------------------------------------
        | DARURAT PALING TINGGI
        |--------------------------------------------------------------------------
        */

        $darurat = $laporan_all
            ->sortByDesc('priority_score')
            ->first();

        return view('kecamatan.dashboard', compact(

            'total_kk',
            'rw_melapor',
            'total_rw',
            'persentase_laporan',

            'laporan_terbaru',
            'chart_ketinggian',
            'darurat',

            'total_kerugian',

            'sum_rumah',
            'sum_toko',
            'sum_fasum',

            'list_fasum'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL LAPORAN BANJIR (DENGAN INTEGRASI WHATSAPP)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        // Ambil data laporan berdasarkan ID
        $laporan = LaporanBanjir::findOrFail($id);

        // Hitung scoring pendukung
        $laporan->priority_score = FloodScoringService::calculateScore($laporan);
        $laporan->priority_label = FloodScoringService::getLabel($laporan->priority_score);
        $laporan->total_kerugian = FloodScoringService::calculateEconomicLoss($laporan);

        // --- FORMAT NOMOR WHATSAPP RW ---
        $nomorWa = optional($laporan->user)->no_hp;

        if ($nomorWa) {
            // Bersihin selain angka
            $nomorWa = preg_replace('/[^0-9]/', '', $nomorWa);

            // Ubah format 08xxxx jadi 628xxxx
            if (substr($nomorWa, 0, 1) == '0') {
                $nomorWa = '62' . substr($nomorWa, 1);
            }

            $pesanWa = urlencode(
                "Halo Ketua RW {$laporan->rw_kelurahan}, kami dari Kecamatan Bojongsoang menerima laporan banjir dengan status {$laporan->priority_label}. Mohon segera memberikan update kondisi terbaru di lokasi."
            );

            $linkWa = "https://wa.me/{$nomorWa}?text={$pesanWa}";
        } else {
            $linkWa = null;
        }

        // Generate variabel $rekomendasi_ai berdasarkan database ATAU status keparahannya (fallback)
        if (isset($laporan->rekomendasi_ai) && !empty($laporan->rekomendasi_ai)) {
            $rekomendasi_ai = $laporan->rekomendasi_ai;
        } else {
            if ($laporan->priority_label === 'KRITIS' || $laporan->priority_label === 'PARAH') {
                $rekomendasi_ai = [
                    'evakuasi' => 'Segera kerahkan perahu karet ke lokasi rujukan utama. Prioritaskan evakuasi lansia, anak-anak, dan wanita hamil ke posko terdekat.',
                    'rekomendasi' => 'Hubungi BPBD Kabupaten Bandung untuk bantuan personel logistik tambahan.'
                ];
            } elseif ($laporan->priority_label === 'SEDANG') {
                $rekomendasi_ai = [
                    'evakuasi' => 'Siagakan tim evakuasi internal kelurahan/kecamatan di sekitar area genangan air untuk memantau pergerakan debit air.',
                    'rekomendasi' => 'Persiapkan dapur umum mandiri dan pastikan jalur evakuasi bebas hambatan.'
                ];
            } else {
                $rekomendasi_ai = [
                    'evakuasi' => 'Pantau berkala ketinggian air melalui koordinasi intensif bersama ketua RW setempat.',
                    'rekomendasi' => 'Imbau warga untuk mengamankan dokumen penting ke tempat yang lebih tinggi.'
                ];
            }
        }

        // Kembalikan ke view lengkap dengan variabel pendukung WhatsApp agar tidak eror undefined
        return view('kecamatan.detail_laporan', compact('laporan', 'rekomendasi_ai', 'nomorWa', 'linkWa'));
    }
}