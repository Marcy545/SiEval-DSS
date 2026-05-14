<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sebaran Banjir - SiEval DSS</title>

    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        #map { height: 100%; width: 100%; border-radius: 24px; z-index: 1; }
        .leaflet-container { background: #f5f6fa; }
    </style>
</head>

<body class="bg-[#f5f6fa] overflow-hidden">

<div class="flex h-screen">

    <!-- SIDEBAR (Sama dengan Dashboard) -->
    <aside class="w-[260px] bg-white border-r border-gray-200 flex flex-col justify-between flex-shrink-0">
        <div>
            <!-- Logo -->
            <div class="px-8 py-7 border-b border-gray-100">
                <h1 class="text-2xl font-extrabold">SiEval DSS</h1>
                <p class="text-sm text-gray-500 mt-1">Kecamatan Bojongsoang</p>
            </div>

            <!-- Menu -->
            <nav class="px-4 space-y-2">
                <!-- Menu Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 {{ request()->is('dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500' }} rounded-xl transition">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                    <span class="text-large">Dashboard</span>
                </a>

                <!-- Menu Peta Sebaran Banjir -->
                <a href="{{ route('peta') }}" class="flex items-center gap-3 p-3 {{ request()->is('rw/peta-banjir') ? 'bg-blue-50 text-gray-500 font-bold' : 'text-gray-500' }} hover:bg-gray-50 rounded-xl transition">
                    <i data-lucide="map" class="w-5 h-5"></i>
                    <span class="text-large">Peta Sebaran Banjir</span>
                </a>

                <!-- Menu Histori Banjir -->
                <a href="{{ route('history') }}" class="flex items-center gap-3 p-3 {{ request()->is('history') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500' }} hover:bg-gray-50 rounded-xl transition">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span class="text-large">Histori Banjir</span>
                </a>
            </nav>
        </div>

        <!-- User Section -->
        <div class="p-5 border-t border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-black"></div>
                <div>
                    <h2 class="font-semibold">
                        {{ Auth::user()->rw_desa }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
            <form action="/logout" method="POST" class="mt-5">
                @csrf
                <button class="text-red-500 font-medium">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0">
        
        <!-- Header (Sama dengan Dashboard) -->
        <header class="p-8 flex justify-between items-center bg-[#f5f6fa]">
            <h1 class="text-4xl font-extrabold text-[#111827]">Peta Sebaran Banjir</h1>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                    <input type="text" placeholder="Cari wilayah..." class="bg-white border border-gray-200 rounded-full pl-12 pr-6 py-3 w-[280px] outline-none shadow-sm focus:ring-2 focus:ring-black transition">
                </div>
                <button class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
                    <i data-lucide="rotate-cw" class="w-5 h-5 text-gray-600"></i>
                </button>
            </div>
        </header>

        <!-- Area Peta & List -->
        <div class="flex-1 flex px-8 pb-8 gap-6 overflow-hidden">
            
            <!-- Map Container -->
            <div class="flex-1 relative bg-white rounded-[32px] p-2 shadow-sm border border-gray-100">
                <div id="map"></div>

                <!-- Floating Legend -->
                <div class="absolute bottom-8 left-8 z-[1000] bg-white p-6 rounded-3xl shadow-xl w-60 border border-gray-100">
                    <h3 class="font-bold text-sm mb-4 text-gray-900">Legenda Risiko</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-xs font-medium text-gray-600">Tinggi (> 1,5m)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-orange-400"></span>
                            <span class="text-xs font-medium text-gray-600">Sedang (0,5m - 1,5m)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-xs font-medium text-gray-600">Aman (< 0,5m)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Data Scoring (Sesuai Figma sebelumnya tapi dengan UI Dashboard) -->
            <div class="w-80 flex flex-col gap-4 overflow-y-auto pr-2">
                <div class="flex justify-between items-center px-2">
                    <h3 class="font-bold text-gray-900">Monitoring Wilayah</h3>
                    <span class="text-[10px] bg-gray-200 px-2 py-1 rounded-full font-bold">14 RW</span>
                </div>

                <!-- Card RW 07 (Contoh Sesuai Data Dashboard Anda) -->
                <div class="bg-white p-6 rounded-[28px] border border-gray-100 shadow-sm hover:shadow-md transition cursor-pointer group">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-sm">RW 07</h4>
                            <p class="text-xs text-gray-400">Citeureup</p>
                        </div>
                        <span class="bg-red-100 text-red-600 text-[10px] font-black px-3 py-1 rounded-full uppercase">Bahaya</span>
                    </div>
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400 font-medium">Tinggi Air</span>
                            <span class="font-bold">180 cm</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="w-[90%] h-full bg-red-500"></div>
                        </div>
                    </div>
                    <button class="w-full py-3 bg-black text-white rounded-2xl text-xs font-bold hover:bg-gray-800 transition">Update Kondisi</button>
                </div>

                <!-- Card RW 12 (Contoh) -->
                <div class="bg-white p-6 rounded-[28px] border border-gray-100 shadow-sm hover:shadow-md transition cursor-pointer group">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-sm">RW 12</h4>
                            <p class="text-xs text-gray-400">Bojongsoang</p>
                        </div>
                        <span class="bg-orange-100 text-orange-600 text-[10px] font-black px-3 py-1 rounded-full uppercase">Waspada</span>
                    </div>
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400 font-medium">Tinggi Air</span>
                            <span class="font-bold">140 cm</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="w-[70%] h-full bg-orange-400"></div>
                        </div>
                    </div>
                    <button class="w-full py-3 bg-black text-white rounded-2xl text-xs font-bold hover:bg-gray-800 transition">Update Kondisi</button>
                </div>

            </div>
        </div>

    </main>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    lucide.createIcons();

    // Inisialisasi Peta
    var map = L.map('map', { zoomControl: false }).setView([-6.9744, 107.6385], 14);

    // Style Peta Bersih (Light Mode)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Custom Marker (Bulat Minimalis seperti Dashboard)
    function createIcon(color) {
        return L.divIcon({
            className: 'custom-icon',
            html: `<div style="background-color: ${color}; width: 16px; height: 16px; border: 3px solid white; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.15);"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });
    }

    // Pin Lokasi Sesuai Dashboard
    L.marker([-6.9760, 107.6350], {icon: createIcon('#ef4444')}).addTo(map); // RW 07
    L.marker([-6.9800, 107.6420], {icon: createIcon('#fbbf24')}).addTo(map); // RW 12
    L.marker([-6.9720, 107.6450], {icon: createIcon('#22c55e')}).addTo(map); // RW 03
</script>

</body>
</html>