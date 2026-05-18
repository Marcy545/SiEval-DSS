<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis DSS Detail - SiEval</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen pb-12">

    <header class="bg-white border-b border-slate-200 py-4 px-8 sticky top-0 z-40 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('kecamatan.dashboard') }}" class="p-2 hover:bg-slate-100 rounded-full transition">
                <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i>
            </a>
            <h1 class="text-base font-bold text-slate-900">Analisis Keputusan DSS ➔ {{ $laporan->rw_kelurahan }}</h1>
        </div>
        <span class="text-xs bg-slate-900 text-white px-3 py-1 rounded-full font-mono">REPOT-ID-#{{ $laporan->id }}</span>
    </header>

    <main class="max-w-6xl mx-auto px-6 mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex flex-col items-center justify-center text-center p-2 md:border-r border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Skor Krisis AI</p>
                    <h2 class="text-5xl font-black tracking-tight {{ $laporan->priority_score >= 75 ? 'text-red-600' : ($laporan->priority_score >= 50 ? 'text-amber-500' : 'text-green-500') }}">
                        {{ $laporan->priority_score }}<span class="text-sm text-slate-300 font-normal">/100</span>
                    </h2>
                    <span class="mt-2 px-3 py-0.5 rounded-full text-[10px] font-extrabold tracking-wide {{ $laporan->priority_score >= 75 ? 'bg-red-100 text-red-700' : ($laporan->priority_score >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                        {{ $laporan->priority_label }}
                    </span>
                </div>
                
                <div class="md:col-span-2 space-y-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1"><i data-lucide="check-square" class="w-4 h-4 text-blue-500"></i> Alasan Penentu Skor</h3>
                    <ul class="space-y-1.5 text-sm text-slate-600 font-medium">
                        @foreach($faktor_penentu as $faktor)
                        <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-900 mt-2 shrink-0"></span><span>{{ $faktor }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="bg-slate-900 text-slate-100 rounded-2xl p-6 shadow-md border border-slate-800 space-y-3">
                <h3 class="text-xs font-bold text-blue-400 uppercase tracking-widest flex items-center gap-1.5"><i data-lucide="bot" class="w-4 h-4"></i> Rekomendasi Alokasi Bantuan AI</h3>
                <p class="text-sm leading-relaxed text-slate-200 font-medium bg-slate-950/40 p-4 rounded-xl border border-white/5">
                    {!! $rekomendasi_ai !!}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50"><h3 class="text-xs font-bold text-slate-700 uppercase">Indikator Alam & Estimasi Finansial</h3></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 p-4 gap-4 bg-white">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm"><span class="text-slate-500">Tinggi Air Saat Ini</span><span class="font-bold font-mono text-slate-900">{{ $laporan->ketinggian_air }} cm</span></div>
                        <div class="flex justify-between text-sm"><span class="text-slate-500">Kecepatan Arus</span><span class="font-bold font-mono text-blue-600 bg-blue-50 px-1.5 rounded">{{ $kecepatan_arus }}</span></div>
                    </div>
                    <div class="space-y-3 sm:pl-4">
                        <div class="flex justify-between text-sm"><span class="text-slate-500">Kerugian Ekonomi</span><span class="font-bold font-mono text-red-600">Rp {{ $kerugian_ekonomi }}</span></div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500 shrink-0">Fasilitas Publik</span>
                            <span class="font-semibold text-slate-800 text-right ml-2 line-clamp-2">
                                {{ $laporan->fasum_terdampak ? $laporan->fasum_terdampak : 'Aman (Tidak Ada)' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Demografi Lapangan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Dampak KK</p>
                        <h4 class="text-xl font-extrabold text-slate-900 mt-0.5 font-mono">{{ $laporan->jumlah_kk }}</h4>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Total Jiwa</p>
                        <h4 class="text-xl font-extrabold text-slate-900 mt-0.5 font-mono">{{ $laporan->jumlah_jiwa }}</h4>
                    </div>
                </div>
                <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-amber-800 uppercase">Populasi Lansia Terjebak</p>
                        <h4 class="text-xl font-black text-amber-900 font-mono">{{ $laporan->jumlah_lansia }} <span class="text-xs font-normal">Jiwa</span></h4>
                    </div>
                    <i data-lucide="accessibility" class="w-5 h-5 text-amber-600"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-[250px] flex flex-col justify-between">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Bagan Fasilitas Tergenang</h3>
                <div class="relative flex-1"><canvas id="detailChart"></canvas></div>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
        new Chart(document.getElementById('detailChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Rumah', 'Toko/Usaha', 'Fasum'],
                datasets: [{ 
                    data: [{{ $laporan->rumah_tergenang }}, {{ $laporan->toko_terdampak }}, {{ $laporan->fasum_terdampak ? 1 : 0 }}], 
                    backgroundColor: ['#0F172A', '#E02928', '#3B82F6'], 
                    borderRadius: 6, 
                    barThickness: 24 
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    </script>
</body>
</html>