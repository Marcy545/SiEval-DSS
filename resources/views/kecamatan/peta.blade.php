<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sebaran Heatmap - SiEval DSS</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .leaflet-container { font-family: 'Inter', sans-serif; }
        
        /* Modifikasi Popup Peta */
        .leaflet-popup-content-wrapper { border-radius: 12px; padding: 0; overflow: hidden; }
        .leaflet-popup-content { margin: 0; width: 220px !important; }
        .custom-popup-header { padding: 10px 14px; color: white; font-weight: bold; font-size: 13px; }
        .custom-popup-body { padding: 12px 14px; font-size: 12px; color: #475569; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex shrink-0 relative z-20">
        <div>
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-900 rounded-full flex items-center justify-center text-white"><i data-lucide="shield-alert" class="w-5 h-5 text-blue-400"></i></div>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">SiEval DSS</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Kec. Bojongsoang</p>
                </div>
            </div>
            <nav class="px-4 space-y-1 mt-4">
                <a href="{{ route('kecamatan.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm transition">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 bg-slate-100 text-slate-900 rounded-lg font-semibold text-sm transition">
                    <i data-lucide="map" class="w-5 h-5 text-slate-700"></i> Peta Sebaran
                </a>
                <a href="{{ route('kecamatan.history') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm transition">
                    <i data-lucide="history" class="w-5 h-5"></i> Histori Banjir
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-200 space-y-3">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-xs">CM</div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name ?? 'Camat Bojongsoang' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'camat@bojongsoang.go.id' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium text-sm transition"><i data-lucide="log-out" class="w-4 h-4"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative z-10">
        
        <header class="bg-white h-20 px-8 flex items-center justify-between border-b border-slate-200 shrink-0 relative z-20 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Peta Sebaran Banjir (Heatmap)</h2>
            <div class="flex items-center gap-4">
                <div class="relative hidden lg:block">
                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"></i>
                    <input type="text" placeholder="Cari RW atau wilayah..." class="bg-slate-100 border border-slate-200 text-sm rounded-full pl-9 pr-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </header>

        <div class="flex-1 relative">
            <div id="map" class="w-full h-full z-0"></div>

            <div class="absolute bottom-6 left-6 z-10 bg-white/95 backdrop-blur-md p-4 rounded-xl shadow-lg border border-slate-200/60 w-60">
                <p class="text-sm font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Legenda Risiko Peta</p>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-600 border border-white shadow-sm"></div>
                        <span class="text-xs font-medium text-slate-600">Risiko Darurat / Parah</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-amber-500 border border-white shadow-sm"></div>
                        <span class="text-xs font-medium text-slate-600">Risiko Sedang</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500 border border-white shadow-sm"></div>
                        <span class="text-xs font-medium text-slate-600">Risiko Rendah / Ringan</span>
                    </div>
                    <div class="flex items-center gap-2 mt-3 pt-2 border-t border-slate-100">
                        <div class="w-16 h-3 rounded bg-gradient-to-r from-blue-400 via-amber-400 to-red-500"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Intensitas Panas</span>
                    </div>
                </div>
            </div>

            <div class="absolute top-0 bottom-0 right-0 w-80 bg-white/95 backdrop-blur-xl border-l border-slate-200 shadow-2xl z-10 flex flex-col transform transition-transform duration-300">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">AI Scoring Banjir</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Kecamatan Bojongsoang (Real-time)</p>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    @forelse($laporan_banjir->sortByDesc('priority_score') as $laporan)
                    
                    @php
                        $bgColor = $laporan->priority_score >= 75 ? 'bg-red-50/50 border-red-100' : ($laporan->priority_score >= 50 ? 'bg-amber-50/50 border-amber-100' : 'bg-green-50/50 border-green-100');
                        $badgeColor = $laporan->priority_score >= 75 ? 'bg-red-100 text-red-700' : ($laporan->priority_score >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700');
                    @endphp

                    <div class="p-4 rounded-xl border {{ $bgColor }} shadow-sm flex flex-col justify-between">
                        <div class="mb-2">
                            <span class="text-sm font-bold text-slate-900 block truncate">{{ $laporan->rw_kelurahan }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between text-xs text-slate-600 mb-3">
                            <div class="flex items-center gap-1.5"><i data-lucide="users-2" class="w-3.5 h-3.5 text-slate-400"></i> <span class="font-medium">{{ $laporan->jumlah_kk }} KK</span></div>
                            <div class="flex items-center gap-1.5"><i data-lucide="ruler" class="w-3.5 h-3.5 text-slate-400"></i> <span class="font-medium">{{ $laporan->ketinggian_air }} cm</span></div>
                        </div>

                        <div class="mb-2.5">
                            <span class="block w-full py-1 text-center text-[10px] font-black tracking-wider rounded-full shadow-inner {{ $badgeColor }}">
                                STATUS: {{ $laporan->priority_label }}
                            </span>
                        </div>

                        <a href="{{ route('kecamatan.detail_laporan', $laporan->id) }}" class="block w-full py-2 text-center text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-full transition shadow-sm">
                            Lihat Detail
                        </a>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center text-center py-10 opacity-50">
                        <i data-lucide="map-pinned" class="w-10 h-10 text-slate-400 mb-2"></i>
                        <p class="text-xs font-medium text-slate-500">Tidak ada titik laporan banjir yang aktif di peta.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <footer class="h-10 px-6 bg-white border-t border-slate-200 flex items-center justify-between shrink-0 relative z-20">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-medium text-slate-500">SISTEM LIVE TRACKING AKTIF</span>
            </div>
            <span class="text-[10px] font-medium text-slate-400">SiEval DSS © 2026 • Koordinasi Darurat Bojongsoang</span>
        </footer>
    </main>

    <script>
        lucide.createIcons();

        // 1. Inisialisasi Peta (Kecamatan Bojongsoang)
        const map = L.map('map', { zoomControl: false }).setView([-6.9749, 107.6369], 13);
        
        L.control.zoom({ position: 'topleft' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
        }).addTo(map);

        // 2. Data Titik Banjir
        const rawLaporanData = {!! json_encode($laporan_banjir) !!};
        const heatPoints = []; 

        // 3. Render Marker Pin Satuan & Kumpulkan Titik Heatmap
        rawLaporanData.forEach(laporan => {
            const lat = parseFloat(laporan.latitude);
            const lng = parseFloat(laporan.longitude);
            
            if (isNaN(lat) || isNaN(lng)) return;

            let markerColor = '#22c55e'; 
            let headerClass = 'bg-green-600';
            let heatIntensity = 0.4; 

            if (laporan.priority_score >= 75) {
                markerColor = '#dc2626'; 
                headerClass = 'bg-red-600';
                heatIntensity = 1.0; 
            } else if (laporan.priority_score >= 50) {
                markerColor = '#f59e0b'; 
                headerClass = 'bg-amber-500';
                heatIntensity = 0.7; 
            }

            heatPoints.push([lat, lng, heatIntensity]);

            // B. Buat Custom Circle Marker (Radius: 14)
            const circleMarker = L.circleMarker([lat, lng], {
                radius: 14,      
                fillColor: markerColor,
                color: "#ffffff",
                weight: 2.5,     
                opacity: 1,
                fillOpacity: 0.95
            }).addTo(map);

            // C. Popup Keterangan
            const popupHTML = `
                <div class="${headerClass} custom-popup-header">
                    ${laporan.rw_kelurahan}
                </div>
                <div class="custom-popup-body space-y-2">
                    <p class="font-semibold text-slate-800 flex justify-between border-b pb-1">
                        <span>Tinggi Air:</span> <span class="font-mono text-red-600">${laporan.ketinggian_air} cm</span>
                    </p>
                    <p class="flex justify-between">
                        <span>Terdampak:</span> <span class="font-bold">${laporan.jumlah_kk} KK</span>
                    </p>
                    <p class="flex justify-between">
                        <span>Evakuasi:</span> <span class="font-bold">${laporan.butuh_evakuasi}</span>
                    </p>
                    <div class="pt-2 text-center">
                        <a href="/kecamatan/laporan/${laporan.id}" class="text-xs text-blue-600 font-bold hover:underline">Analisis DSS ➔</a>
                    </div>
                </div>
            `;
            circleMarker.bindPopup(popupHTML);
        });

        // 4. Layers Awan Heatmap (Radius: 50)
        if (heatPoints.length > 0) {
            const heatLayer = L.heatLayer(heatPoints, {
                radius: 50,      
                blur: 25,        
                maxZoom: 15,     
                gradient: {
                    0.2: '#60a5fa', 
                    0.5: '#facc15', 
                    0.8: '#fb923c', 
                    1.0: '#dc2626'  
                }
            }).addTo(map);
        }
    </script>
</body>
</html>