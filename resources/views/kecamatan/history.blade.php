<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Histori Laporan Banjir - SiEval DSS</title>
    
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;600&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" />
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex shrink-0">
        <div>
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SiEval DSS" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">SiEval DSS</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Kec. Bojongsoang</p>
                </div>
            </div>

            <nav class="px-4 space-y-1 mt-4">
                <a href="{{ route('kecamatan.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm transition">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="{{ route('kecamatan.peta') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm transition">
                    <i data-lucide="map" class="w-5 h-5"></i> Peta Sebaran
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 bg-slate-100 text-slate-900 rounded-lg font-semibold text-sm transition">
                    <i data-lucide="history" class="w-5 h-5 text-slate-700"></i> Histori Banjir
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-200 space-y-3">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-xs">
                    {{ strtoupper(substr(Auth::user()->name ?? 'CM', 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name ?? 'Camat Bojongsoang' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'camat@bojongsoang.go.id' }}</p>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium text-sm transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="bg-white h-20 px-8 flex items-center justify-between border-b border-slate-200 shrink-0">
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Histori Laporan Banjir</h2>
            <div class="flex items-center gap-4">
                <div class="relative hidden lg:block">
                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"></i>
                    <input type="text" id="historySearch" placeholder="Cari wilayah RW..." class="bg-slate-100 border border-slate-200 text-sm rounded-full pl-9 pr-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-6">
            
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-3">
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">Zona Rekaman Laporan</h3>
                        <span class="text-xs font-bold bg-slate-50 border border-slate-200 text-slate-600 px-3 py-1 rounded-full font-mono">
                            Total: {{ count($laporan_all ?? []) }} Berkas
                        </span>
                    </div>
                    
                    <div class="relative inline-block text-left">
                        <select id="historyFilter" class="text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 rounded-lg px-3 py-2 pr-8 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                            <option value="ALL">Semua Status</option>
                            <option value="PARAH">Status: PARAH</option>
                            <option value="SEDANG">Status: SEDANG</option>
                            <option value="RENDAH">Status: RENDAH</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-2.5 pointer-events-none"></i>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="historyTable">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold border-b border-slate-200">
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama RW</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Ketinggian Air (CM)</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Jumlah KK</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Tanggal Kejadian</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Status Keparahan</th>
                                <th class="px-6 py-4 font-semibold text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($laporan_all as $laporan)
                            <tr class="hover:bg-slate-50/80 transition history-row">
                                <td class="px-6 py-5 whitespace-nowrap search-target">
                                    <p class="text-sm font-bold text-slate-900 leading-tight">{{ $laporan->rw_kelurahan }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">Kecamatan Bojongsoang</p>
                                </td>
                                <td class="px-6 py-5 text-center font-bold text-slate-900 text-sm whitespace-nowrap">
                                    {{ $laporan->ketinggian_air }}
                                </td>
                                <td class="px-6 py-5 text-center text-sm text-slate-500 whitespace-nowrap">
                                    {{ number_format($laporan->jumlah_kk) }} KK
                                </td>
                                <td class="px-6 py-5 text-center text-xs text-slate-500 whitespace-nowrap">
                                    {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '23 April 2026, 12:00 WIB' }}
                                </td>
                                <td class="px-6 py-5 text-center whitespace-nowrap filter-target">
                                    <span class="status-badge text-[10px] font-bold tracking-wider px-3 py-1 rounded-full uppercase inline-block
                                        {{ ($laporan->priority_score ?? 0) >= 75 ? 'bg-red-50 text-red-500 border border-red-200' : (($laporan->priority_score ?? 0) >= 50 ? 'bg-amber-50 text-amber-500 border border-amber-200' : 'bg-green-50 text-green-600 border border-green-200') }}">
                                        {{ ($laporan->priority_score ?? 0) >= 75 ? 'PARAH' : (($laporan->priority_score ?? 0) >= 50 ? 'SEDANG' : 'RENDAH') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                    <a href="{{ route('kecamatan.detail_laporan', $laporan->id) }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-full text-xs font-semibold transition shadow-sm inline-block tracking-wide">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i data-lucide="folder-open" class="w-8 h-8 text-slate-300"></i>
                                        <span class="font-medium">Belum ada rekaman data histori laporan krisis.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        lucide.createIcons();

        // 🔥 PERUBAHAN JAVASCRIPT: GABUNGIN SEARCH DAN FILTER DROPDOWN
        const searchInput = document.getElementById('historySearch');
        const filterSelect = document.getElementById('historyFilter');
        const tableRows = document.querySelectorAll('.history-row');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase().trim();
            const filterValue = filterSelect.value;

            tableRows.forEach(row => {
                const rwName = row.querySelector('.search-target').textContent.toLowerCase();
                const statusBadge = row.querySelector('.status-badge').textContent.trim();

                const matchesSearch = rwName.includes(searchText);
                const matchesFilter = (filterValue === 'ALL' || statusBadge === filterValue);

                if (matchesSearch && matchesFilter) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none'; 
                }
            });
        }

        // Panggil fungsi yang sama saat ngetik di searchbar ATAU milih dropdown
        searchInput.addEventListener('input', filterTable);
        filterSelect.addEventListener('change', filterTable);
    </script>
</body>
</html>