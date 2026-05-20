<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBanjir;
use Illuminate\Support\Facades\Auth;

class LaporanBanjirController extends Controller
{
    // Menampilkan halaman form input laporan banjir warga
    public function create()
    {
        // Mengambil data role user yang sedang login untuk layout header
        $role = Auth::check() ? Auth::user()->role : 'rw';
        return view('warga.form_laporan', compact('role'));
    }

    // Memproses penyimpanan data form ke database
    public function store(Request $request)
    {
        // 1. Validasi Input Form secara ketat
        $request->validate([
            'rw_kelurahan'       => 'required|string|max:255',
            'status_banjir'      => 'required|string',
            'ketinggian_air'     => 'required|numeric|min:0',
            'durasi_banjir'      => 'required|string',
            'penyebab'           => 'required|string',
            'jumlah_kk'          => 'required|numeric|min:0',
            'jumlah_jiwa'        => 'required|numeric|min:0',
            'butuh_evakuasi'     => 'required|string',
            'jumlah_lansia'      => 'nullable|numeric|min:0',
            'jumlah_bayi_bumil'  => 'nullable|numeric|min:0',
            'rumah_tergenang'    => 'required|numeric|min:0',
            'tingkat_keparahan'  => 'required|string',
            'toko_terdampak'     => 'nullable|numeric|min:0',
            'fasum_terdampak'    => 'nullable|string',
            'latitude'           => 'required|numeric',
            'longitude'          => 'required|numeric',
            'dokumentasi'        => 'nullable|array|max:3', 
            'dokumentasi.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' 
        ]);

        // 2. Handling Upload Multi-Foto Dokumentasi
        $fotoSaved = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                if ($file->isValid()) {
                    $namaFoto = 'sieval_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->storeAs('laporan_banjir', $namaFoto);
                    $fotoSaved[] = $namaFoto;
                }
            }
        }

        // =====================================================================
        // 🔥 LOGIKA INTEGRASI DECISION SUPPORT SYSTEM (DSS) SCORING
        // =====================================================================
        
        // Parameter 1: Ketinggian Air (Bobot Maksimal: 40 Poin)
        // Aturan: Tinggi air >= 150cm otomatis dapat 40 poin maksimal. Jika dibawahnya, proporsional.
        $score_air = ($request->ketinggian_air >= 150) ? 40 : (($request->ketinggian_air / 150) * 40);

        // Parameter 2: Dampak Kepadatan KK Terdampak (Bobot Maksimal: 30 Poin)
        // Aturan: Jika KK terdampak >= 100 KK, dapat 30 poin maksimal.
        $score_kk = ($request->jumlah_kk >= 100) ? 30 : (($request->jumlah_kk / 100) * 30);

        // Parameter 3: Urgensi Kebutuhan Evakuasi Warga (Bobot Maksimal: 20 Poin)
        // Aturan: Jika form RW memilih "Ya", langsung tambah beban krisis 20 poin.
        $score_evakuasi = (strtolower($request->butuh_evakuasi) === 'ya') ? 20 : 0;

        // Parameter 4: Dampak Kelumpuhan Fasilitas Umum (Bobot Maksimal: 10 Poin)
        // Aturan: Jika kolom fasum diisi teks (ada fasum tergenang), berikan 10 poin krisis tambahan.
        $score_fasum = 0;
        if (!empty($request->fasum_terdampak)) {
            // Pecah koma untuk menghitung berapa banyak fasilitas umum yang lumpuh
            $jumlah_fasum = count(explode(',', $request->fasum_terdampak));
            $score_fasum = ($jumlah_fasum >= 2) ? 10 : 5;
        }

        // Akumulasikan seluruh variabel pembobotan menjadi nilai persentase final (Max 100)
        $total_priority_score = round($score_air + $score_kk + $score_evakuasi + $score_fasum);
        if ($total_priority_score > 100) { $total_priority_score = 100; }

        // =====================================================================

        // 3. Masukkan Seluruh Data ke Database (Termasuk Kolom Skor Hasil Perhitungan)
        LaporanBanjir::create([
            'user_id'           => Auth::id(), 
            'rw_kelurahan'      => $request->rw_kelurahan,
            'status_banjir'     => $request->status_banjir,
            'ketinggian_air'    => $request->ketinggian_air,
            'durasi_banjir'     => $request->durasi_banjir,
            'penyebab'          => $request->penyebab,
            'jumlah_kk'         => $request->jumlah_kk,
            'jumlah_jiwa'       => $request->jumlah_jiwa,
            'butuh_evakuasi'    => $request->butuh_evakuasi,
            'jumlah_lansia'     => $request->jumlah_lansia ?? 0,
            'jumlah_bayi_bumil' => $request->jumlah_bayi_bumil ?? 0,
            'rumah_tergenang'   => $request->rumah_tergenang,
            'tingkat_keparahan' => $request->tingkat_keparahan,
            'toko_terdampak'    => $request->toko_terdampak ?? 0,
            'fasum_terdampak'   => $request->fasum_terdampak,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'dokumentasi'       => $fotoSaved,
            
            // ⚠️ PASTIKAN nama properti ini sesuai dengan nama kolom priority score di database kamu!
            'priority_score'    => $total_priority_score 
        ]);

        // 4. Redirect kembali dengan Flash Message sukses
        return redirect()->back()->with('success', 'Laporan banjir berhasil dikirim dan dianalisis oleh AI Kecamatan Bojongsoang!');
    }
}