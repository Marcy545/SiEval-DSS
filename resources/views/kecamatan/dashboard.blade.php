<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Camat - SiEval DSS</title>
    
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex shrink-0">
        <div>
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-900 rounded-full flex items-center justify-center text-white">
                    <img src="{{ url('/kecamatan/laporan/foto/logo.png') }}" alt="Logo SiEval DSS" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">SiEval DSS</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Kec. Bojongsoang</p>
                </div>
            </div>

            <nav class="px-4 space-y-1 mt-4">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 bg-slate-100 text-slate-900 rounded-lg font-semibold text-sm transition">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-slate-700"></i> Dashboard
                </a>
                <a href="{{ route('kecamatan.peta') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm transition">
                    <i data-lucide="map" class="w-5 h-5"></i> Peta Sebaran
                </a>
                <a href="{{ route('kecamatan.history') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm transition">
                    <i data-lucide="history" class="w-5 h-5"></i> Histori Banjir
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-200 space-y-3">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-xs">
                    CM
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
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Dashboard Banjir Bojongsoang</h2>
            <div class="flex items-center gap-4">
                <div class="relative hidden lg:block">
                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"></i>
                    <input type="text" id="navbarSearch" placeholder="Cari wilayah RW..." class="bg-slate-100 border border-slate-200 text-sm rounded-full pl-9 pr-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-6">
            
            @if($darurat)
                @php
                    $score = $darurat->priority_score ?? 0;

                    if ($score >= 85) {
                        $warnaBg = 'bg-red-600';
                        $warnaText = 'text-red-100';
                        $label = 'KRITIS';
                        $pesan = 'Permintaan penjemputan darurat BPBD pusat.';
                    } elseif ($score >= 70) {
                        $warnaBg = 'bg-orange-500';
                        $warnaText = 'text-orange-100';
                        $label = 'DARURAT';
                        $pesan = 'Evakuasi warga prioritas sedang berlangsung.';
                    } else {
                        $warnaBg = 'bg-yellow-500';
                        $warnaText = 'text-yellow-100';
                        $label = 'SIAGA';
                        $pesan = 'Wilayah membutuhkan pemantauan intensif.';
                    }

                    $nomorWa = optional($darurat->user)->no_hp;

                    if ($nomorWa) {
                        // bersihin selain angka
                        $nomorWa = preg_replace('/[^0-9]/', '', $nomorWa);

                        // ubah 08 jadi 628
                        if (substr($nomorWa, 0, 1) == '0') {
                            $nomorWa = '62' . substr($nomorWa, 1);
                        }

                        $pesanWa = urlencode(
                            "Halo Ketua RW {$darurat->rw_kelurahan}, kami dari Kecamatan Bojongsoang menerima laporan banjir dengan status {$label}. Mohon segera memberikan update kondisi terbaru di lokasi."
                        );

                        $linkWa = "https://wa.me/{$nomorWa}?text={$pesanWa}";
                    } else {
                        $linkWa = null;
                    }
                @endphp

                <div class="{{ $warnaBg }} rounded-2xl px-6 py-4 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                            <i data-lucide="triangle-alert" class="w-6 h-6 text-white"></i>
                        </div>

                        <div>
                            <h2 class="text-white font-bold text-lg leading-tight">
                                Peringatan Evakuasi Segera: {{ $darurat->rw_kelurahan }}
                            </h2>

                            <p class="text-sm {{ $warnaText }} mt-1">
                                Tingkat air mencapai {{ $darurat->ketinggian_air }} cm. {{ $pesan }}
                            </p>

                            <div class="flex items-center gap-2 mt-3">
                                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-bold">
                                    SCORE {{ $score }}
                                </span>
                                <span class="bg-black/20 text-white text-xs px-3 py-1 rounded-full font-bold">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL DIUBAH MEMANGGIL CUSTOM MODAL JIKA WA TIDAK ADA --}}
                    <a 
                        href="{{ $nomorWa ? $linkWa : 'javascript:void(0)' }}"
                        target="{{ $nomorWa ? '_blank' : '' }}"
                        
                        @if(!$nomorWa)
                            onclick="openAlertModal()"
                        @endif

                        class="bg-white text-slate-900 px-5 py-2.5 rounded-full text-sm font-bold hover:bg-slate-100 transition shrink-0 whitespace-nowrap"
                    >
                        Hubungi RW
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-xs font-semibold text-slate-500 tracking-wider">Keluarga Terdampak</p>
                        <i data-lucide="users" class="w-5 h-5 text-red-500"></i>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <h3 class="text-3xl font-bold text-slate-800">{{ number_format($total_kk ?? 0) }}</h3>
                        <span class="text-sm font-medium text-slate-500">KK</span>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-xs font-semibold text-slate-500 tracking-wider">Laporan Masuk (Keseluruhan Wilayah)</p>
                        <i data-lucide="building-2" class="w-5 h-5 text-blue-500"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 mb-2">{{ $rw_melapor ?? 0 }}/{{ $total_rw ?? 96 }}</h3>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-slate-800 h-full rounded-full" style="width: {{ $persentase_laporan ?? 0 }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-slate-600">{{ $persentase_laporan ?? 0 }}%</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col min-h-[380px] h-auto justify-between">
                    <h3 class="text-sm font-bold text-slate-800 mb-2">Sektor Terdampak</h3>
                    
                    <div class="relative w-full h-40 flex justify-center items-center">
                        <canvas id="donutChart"></canvas>
                    </div>
                    
                    @if(isset($list_fasum) && $list_fasum->isNotEmpty())
                        @php
                            $fasum_unik = $list_fasum->pluck('fasum_terdampak')
                                ->flatMap(function ($item) {
                                    return explode(',', $item);
                                })
                                ->map(function ($item) {
                                    return ucwords(trim(strtolower($item)));
                                })
                                ->filter()
                                ->countBy();
                        @endphp

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Rincian Fasilitas Publik:</p>
                            <div class="overflow-y-auto max-h-24 pr-1 space-y-1">
                                @foreach($fasum_unik as $nama_fasum => $jumlah)
                                    <div class="flex items-center justify-between text-xs text-slate-600 py-0.5">
                                        <div class="flex items-center gap-1.5">
                                            <i data-lucide="building" class="w-3 h-3 text-blue-500 shrink-0"></i>
                                            <span class="leading-tight font-medium text-slate-700">
                                                {{ $nama_fasum }}
                                            </span>
                                        </div>
                                        <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                            {{ $jumlah }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                            <p class="text-xs text-slate-400 font-medium">Belum ada fasilitas publik yang dilaporkan terdampak.</p>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-slate-200 shadow-sm min-h-[380px] h-auto flex flex-col justify-between">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Ketinggian Air (cm)</h3>
                    <div class="relative flex-1 min-h-[200px]">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-white">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Zona Banjir</h3>
                    <div class="relative inline-block text-left">
                        <select id="tableFilter" class="text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 rounded-lg px-3 py-2 pr-8 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                            <option value="ALL">Semua Status</option>
                            <option value="PARAH">Status: PARAH</option>
                            <option value="SEDANG">Status: SEDANG</option>
                            <option value="RENDAH">Status: RENDAH</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-2.5 pointer-events-none"></i>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="floodTable">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold border-b border-slate-200">
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama RW</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Ketinggian Air (CM)</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Jumlah KK</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Tanggal Kejadian</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Status Keparahan</th>
                                <th class="px-6 py-4 font-semibold text-right whitespace-nowrap">Aキシ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($lSimple_laporan_terbaru ?? $laporan_terbaru as $laporan)
                            <tr class="hover:bg-slate-50/80 transition data-row">
                                <td class="px-6 py-5 whitespace-nowrap search-target">
                                    <p class="text-sm font-bold text-slate-900 leading-tight">{{ $laporan->rw_kelurahan }}</p>
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
                                    <span class="text-[10px] font-bold tracking-wider px-3 py-1 rounded-full uppercase inline-block status-badge
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
                                        <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                                        <span class="font-medium">Belum ada data laporan banjir dari pihak RW.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 text-center bg-white">
                    <a href="{{ route('kecamatan.history') }}" class="text-xs font-bold text-slate-900 uppercase tracking-wider hover:text-slate-700 transition">
                        Lihat Lainnya
                    </a>
                </div>
            </div>

        </div>
    </main>

    {{-- CUSTOM ALERT MODAL POPUP (TAILWIND STYLING) --}}
    <div id="customAlertModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm hidden z-[110] items-center justify-center p-4 transition-all opacity-0 duration-300" onclick="closeAlertModal()">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-all duration-300" onclick="event.stopPropagation()">
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 shadow-inner">
                    <i data-lucide="phone-off" class="w-6 h-6"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-base font-bold text-slate-900">Kontak Tidak Tersedia</h4>
                    <p class="text-xs font-medium text-slate-500 leading-relaxed">Maaf, nomor HP atau kontak WhatsApp untuk Ketua RW ini tidak valid atau belum terdaftar di sistem.</p>
                </div>
                <button onclick="closeAlertModal()" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs py-3 rounded-xl transition active:scale-98 shadow-sm tracking-wide">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // JS LIVE SEARCH & LIVE FILTER
        const searchInput = document.getElementById('navbarSearch');
        const filterSelect = document.getElementById('tableFilter');
        const tableRows = document.querySelectorAll('.data-row');

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


        // INSTANSI GRAFIK CHART JS
        const rwLabels = {!! json_encode($chart_ketinggian->pluck('rw_kelurahan') ?? []) !!};
        const airData = {!! json_encode($chart_ketinggian->pluck('ketinggian_air') ?? []) !!};

        const rumahTerdampak = {{ $sum_rumah ?? 0 }};
        const tokoTerdampak = {{ $sum_toko ?? 0 }};
        const fasumTerdampak = {{ $sum_fasum ?? 0 }};

        // Donut Chart
        const ctxDonut = document.getElementById('donutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Perumahan', 'Bisnis/Toko', 'Fasum'],
                datasets: [{
                    data: [rumahTerdampak, tokoTerdampak, fasumTerdampak],
                    backgroundColor: ['#0F172A', '#E02928', '#3B82F6'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: true,
                        position: 'bottom',
                        labels: { 
                            usePointStyle: true, 
                            boxWidth: 8,
                            padding: 10,
                            font: { family: 'Inter', size: 11, weight: '500' }
                        } 
                    }
                }
            }
        });

        // Bar Chart
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: rwLabels.length > 0 ? rwLabels : ['Belum Ada Data'],
                datasets: [{
                    label: 'Ketinggian Air (cm)',
                    data: airData.length > 0 ? airData : [0],
                    backgroundColor: function(context) {
                        const val = context.dataset.data[context.dataIndex];
                        if(val >= 150) return '#E02928'; 
                        if(val >= 100) return '#F59E0B'; 
                        return '#22C55E'; 
                    },
                    borderRadius: 100,
                    barThickness: 20,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false, grid: { display: false } },
                    y: { 
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: 'Inter', weight: '600', size: 11 }, color: '#475569' }
                    }
                },
                animation: { duration: 1500, easing: 'easeOutQuart' }
            }
        });

        // CUSTOM ALERT MODAL FUNCTIONS
        function openAlertModal() {
            const modal = document.getElementById('customAlertModal');
            const innerBox = modal.querySelector('div');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                innerBox.classList.remove('scale-95');
                innerBox.classList.add('scale-100');
            }, 10);
        }

        function closeAlertModal() {
            const modal = document.getElementById('customAlertModal');
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