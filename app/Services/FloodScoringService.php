<?php

namespace App\Services;

class FloodScoringService
{
    public static function calculateScore($laporan)
    {
        // 🚨 OVERRIDE MUTLAK (Jalur Bypass)
        // Jika air >= 150 cm (1.5 meter), langsung tembak Skor 100 (PARAH).
        if ($laporan->ketinggian_air >= 150) {
            return 100;
        }

        $score = 0;

        // 1. Ketinggian Air (Paling Krusial) -> Maksimal 40 Poin
        if ($laporan->ketinggian_air >= 100) $score += 40;      // 100-149 cm (Sedada) otomatis dapet poin gede
        elseif ($laporan->ketinggian_air >= 50) $score += 25;   // Selutut/Paha
        elseif ($laporan->ketinggian_air > 0) $score += 10;      // Genangan ringan

        // 2. Urgensi Evakuasi -> Maksimal 25 Poin
        if (strtolower($laporan->butuh_evakuasi) === 'ya, mendesak!') $score += 25;
        elseif (strtolower($laporan->butuh_evakuasi) === 'ya') $score += 15;

        // 3. Kepadatan KK Terdampak (YANG SEBELUMNYA HILANG) -> Maksimal 15 Poin
        $kk = $laporan->jumlah_kk ?? 0;
        if ($kk >= 50) $score += 15;
        elseif ($kk >= 20) $score += 10;
        elseif ($kk > 0) $score += 5;

        // 4. Kelompok Rentan (Lansia + Bayi) -> Maksimal 10 Poin
        $rentan = ($laporan->jumlah_lansia ?? 0) + ($laporan->jumlah_bayi_bumil ?? 0);
        if ($rentan >= 20) $score += 10;
        elseif ($rentan > 0) $score += 5;

        // 5. Tingkat Keparahan Laporan RW -> Maksimal 10 Poin
        if (strtolower($laporan->tingkat_keparahan) === 'parah') $score += 10;
        elseif (strtolower($laporan->tingkat_keparahan) === 'sedang') $score += 5;

        return min($score, 100);
    }

    public static function getLabel($score)
    {
        if ($score >= 75) return 'PARAH';
        if ($score >= 50) return 'SEDANG';
        return 'RINGAN';
    }

    // --- ALGORITMA ESTIMASI KERUGIAN EKONOMI ---
    public static function calculateEconomicLoss($laporan)
    {
        $hargaRumah = 0;
        if ($laporan->tingkat_keparahan === 'Parah') {
            $hargaRumah = 30000000; // Asumsi kerugian Rp30 Jt per rumah parah
        } elseif ($laporan->tingkat_keparahan === 'Sedang') {
            $hargaRumah = 15000000; // Asumsi kerugian Rp15 Jt per rumah sedang
        } else {
            $hargaRumah = 5000000;  // Asumsi kerugian Rp5 Jt per rumah ringan
        }

        $kerugianRumah = $laporan->rumah_tergenang * $hargaRumah;
        $kerugianToko = ($laporan->toko_terdampak ?? 0) * 50000000; // Rp50 Jt per toko

        return $kerugianRumah + $kerugianToko;
    }

    // --- ALASAN PENENTU SKOR (DETAIL) ---
    public static function getDeterminants($laporan)
    {
        $factors = [];
        
        if ($laporan->butuh_evakuasi === 'Ya, Mendesak!') {
            $factors[] = 'Ancaman keselamatan jiwa aktif di lokasi, warga terjebak dan memerlukan evakuasi fisik segera.';
        }
        if ($laporan->ketinggian_air >= 150) {
            $factors[] = "Ketinggian air kritis menembus {$laporan->ketinggian_air} cm, berisiko merendam instalasi listrik dan atap bangunan tunggal.";
        } elseif ($laporan->ketinggian_air >= 100) {
            $factors[] = "Tinggi genangan air mencapai {$laporan->ketinggian_air} cm, memutus jalur transportasi utama roda dua dan roda empat.";
        }
        if (($laporan->jumlah_lansia ?? 0) > 0) {
            $factors[] = "Terdapat populasi lansia sebanyak {$laporan->jumlah_lansia} jiwa yang memiliki keterbatasan mobilitas di zona genangan.";
        }
        if (($laporan->jumlah_bayi_bumil ?? 0) > 0) {
            $factors[] = "Terdeteksi adanya kelompok rentan bayi/ibu hamil sebanyak {$laporan->jumlah_bayi_bumil} jiwa yang rentan terhadap hipotermia dan kontaminasi bakteri air.";
        }
        if ($laporan->rumah_tergenang > 30) {
            $factors[] = "Dampak struktural meluas, merendam sedikitnya {$laporan->rumah_tergenang} unit tempat tinggal warga.";
        }
        if ($laporan->toko_terdampak > 0) {
            $factors[] = "Sektor ekonomi lokal terganggu akibat terendamnya {$laporan->toko_terdampak} unit ruko/tempat usaha.";
        }

        return count($factors) > 0 ? $factors : ['Seluruh indikator krisis terpantau berada di bawah ambang batas bahaya minimum.'];
    }

