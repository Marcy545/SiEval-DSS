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
            'dokumentasi'        => 'nullable|array|max:3', // Maksimal kirim 3 file
            'dokumentasi.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Validasi file gambar max 2MB
        ]);

        // 2. Handling Upload Multi-Foto Dokumentasi
        $fotoSaved = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                if ($file->isValid()) {
                    // Berikan nama unik berbasis waktu agar tidak bentrok di server HP warga
                    $namaFoto = 'sieval_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    // Simpan fisik file ke folder: storage/app/public/laporan_banjir
                    $file->storeAs('public/laporan_banjir', $namaFoto);
                    $fotoSaved[] = $namaFoto;
                }
            }
        }

        // 3. Masukkan Seluruh Data ke Database
        LaporanBanjir::create([
            'user_id'           => Auth::id(), // ID RW yang sedang login (bisa null jika tamu)
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
            'dokumentasi'       => $fotoSaved // Menyimpan array nama file ke kolom tipe JSON
        ]);

        // 4. Redirect kembali dengan Flash Message sukses
        return redirect()->back()->with('success', 'Laporan banjir berhasil dikirim ke Kecamatan Bojongsoang!');
    }
}