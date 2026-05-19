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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scroll-bar-width: none; }
    </style>
</head>
<body class="bg-slate-50/50 min-h-screen text-slate-900 antialiased pb-12">

    <header class="bg-white border-b border-slate-200 py-4 px-8 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
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
                    {{ $laporan->priority_score >= 75 ? 'PARAH' : ($laporan->priority_score >= 50 ? 'SEDANG' : 'RENDAH') }}
                </span>

                <div class="relative w-28 h-28 flex items-center justify-center">
                    <svg class="absolute w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="{{ $laporan->priority_score >= 75 ? 'text-red-600' : ($laporan->priority_score >= 50 ? 'text-amber-500' : 'text-green-500') }}" 
                              stroke-dasharray="{{ $laporan->priority_score ?? 0 }}, 100" 
                              stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" 
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="text-center">
                        <span class="text-3xl font-black tracking-tight block text-slate-900 leading-none">{{ $laporan->priority_score ?? 0 }}</span>
                        <span class="text-xs font-bold text-slate-400">/ 100</span>
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

            @php
                // Hitung kontribusi riil dari laporan saat ini berbasis batas alokasi model kriteria SPK
                $pct_air = ($laporan->ketinggian_air >= 150) ? 20 : round(($laporan->ketinggian_air / 150) * 20);

                $total_bangunan = ($laporan->rumah_tergenang ?? 0) + ($laporan->toko_terdampak ?? 0);
                $pct_material = $total_bangunan >= 50 ? 30 : round(($total_bangunan / 50) * 30);
                if ($laporan->fasum_terdampak) { $pct_material = min($pct_material + 5, 30); }

                $total_rentan = ($laporan->jumlah_lansia ?? 0) + ($laporan->jumlah_bayi_bumil ?? 0);
                $pct_rentan = $total_rentan >= 20 ? 25 : round(($total_rentan / 20) * 25);

                $pct_evakuasi = (strtolower($laporan->butuh_evakuasi) === 'ya' || strtolower($laporan->butuh_evakuasi) === 'ya, mendesak!') ? 15 : 0;
                $pct_arus = ($laporan->ketinggian_air >= 150) ? 10 : (($laporan->ketinggian_air >= 80) ? 7 : 3);
                
                $jumlah_fasum = $laporan->fasum_terdampak ? count(explode(',', $laporan->fasum_terdampak)) : 0;
            @endphp
            
            <div class="lg:col-span-5 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Faktor Penentu Skor (Bobot AI)</h3>
                
                <div class="space-y-4 flex-1 flex flex-col justify-center">
                    
                    <div class="space-y-1 w-full pb-2 border-b border-slate-50">
                        <div class="flex justify-between text-xs font-semibold items-center">
                            <span class="text-slate-600 font-medium">Kerugian Material & Ekonomi</span>
                            <span class="text-red-600 font-bold font-mono text-sm">{{ $pct_material }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-red-600 h-full rounded-full transition-all duration-500" style="width: {{ $pct_material }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3.5">
                        
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold items-center">
                                <span class="text-slate-600 font-medium">Kelompok Rentan</span>
                                <span class="text-slate-900 font-bold font-mono">{{ $pct_rentan }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full transition-all duration-500" style="width: {{ $pct_rentan }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold items-center">
                                <span class="text-slate-600 font-medium">Tinggi Air Terkini</span>
                                <span class="text-slate-900 font-bold font-mono">{{ $pct_air }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full transition-all duration-500" style="width: {{ $pct_air }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold items-center">
                                <span class="text-slate-600 font-medium">Historis Wilayah</span>
                                <span class="text-slate-900 font-bold font-mono">{{ $pct_evakuasi }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full transition-all duration-500" style="width: {{ $pct_evakuasi }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold items-center">
                                <span class="text-slate-600 font-medium">Kecepatan Arus</span>
                                <span class="text-slate-900 font-bold font-mono">{{ $pct_arus }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full transition-all duration-500" style="width: {{ $pct_arus }}%"></div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>

            <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between h-full">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Rumah dan Facilities Terdampak</h3>
                
                <div class="flex items-end justify-around gap-4 h-36 bg-slate-50/50 p-4 rounded-xl border border-slate-100 shadow-inner">
                    <div class="flex flex-col items-center flex-1 group">
                        <span class="text-[10px] font-bold text-red-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $laporan->rumah_tergenang ?? 0 }} Unit</span>
                        <div class="bg-red-600 w-full rounded-t-lg transition-all duration-500 shadow-md" style="height: {{ min(($laporan->rumah_tergenang ?? 0) * 2, 110) }}px;"></div>
                    </div>
                    <div class="flex flex-col items-center flex-1 group">
                        <span class="text-[10px] font-bold text-slate-900 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $laporan->toko_terdampak ?? 0 }} Unit</span>
                        <div class="bg-slate-900 w-full rounded-t-lg transition-all duration-500 shadow-md" style="height: {{ min(($laporan->toko_terdampak ?? 0) * 2, 110) }}px;"></div>
                    </div>
                    <div class="flex flex-col items-center flex-1 group">
                        <span class="text-[10px] font-bold text-blue-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $jumlah_fasum }} Unit</span>
                        <div class="bg-blue-500 w-full rounded-t-lg transition-all duration-500 shadow-md" style="height: {{ $jumlah_fasum > 0 ? min($jumlah_fasum * 35, 110) : 4 }}px;"></div>
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
            
            <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between relative min-h-[360px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Bukti Dokumentasi Lapangan Warga</h3>
                    <span id="carouselIndicator" class="text-xs font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded-full">1 / 1</span>
                </div>
                
                <div class="relative flex-1 flex items-center justify-center bg-slate-50 rounded-xl overflow-hidden border border-slate-100 group w-full h-[280px]">
                    @if($laporan->dokumentasi && count($laporan->dokumentasi) > 0)
                        <div id="carouselTrack" class="absolute inset-0 flex transition-transform duration-500 ease-out no-scrollbar overflow-x-auto snap-x snap-mandatory pointer-events-none">
                            @foreach($laporan->dokumentasi as $foto)
                            <div class="w-full h-full flex-shrink-0 snap-center p-1">
                                <div class="w-full h-full rounded-lg overflow-hidden border border-slate-200 shadow-sm relative cursor-zoom-in pointer-events-auto" onclick="openImageModal('{{ route('kecamatan.laporan.foto', $foto) }}')">
                                    <img src="{{ route('kecamatan.laporan.foto', $foto) }}" class="w-full h-full object-cover select-none">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if(count($laporan->dokumentasi) > 1)
                        <button onclick="moveCarousel(-1)" class="absolute left-4 w-10 h-10 bg-white/95 hover:bg-white text-slate-800 rounded-full shadow-md flex items-center justify-center border border-slate-200 transition active:scale-95 z-10 opacity-0 group-hover:opacity-100 duration-300">
                            <i data-lucide="chevron-left" class="w-6 h-6"></i>
                        </button>
                        <button onclick="moveCarousel(1)" class="absolute right-4 w-10 h-10 bg-white/95 hover:bg-white text-slate-800 rounded-full shadow-md flex items-center justify-center border border-slate-200 transition active:scale-95 z-10 opacity-0 group-hover:opacity-100 duration-300">
                            <i data-lucide="chevron-right" class="w-6 h-6"></i>
                        </button>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center text-slate-300">
                            <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                            <span class="text-xs font-bold uppercase tracking-wider">Laporan Tanpa Dokumen Foto</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-5 bg-slate-950 text-white p-6 rounded-2xl border border-white/10 shadow-2xl flex flex-col justify-between space-y-4 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 text-white/5 pointer-events-none">
                    <i data-lucide="brain-circuit" class="w-36 h-36"></i>
                </div>

                <div class="flex items-center gap-2 border-b border-white/10 pb-3">
                    <i data-lucide="bot" class="w-6 h-6 text-blue-400"></i>
                    <h3 class="text-base font-bold tracking-tight">Rekomendasi Bantuan (Analisis AI)</h3>
                </div>

                <div class="space-y-3 flex-1 text-xs text-slate-300 leading-relaxed font-medium">
                    <div class="p-3 bg-white/5 rounded-xl border-l-4 border-blue-400 space-y-1">
                        <span class="text-white font-bold text-xs flex items-center gap-1">
                            <i data-lucide="life-buoy" class="w-3.5 h-3.5 text-blue-400"></i> Operasi Evakuasi Lapangan
                        </span>
                        <p class="text-slate-300">
                            {!! is_array($rekomendasi_ai) ? ($rekomendasi_ai['evakuasi'] ?? $rekomendasi_ai['rekomendasi'] ?? '') : $rekomendasi_ai !!}
                        </p>
                    </div>

                    <div class="p-3 bg-white/5 rounded-xl border-l-4 border-amber-400 space-y-1">
                        <span class="text-white font-bold text-xs flex items-center gap-1">
                            <i data-lucide="soup" class="w-3.5 h-3.5 text-amber-400"></i> Kebutuhan Dapur Umum & Logistik
                        </span>
                        <div class="text-slate-300">
                            @if(is_array($rekomendasi_ai) && isset($rekomendasi_ai['logistik']))
                                {!! $rekomendasi_ai['logistik'] !!}
                            @else
                                <p>Estimasi pasokan logistik pangan mandiri disiagakan sekurangnya <strong class="text-white font-mono">{{ $laporan->jumlah_kk * 3 }} porsi</strong> siap saji berdasarkan kalkulasi {{ $laporan->jumlah_kk }} KK terdampak nyata di lapangan.</p>
                            @endif
                        </div>
                    </div>

                    <div class="p-3 bg-white/5 rounded-xl border-l-4 border-emerald-400 space-y-1">
                        <span class="text-white font-bold text-xs flex items-center gap-1">
                            <i data-lucide="heart-pulse" class="w-3.5 h-3.5 text-emerald-400"></i> Penempatan Pos Medis
                        </span>
                        <div class="text-slate-300">
                            @if(is_array($rekomendasi_ai) && isset($rekomendasi_ai['medis']))
                                {!! $rekomendasi_ai['medis'] !!}
                            @else
                                <p>Fokus prioritas layanan kesehatan mobile diarahkan penuh guna memitigasi dampak penyakit menular air pada populasi kelompok rentan ({{ $laporan->jumlah_lansia }} Lansia & {{ $laporan->jumlah_bayi_bumil }} Bayi/Bumil).</p>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="tel:112" class="w-full bg-white hover:bg-slate-100 text-slate-950 py-3 rounded-full font-bold text-center text-sm shadow-md transition active:scale-98 inline-block">
                    Hubungi RW Setempat (112)
                </a>
            </div>
        </div>

    </main>

    <div id="imageZoomModal" class="fixed inset-0 bg-slate-950/90 backdrop-blur-sm hidden z-[100] items-center justify-center p-4 transition-all opacity-0 duration-300" onclick="closeImageModal()">
        <button class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition shadow-lg" onclick="closeImageModal()">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
        <div class="max-w-5xl max-h-[85vh] overflow-hidden rounded-2xl bg-white shadow-2xl border border-white/10" onclick="event.stopPropagation()">
            <img id="modalZoomTarget" src="" class="w-auto h-auto max-w-full max-h-[85vh] object-contain mx-auto">
        </div>
    </div>

    <script>
        lucide.createIcons();

        // 1. CAROUSEL SLIDER LOGIC
        let currentSlideIndex = 0;
        const totalSlides = {{ $laporan->dokumentasi ? count($laporan->dokumentasi) : 0 }};
        const track = document.getElementById('carouselTrack');
        const indicator = document.getElementById('carouselIndicator');

        function updateCarouselIndicator() {
            if (indicator && totalSlides > 0) {
                indicator.textContent = `${currentSlideIndex + 1} / ${totalSlides}`;
            }
        }
        updateCarouselIndicator();

        function moveCarousel(direction) {
            if (totalSlides <= 1) return;

            currentSlideIndex += direction;

            if (currentSlideIndex >= totalSlides) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex < 0) {
                currentSlideIndex = totalSlides - 1;
            }

            const slideWidth = track.clientWidth;
            track.scrollTo({
                left: currentSlideIndex * slideWidth,
                behavior: 'smooth'
            });

            updateCarouselIndicator();
        }

        window.addEventListener('resize', () => {
            if (track && totalSlides > 0) {
                const slideWidth = track.clientWidth;
                track.scrollLeft = currentSlideIndex * slideWidth;
            }
        });

        // 2. POP OUT LIGHTBOX ZOOM MODAL LOGIC
        function openImageModal(imageUrl) {
            const modal = document.getElementById('imageZoomModal');
            const modalImg = document.getElementById('modalZoomTarget');
            
            modalImg.src = imageUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
        }

        function closeImageModal() {
            const modal = document.getElementById('imageZoomModal');
            modal.classList.add('opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>