    // --- NARASI REKOMENDASI AI (ADAPTIF & PANJANG) ---
    public static function getAiRecommendation($score, $laporan)
    {
        $lansia = $laporan->jumlah_lansia ?? 0;
        $bayiBumil = $laporan->jumlah_bayi_bumil ?? 0;
        $totalRentan = $lansia + $bayiBumil;

        if ($score >= 75) {
            $txt = "🚨 <span class='font-bold text-red-400'>DIREKTIF TACTICAL DARURAT (KATEGORI ALPHA-1):</span> Status wilayah kritis. Segera kerahkan Tim SAR Gabungan, BPBD, dan kendaraan taktis amfibi ke titik koordinat. ";
            
            if ($laporan->butuh_evakuasi === 'Ya, Mendesak!') {
                $txt .= "Fokus utama 100% adalah evakuasi penyelamatan jiwa. Prioritaskan pengamanan depo pengungsian utama. ";
            }

            if ($totalRentan > 0) {
                $txt .= "Mobilisasi evakuasi wajib didahului pada kelompok prioritas, yaitu <span class='underline'>{$lansia} jiwa Lansia</span> dan <span class='underline'>{$bayiBumil} Bayi/Ibu Hamil</span> menggunakan perahu karet medis. ";
            }

            $txt .= "Kebutuhan logistik mendesak yang wajib dikirimkan dalam waktu kurang dari 3 jam meliputi: Paket sembako siap saji (tanpa masak), selimut hangat, air minum higienis, pakaian kering, serta kit sanitasi bayi (popok/susu formula). Standby-kan ambulans darurat di ring luar banjir.";
            return $txt;
        }

        if ($score >= 50) {
            $txt = "⚠️ <span class='font-bold text-amber-400'>DIREKTIF KESIAPSIAGAAN (KATEGORI BRAVO-1):</span> Wilayah terindikasi mengalami banjir sedang dengan gangguan mobilitas tinggi. ";
            
            if ($laporan->status_banjir === 'Masih Menggenang') {
                $txt .= "Kondisi air dilaporkan masih bertahan/menggenang. Dinas Sosial direkomendasikan segera mendirikan Dapur Umum di area ring-2 aman terdekat. ";
            } else {
                $txt .= "Kondisi air dilaporkan mulai surut, namun posko kesiapsiagaan harus tetap aktif mengantisipasi luapan air susulan akibat cuaca ekstrem. ";
            }

            if ($totalRentan > 0) {
                $txt .= "Tim medis puskesmas keliling wajib disiagakan untuk memeriksa kondisi fisik {$totalRentan} warga rentan dari risiko penyakit kulit, diare, dan ISPA. ";
            }

            $txt .= "Pasokan bantuan logistik difokuskan pada pengiriman beras, mie instan, obat-obatan dasar, air bersih portable, serta lampu penerangan darurat (genset) jika terjadi pemadaman listrik berkala oleh PLN.";
            return $txt;
        }

        $txt = "✅ <span class='font-bold text-green-400'>DIREKTIF MITIGASI & PEMULIHAN (KATEGORI CHARLIE-1):</span> Tingkat ancaman rendah, situasi kondusif terkendali. ";
        
        if ($laporan->rumah_tergenang > 0 || $laporan->fasum_terdampak) {
            $txt .= "Bantuan diarahkan pada aspek pemulihan lingkungan pasca-genangan. Salurkan paket kebersihan lingkungan (Family Cleaning Kit) seperti cairan disinfektan, alat pel, dan boot karet untuk warga bersiap membersihkan area tempat tinggal. ";
        }

        if ($laporan->status_banjir === 'Masih Menggenang') {
            $txt .= "Disarankan untuk memobilisasi unit mesin pompa penyedot air (portable pump) ke area selokan/drainase utama yang tersumbat guna mempercepat proses pengeringan jalan. ";
        } else {
            $txt .= "Data laporan menyatakan air sudah surut. Tetap lakukan pemantauan forecasting cuaca BMKG berkala via aplikasi internal.";
        }

        return $txt;
    }
}