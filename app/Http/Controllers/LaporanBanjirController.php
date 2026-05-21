<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBanjir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;  
use Illuminate\Support\Facades\Storage; 

class LaporanBanjirController extends Controller
{
    // Menampilkan halaman form input laporan banjir warga
    public function create()
    {
        $role = Auth::check() ? Auth::user()->role : 'rw';
        return view('warga.form_laporan', compact('role'));
    }

    // Memproses penyimpanan data form ke database
    public function store(Request $request)
    {
        // 1. Validasi Input Form secara ketat (rw_kelurahan dihapus karena kita ambil via session Auth)
        $request->validate([
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
        
        $score_air = ($request->ketinggian_air >= 150) ? 40 : (($request->ketinggian_air / 150) * 40);
        $score_kk = ($request->jumlah_kk >= 100) ? 30 : (($request->jumlah_kk / 100) * 30);
        $score_evakuasi = (strtolower($request->butuh_evakuasi) === 'ya') ? 20 : 0;
        
        $score_fasum = 0;
        if (!empty($request->fasum_terdampak)) {
            $jumlah_fasum = count(explode(',', $request->fasum_terdampak));
            $score_fasum = ($jumlah_fasum >= 2) ? 10 : 5;
        }

        $total_priority_score = round($score_air + $score_kk + $score_evakuasi + $score_fasum);
        if ($total_priority_score > 100) { $total_priority_score = 100; }

        // ====================================================================
        // 🧠 AI ANOMALY DETECTION INTEGRATION (FASTAPI PYTHON)
        // ====================================================================
        $isAnomaly = false; 
        
        try {
            $aiResponse = Http::timeout(5)->post('http://127.0.0.1:8001/predict_anomaly', [
                'ketinggian_air'  => (int) $request->ketinggian_air,
                'jumlah_kk'       => (int) $request->jumlah_kk,
                'jumlah_jiwa'     => (int) $request->jumlah_jiwa,
                'jumlah_lansia'   => (int) ($request->jumlah_lansia ?? 0),
                'jumlah_bayi'     => (int) ($request->jumlah_bayi_bumil ?? 0),
                'rumah_tergenang' => (int) ($request->rumah_tergenang ?? 0),
            ]);

            if ($aiResponse->successful()) {
                $isAnomaly = $aiResponse->json('is_anomaly');
            }
        } catch (\Exception $e) {
            Log::error('AI Anomaly API Error: ' . $e->getMessage());
        }

        // =====================================================================

        // 3. Masukkan Seluruh Data ke Database (rw_kelurahan otomatis mengunci nama user login)
        LaporanBanjir::create([
            'user_id'           => Auth::id(), 
            'rw_kelurahan'      => Auth::user()->name, // 🔥 AUTO LOCK DARI NAMA AKUN REGISTRASI
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
            
            'priority_score'    => $total_priority_score,
            'is_anomaly'        => $isAnomaly 
        ]);

        return redirect()->back()->with('success', 'Laporan banjir berhasil dikirim dan dianalisis oleh AI Kecamatan Bojongsoang!');
    }

    // =====================================================================
    // 🔥 FUNGSI HAPUS LAPORAN (HARD DELETE)
    // =====================================================================

    // 1. Fungsi Hapus Satuan
    public function hapus($id)
    {
        $laporan = LaporanBanjir::findOrFail($id);

        // Hapus fisik foto dokumentasi dari server jika ada
        if (!empty($laporan->dokumentasi)) {
            foreach ($laporan->dokumentasi as $foto) {
                Storage::delete('laporan_banjir/' . $foto);
            }
        }

        // Hapus data dari MySQL secara permanen
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus secara permanen dari sistem!');
    }

    // 2. Fungsi Pembersihan Berkala (Hapus Massal)
    public function hapusBerkala(Request $request)
    {
        // Validasi input bulan dan tahun
        $request->validate([
            'bulan' => 'required|numeric|between:1,12',
            'tahun' => 'required|numeric',
        ]);

        // Cari semua laporan yang cocok dengan bulan dan tahun pilihan
        $laporans = LaporanBanjir::whereYear('created_at', $request->tahun)
                                 ->whereMonth('created_at', $request->bulan)
                                 ->get();

        if ($laporans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ditemukan data laporan pada periode bulan dan tahun tersebut.');
        }

        // Loop untuk menghapus foto dan baris data masing-masing laporan
        foreach ($laporans as $laporan) {
            if (!empty($laporan->dokumentasi)) {
                foreach ($laporan->dokumentasi as $foto) {
                    Storage::delete('laporan_banjir/' . $foto);
                }
            }
            $laporan->delete();
        }

        return redirect()->back()->with('success', 'Pembersihan berkala sukses! Semua data laporan pada periode tersebut telah dihapus.');
    }
}