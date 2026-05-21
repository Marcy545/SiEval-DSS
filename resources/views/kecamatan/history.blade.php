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
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-3">
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">Zona Rekaman Laporan</h3>
                        <span class="text-xs font-bold bg-slate-50 border border-slate-200 text-slate-600 px-3 py-1 rounded-full font-mono">
                            Total: {{ count($laporan_all ?? []) }} Berkas
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button onclick="openPembersihanModal()" class="text-xs font-semibold bg-red-50 border border-red-200 text-red-600 rounded-lg px-3 py-2 hover:bg-red-100 transition flex items-center gap-1.5 shadow-sm">
                            <i data-lucide="calendar-range" class="w-3.5 h-3.5"></i> Pembersihan Berkala
                        </button>

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
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-slate-900 leading-tight">{{ $laporan->rw_kelurahan }}</p>
                                        
                                        @if($laporan->is_anomaly)
                                            <span class="bg-red-100 text-red-600 border border-red-200 text-[9px] font-bold px-2 py-0.5 rounded flex items-center gap-1 shadow-sm" title="Peringatan AI: Data input tidak wajar">
                                                <i data-lucide="siren" class="w-3 h-3"></i> Anomali
                                            </span>
                                        @endif
                                    </div>
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
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('kecamatan.detail_laporan', $laporan->id) }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-full text-xs font-semibold transition shadow-sm inline-block tracking-wide">
                                            Detail
                                        </a>
                                        <form action="{{ route('kecamatan.hapus_laporan', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-full transition" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
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

    {{-- 🔥 MODAL POPUP PEMBERSIHAN BERKALA (TAILWIND STYLING) --}}
    <div id="pembersihanModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm hidden z-[110] items-center justify-center p-4 transition-all opacity-0 duration-300" onclick="closePembersihanModal()">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-all duration-300" onclick="event.stopPropagation()">
            <form action="{{ route('kecamatan.hapus_berkala') }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Semua data laporan dan foto pada bulan dan tahun terpilih akan DIHAPUS PERMANEN. Anda yakin?')">
                @csrf
                @method('DELETE')
                
                <div class="flex flex-col items-center text-center space-y-3 mb-4">
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 shadow-inner">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-slate-900">Pembersihan Berkala</h4>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed mt-0.5">Pilih periode rekapitulasi data banjir lama yang ingin dihapus permanen dari ruang penyimpanan server.</p>
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    <div>
                        <label class="text-[11px] uppercase tracking-wider font-bold text-slate-400 block mb-1">Pilih Bulan</label>
                        <select name="bulan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider font-bold text-slate-400 block mb-1">Pilih Tahun</label>
                        <select name="tahun" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            @for($t = 2025; $t <= 2030; $t++)
                                <option value="{{ $t }}" {{ $t == 2026 ? 'selected' : '' }}>{{ $t }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closePembersihanModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-3 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-50 text-white font-semibold text-xs py-3 rounded-xl transition shadow-sm tracking-wide">
                        Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // JS LIVE SEARCH & LIVE FILTER
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

        searchInput.addEventListener('input', filterTable);
        filterSelect.addEventListener('change', filterTable);

        // 🔥 MODAL PEMBERSIHAN BERKALA FUNCTIONS
        function openPembersihanModal() {
            const modal = document.getElementById('pembersihanModal');
            const innerBox = modal.querySelector('div');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                innerBox.classList.remove('scale-95');
                innerBox.classList.add('scale-100');
            }, 10);
        }

        function closePembersihanModal() {
            const modal = document.getElementById('pembersihanModal');
            const innerBox = modal.querySelector('div');
            
            modal.classList.add('opacity-0');
            innerBox.classList.remove('scale-100');
            innerBox.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>