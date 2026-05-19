<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Analisis Detail SPK - SiEval DSS</title>
    
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 min-h-screen text-slate-900 antialiased pb-12">

    <header class="bg-white border-b border-slate-200 py-4 px-8 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('kecamatan.dashboard') }}" class="p-2 hover:bg-slate-100 rounded-full transition group">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $laporan->rw_kelurahan }}</h1>
            </div>
            
            <a href="{{ route('kecamatan.dashboard') }}" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center text-slate-700 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 mt-8 space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            <div class="lg:col-span-3 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center justify-center text-center space-y-4">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Skor Prioritas AI</h3>
                
                <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wider {{ $laporan->priority_score >= 75 ? 'bg-red-100 text-red-700' : ($laporan->priority_score >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                    {{ $laporan->priority_label }}
                </span>

                <div class="relative w-28 h-28 flex items-center justify-center">
                    <svg class="absolute w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="{{ $laporan->priority_score >= 75 ? 'text-red-600' : ($laporan->priority_score >= 50 ? 'text-amber-500' : 'text-green-500') }}" 
                              stroke-dasharray="{{ $laporan->priority_score }}, 100" 
                              stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" 
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="text-center">
                        <span class="text-3xl font-black tracking-tight block text-slate-900 leading-none">{{ $laporan->priority_score }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">/ 100</span>
                    </div>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed font-medium px-2">
                    @if($laporan->priority_score >= 75)
                        Status Kritis: Dibutuhkan intervensi taktis dan evakuasi segera dalam kurun waktu 6 jam ke depan.
                    @elseif($laporan->priority_score >= 50)
                        Status Kesiapsiagaan: Pemantauan logistik dapur umum aktif dan pemeriksaan medis berkala diperlukan.
                    @else
                        Status Waspada: Kondisi aman kondusif, fokus utama pada pembersihan lingkungan pasca-surut.
                    @endif
                </p>
            </div>

            <div class="lg:col-span-5 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Faktor Penentu Skor (Bobot AI)</h3>
                
                <div class="space-y-4 flex-1 flex flex-col justify-center">
                    
                    <div class="space-y-1 w-full pb-2 border-b border-slate-50">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-slate-600">Kerugian Material & Ekonomi</span>
                            <span class="text-red-600">30%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-red-600 h-full rounded-full" style="width: 30%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3.5">
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-600">Kelompok Rentan</span>
                                <span class="text-slate-800">25%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full" style="width: 25%"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-600">Tinggi Air Terkini</span>
                                <span class="text-slate-800">20%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full" style="width: 20%"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-600">Historis Wilayah</span>
                                <span class="text-slate-800">15%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full" style="width: 15%"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-600">Kecepatan Arus</span>
                                <span class="text-slate-800">10%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full" style="width: 10%"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between h-full">
                <h3 class="text-base font-bold text-slate-900 tracking-tight mb-2">Rumah dan Facilities Terdampak</h3>
                
                <div class="flex items-end justify-around gap-4 h-36 bg-slate-50/50 p-4 rounded-xl border border-slate-100 shadow-inner">
                    <div class="flex flex-col items-center flex-1 group">
                        <span class="text-[10px] font-bold text-red-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $laporan->rumah_tergenang }} Unit</span>
                        <div class="bg-red-600 w-full rounded-t-lg transition-all duration-500 shadow-md" style="height: {{ min(($laporan->rumah_tergenang / max(($laporan->rumah_tergenang + $laporan->toko_terdampak + 1), 1)) * 100, 100) }}px;"></div>
                    </div>
                    <div class="flex flex-col items-center flex-1 group">
                        <span class="text-[10px] font-bold text-slate-900 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $laporan->toko_terdampak }} Unit</span>
                        <div class="bg-slate-900 w-full rounded-t-lg transition-all duration-500 shadow-md" style="height: {{ min(($laporan->toko_terdampak / max(($laporan->rumah_tergenang + $laporan->toko_terdampak + 1), 1)) * 100, 100) }}px;"></div>
                    </div>
                    <div class="flex flex-col items-center flex-1 group">
                        <span class="text-[10px] font-bold text-blue-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $laporan->fasum_terdampak ? '1' : '0' }} Unit</span>
                        <div class="bg-blue-500 w-full rounded-t-lg transition-all duration-500 shadow-md" style="height: {{ $laporan->fasum_terdampak ? '40px' : '4px' }};"></div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-1 text-center text-[11px] font-bold text-slate-500 mt-3 pt-2 border-t border-slate-100">
                    <div>Rumah</div>
                    <div>Usaha/Toko</div>
                    <div>Fasum</div>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-base font-bold text-slate-900 tracking-tight flex items-center gap-1.5">
                <i data-lucide="users" class="w-4 h-4 text-slate-500"></i> Dampak Demografi Penduduk
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jumlah KK Terdampak</span>
                    <div class="flex items-baseline gap-1 mt-1 text-slate-900 font-mono">
                        <span class="text-2xl font-black">{{ $laporan->jumlah_kk }}</span>
                        <span class="text-xs font-semibold text-slate-500">KK</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jumlah Jiwa Terdampak</span>
                    <div class="flex items-baseline gap-1 mt-1 text-slate-900 font-mono">
                        <span class="text-2xl font-black">{{ $laporan->jumlah_jiwa }}</span>
                        <span class="text-xs font-semibold text-slate-500">Jiwa</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jumlah Lansia (>60Th)</span>
                    <div class="flex items-baseline gap-1 mt-1 text-slate-900 font-mono">
                        <span class="text-2xl font-black text-amber-600">{{ $laporan->jumlah_lansia }}</span>
                        <span class="text-xs font-semibold text-slate-500">Jiwa</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jumlah Bayi / Ibu Hamil</span>
                    <div class="flex items-baseline gap-1 mt-1 text-slate-900 font-mono">
                        <span class="text-2xl font-black text-blue-600">{{ $laporan->jumlah_bayi_bumil }}</span>
                        <span class="text-xs font-semibold text-slate-500">Jiwa</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Bukti Dokumentasi Lapangan Warga</h3>
                
                <div class="grid grid-cols-3 gap-4 flex-1 items-center">
                    @if($laporan->dokumentasi && count($laporan->dokumentasi) > 0)
                        @foreach($laporan->dokumentasi as $foto)
                        <div class="h-44 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 relative group shadow-sm">
                            <img src="{{ route('kecamatan.laporan.foto', $foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @endforeach
                        
                        @for ($i = count($laporan->dokumentasi); $i < 3; $i++)
                        <div class="h-44 bg-slate-50 border border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center text-slate-300">
                            <i data-lucide="image" class="w-6 h-6 mb-1"></i>
                            <span class="text-[10px] font-medium uppercase tracking-wider">Tidak Ada Foto</span>
                        </div>
                        @endfor
                    @else
                        @for ($i = 1; $i <= 3; $i++)
                        <div class="h-44 bg-slate-50 border border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center text-slate-300">
                            <i data-lucide="image" class="w-6 h-6 mb-1"></i>
                            <span class="text-[10px] font-medium uppercase tracking-wider">Kosong</span>
                        </div>
                        @endfor
                    @endif
                </div>
            </div>

            <div class="lg:col-span-5 bg-slate-950 text-white p-6 rounded-2xl border border-white/10 shadow-2xl flex flex-col justify-between space-y-4 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 text-white/5 pointer-events-none">
                    <i data-lucide="brain-circuit" class="w-36 h-36"></i>
                </div>

                <div class="flex items-center gap-2 border-b border-white/10 pb-3">
                    <i data-lucide="bot" class="w-6 h-6 text-blue-400"></i>
                    <h3 class="text-base font-bold tracking-tight">Rekomendasi Bantuan</h3>
                </div>

                <div class="space-y-3 flex-1 text-xs text-slate-300 leading-relaxed font-medium">
                    <div class="p-3 bg-white/5 rounded-xl border-l-4 border-blue-400 space-y-1">
                        <span class="text-white font-bold text-xs flex items-center gap-1">
                            <i data-lucide="life-buoy" class="w-3.5 h-3.5 text-blue-400"></i> Operasi Evakuasi Lapangan
                        </span>
                        <p>
                            @if($laporan->butuh_evakuasi === 'Ya, Mendesak!')
                                Posko Utama Lapangan {{ $laporan->rw_kelurahan }} kritis. Segera mobilisasi perahu karet untuk mengevakuasi {{ $laporan->jumlah_lansia }} Lansia ke Aula Aman terdekat.
                            @else
                                Jalur evakuasi siaga. Tetap pantau titik kumpul warga dan pastikan tidak ada genangan yang menutup akses keluar masuk utama.
                            @endif
                        </p>
                    </div>

                    <div class="p-3 bg-white/5 rounded-xl border-l-4 border-amber-400 space-y-1">
                        <span class="text-white font-bold text-xs flex items-center gap-1">
                            <i data-lucide="soup" class="w-3.5 h-3.5 text-amber-400"></i> Kebutuhan Dapur Umum & Logistik
                        </span>
                        <p>
                            Estimasi konsumsi: Diperlukan pasokan makanan siap saji sekurangnya sebanyak <strong class="text-white font-mono">{{ $laporan->jumlah_kk * 2 }} porsi</strong> darurat (berdasarkan total {{ $laporan->jumlah_kk }} KK terdampak nyata).
                        </p>
                    </div>

                    <div class="p-3 bg-white/5 rounded-xl border-l-4 border-emerald-400 space-y-1">
                        <span class="text-white font-bold text-xs flex items-center gap-1">
                            <i data-lucide="heart-pulse" class="w-3.5 h-3.5 text-emerald-400"></i> Penempatan Pos Medis
                        </span>
                        <p>
                            Fokus penanganan medis darurat diarahkan penuh pada populasi <span class="text-white underline">{{ $laporan->jumlah_lansia }} Lansia</span> serta perlindungan kontaminasi air untuk <span class="text-white underline">{{ $laporan->jumlah_bayi_bumil }} Bayi/Bumil</span>.
                        </p>
                    </div>
                </div>

                <a href="tel:112" class="w-full bg-white hover:bg-slate-100 text-slate-950 py-3 rounded-full font-bold text-center text-sm shadow-md transition active:scale-98 inline-block">
                    Hubungi RW Setempat (112)
                </a>
            </div>

        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>