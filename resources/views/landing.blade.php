<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiEval DSS - Bojongsoang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-slate-900 overflow-x-hidden">

    <nav class="flex items-center justify-between px-6 md:px-12 py-5 bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2.5">
            <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0 shadow-sm">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SiEval DSS" class="w-full h-full object-cover">
            </div>
            <span class="font-extrabold text-xl tracking-tight text-slate-900">SiEval DSS</span>
        </div>

        <div class="hidden md:flex items-center gap-3">
            <button onclick="openModal('login')" class="px-6 py-2 text-sm font-semibold border border-slate-200 rounded-full hover:bg-slate-50 transition active:scale-95">Masuk</button>
            <button onclick="openModal('register')" class="px-6 py-2 text-sm font-semibold bg-slate-950 text-white rounded-full hover:bg-slate-800 transition shadow-sm active:scale-95">Daftar</button>
        </div>

        <button onclick="toggleMobileMenu()" class="block md:hidden p-2 text-slate-900 hover:bg-slate-100 rounded-xl transition">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </nav>

    <div id="mobileMenuModal" class="fixed inset-0 z-50 hidden bg-slate-950/40 backdrop-blur-sm justify-end p-4 animate-in fade-in duration-200" onclick="toggleMobileMenu()">
        <div class="bg-white w-72 h-fit rounded-3xl p-6 shadow-2xl flex flex-col space-y-6 transform translate-x-4 transition-transform" onclick="event.stopPropagation()">
            <div class="flex justify-end">
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-full transition">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-4 font-semibold text-slate-600 px-2">
                <a href="#" class="text-slate-950 text-lg flex items-center gap-2"><div class="w-1.5 h-1.5 bg-slate-950 rounded-full"></div> Beranda</a>
                <a href="#cara-kerja" class="hover:text-slate-950 text-lg py-1 transition">Tentang</a>
                <a href="#fitur" class="hover:text-slate-950 text-lg py-1 transition">Fitur</a>
            </nav>
            <div class="flex flex-col gap-3 pt-4 border-t border-slate-100">
                <button onclick="toggleMobileMenu(); openModal('login');" class="w-full py-3 text-sm font-bold border border-slate-300 rounded-full hover:bg-slate-50 transition">Masuk</button>
                <button onclick="toggleMobileMenu(); openModal('register');" class="w-full py-3 text-sm font-bold bg-slate-950 text-white rounded-full hover:bg-slate-900 transition shadow-md">Daftar</button>
            </div>
        </div>
    </div>

    <section class="bg-slate-950 pt-16 md:pt-24 pb-12 px-6 text-center text-white relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-4xl mx-auto relative z-10">
            <h1 class="text-3xl md:text-6xl font-black leading-tight tracking-tight mb-5 px-2 md:px-0">
                Wujudkan Distribusi Bantuan Banjir Objektif, Transparan, dan Terukur
            </h1>
            <p class="text-slate-400 text-sm md:text-lg mb-8 max-w-2xl mx-auto leading-relaxed px-4">
                SiEval DSS menghubungkan laporan warga langsung ke dashboard kecamatan secara real-time. Rekomendasi AI yang transparan memastikan setiap bantuan jatuh ke tangan yang paling membutuhkan.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-3.5 max-w-md mx-auto sm:max-w-none mb-12 md:mb-16 px-4">
                <button onclick="openModal('register')" class="px-7 py-3 border border-slate-700 rounded-full font-bold text-sm hover:bg-slate-900 transition tracking-wide active:scale-98">
                    Laporan Banjir (Warga)
                </button>
                <button onclick="openModal('login')" class="px-7 py-3 bg-white text-slate-950 rounded-full font-bold text-sm hover:bg-slate-100 transition tracking-wide shadow-md active:scale-98">
                    Lihat Dashboard (Kecamatan)
                </button>
            </div>
        </div>
        
        <div class="max-w-5xl mx-auto mt-6 px-2 md:px-6">
            <div class="bg-slate-900/40 border border-slate-800 rounded-[32px] p-4 md:p-6 shadow-2xl backdrop-blur-md">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end justify-center">
                    <div class="md:col-span-4 flex justify-center order-2 md:order-1 max-w-[240px] mx-auto md:w-full">
                        <img src="{{ asset('images/Form RW 1.png') }}" alt="Form RW Mobile View" class="rounded-2xl w-full shadow-2xl border border-slate-700/50">
                    </div>
                    <div class="md:col-span-8 order-1 md:order-2">
                        <img src="{{ asset('images/Dashboard 1.png') }}" alt="Dashboard Kecamatan Web View" class="rounded-2xl w-full shadow-xl border border-slate-700/50">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="py-20 md:py-28 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 md:gap-20 items-start">
            <div class="sticky top-24">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-5">Dari Laporan Warga ke Bantuan Tepat Sasaran</h2>
                <p class="text-slate-500 font-medium leading-relaxed">Langkah sederhana yang menghubungkan warga, data, AI, dan keputusan kecamatan dalam satu alur terintegrasi.</p>
            </div>
            <div class="space-y-12">
                <div class="flex gap-5">
                    <div class="flex-none w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-black text-sm shadow-md">1</div>
                    <div class="space-y-1">
                        <h4 class="font-extrabold text-slate-900 text-lg">Input Laporan Kerugian Banjir</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">RW sebagai perwakilan warga mengisi form laporan kerugian yang berisi estimasi kerusakan, kondisi warga, and upload foto banjir.</p>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex-none w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-black text-sm shadow-md">2</div>
                    <div class="space-y-1">
                        <h4 class="font-extrabold text-slate-900 text-lg">Data Laporan Tersaji Lengkap</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Petugas kecamatan dapat melihat data laporan banjir yang diinputkan warga seperti heatmap real-time, grafik ketinggian air per RW, and tabel warga berdasarkan tingkat urgensi.</p>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex-none w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-black text-sm shadow-md">3</div>
                    <div class="space-y-1">
                        <h4 class="font-extrabold text-slate-900 text-lg">Visualisasi Sebaran Banjir dan Rekomendasi Otomatis</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">SiEval DSS akan menilai setiap laporan secara objektif berdasarkan tingkat kerusakan material, kondisi ekonomi, and keberadaan kelompok rentan (lansia/bayi).</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-slate-50 px-6 md:px-12 border-y border-slate-100">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-black text-center text-slate-900 tracking-tight mb-16">Fitur Utama SiEval DSS</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @php
                    $features = [
                        ['n' => '1', 't' => 'Form Laporan Warga (RW)', 'd' => 'Halaman khusus warga terutama perangkat RW agar dapat melaporkan titik krisis banjir di wilayahnya secara cepat.'],
                        ['n' => '2', 't' => 'Dashboard Banjir', 'd' => 'Ringkasan visual terintegrasi meliputi peringatan darurat evakuasi, grafik tinggi air, and rekapitulasi kerugian.'],
                        ['n' => '3', 't' => 'Peta Sebaran Banjir', 'd' => 'Visualisasi pemetaan berbasis awan panas (heatmap) untuk melacak hotspot bencana paling kritis secara real-time.'],
                        ['n' => '4', 't' => 'AI Scoring & Prioritas', 'd' => 'Sistem pendukung keputusan objektif untuk menetapkan skor prioritas urgensi pengiriman paket bantuan logistik.'],
                        ['n' => '5', 't' => 'Sistem Notifikasi Darurat', 'd' => 'Distribusi status penanganan krisis otomatis saat laporan sedang divalidasi atau jadwal distribusi logistik dirilis.'],
                        ['n' => '6', 't' => 'Histori Lintas Waktu', 'd' => 'Rekaman rekapan banjir lintas periode guna mendeteksi tren hotspot berulang untuk rancangan mitigasi jangka panjang.'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-200/60 hover:shadow-md transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 bg-slate-950 text-white rounded-full flex items-center justify-center font-black text-xs mb-6 shadow-sm">{{ $f['n'] }}</div>
                        <h4 class="font-extrabold text-slate-900 text-lg mb-2 tracking-tight">{{ $f['t'] }}</h4>
                        <p class="text-slate-500 text-xs md:text-sm leading-relaxed">{{ $f['d'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-4 md:mx-12 my-20 bg-slate-950 rounded-[40px] py-16 md:py-20 px-6 text-center text-white relative overflow-hidden">
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[500px] h-[200px] bg-blue-500/10 blur-[100px] rounded-full pointer-events-none"></div>
        <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-4 relative z-10">Ready Menjalankan SiEval DSS?</h2>
        <p class="text-slate-400 text-sm md:text-base mb-8 max-w-xl mx-auto relative z-10">Sistem koordinasi bencana gratis untuk kelurahan dan warga desa se-Kecamatan Bojongsoang. Setup sistem selesai kilat.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 max-w-xs mx-auto sm:max-w-none relative z-10 px-4">
            <button onclick="openModal('register')" class="px-7 py-3 border border-slate-700 hover:bg-slate-900 transition rounded-full font-bold text-sm tracking-wide active:scale-98">Laporan Banjir (Warga)</button>
            <button onclick="openModal('login')" class="px-7 py-3 bg-white text-slate-950 hover:bg-slate-100 transition rounded-full font-bold text-sm tracking-wide shadow-md active:scale-98">Lihat Dashboard (Kecamatan)</button>
        </div>
    </section>

    <footer class="px-6 md:px-12 py-16 border-t border-slate-100 text-sm text-slate-500">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-12">
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-full overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SiEval DSS" class="w-full h-full object-cover">
                    </div>
                    <span class="font-black text-base text-slate-900">SiEval DSS</span>
                </div>
                <p class="max-w-xs leading-relaxed text-xs">Jl. Telekomunikasi No 1, Terusan Buah Batu, Sukapura, Kec. Bojongsoang, Kabupaten Bandung, Jawa Barat 40257.</p>
            </div>
            <div>
                <h5 class="font-extrabold text-slate-900 mb-4">Navigasi</h5>
                <ul class="space-y-2.5 text-xs font-medium">
                    <li><a href="#" class="hover:text-slate-950 transition">Beranda Utama</a></li>
                    <li><a href="#fitur" class="hover:text-slate-950 transition">Fitur Penentu</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-extrabold text-slate-900 mb-4">Tentang</h5>
                <ul class="space-y-2.5 text-xs font-medium">
                    <li><a href="#cara-kerja" class="hover:text-slate-950 transition">Alur Kerja Sistem</a></li>
                    <li><a href="https://telkomuniversity.ac.id" target="_blank" class="hover:text-slate-950 transition">Telkom University</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-slate-100 text-center text-xs text-slate-400 font-medium">
            © 2026 SiEval DSS project. Built with precision for sustainable disaster relief.
        </div>
    </footer>

    <div id="authModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 animate-in fade-in duration-200">
        <div class="bg-white w-full max-w-2xl rounded-[32px] p-8 md:p-10 relative shadow-2xl border border-slate-100" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute right-6 top-6 md:right-8 md:top-8 p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-full transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h2 id="modalTitle" class="text-xl md:text-2xl font-black mb-6 md:mb-8 text-slate-900 tracking-tight">Masuk ke SiEval DSS sebagai:</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:grid-cols-2 md:gap-6">
                {{-- FIX UTAMA: Mengubah tag <a> di dalam modal agar memanggil fungsi javascript tersendiri, bukan href kosong --}}
                <button id="btnWarga" onclick="redirectToAuth('rw')" class="group text-left border border-slate-200/80 rounded-2xl p-5 md:p-6 hover:border-blue-500 hover:bg-blue-50/40 transition-all duration-200 relative overflow-hidden flex flex-col justify-between cursor-pointer">
                    <div class="relative z-10">
                        <h3 class="font-extrabold text-base md:text-lg mb-1.5 text-slate-900 group-hover:text-blue-600 transition-colors">Warga (RW)</h3>
                        <p id="descWarga" class="text-slate-500 text-xs md:text-sm leading-relaxed">Laporkan data banjir di wilayah Anda untuk memudahkan pendisribusian logistik darurat.</p>
                    </div>
                </button>
                <button id="btnKecamatan" onclick="redirectToAuth('kecamatan')" class="group text-left border border-slate-200/80 rounded-2xl p-5 md:p-6 hover:border-blue-500 hover:bg-blue-50/40 transition-all duration-200 relative overflow-hidden flex flex-col justify-between cursor-pointer">
                    <div class="relative z-10">
                        <h3 class="font-extrabold text-base md:text-lg mb-1.5 text-slate-900 group-hover:text-blue-600 transition-colors">Kecamatan</h3>
                        <p id="descKecamatan" class="text-slate-500 text-xs md:text-sm leading-relaxed">Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran berbasis algoritma keputusan AI.</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Menyimpan status jenis modal ('login' atau 'register') yang sedang aktif
        let currentModalType = 'login';

        function toggleMobileMenu() {
            const menuModal = document.getElementById('mobileMenuModal');
            if (menuModal.classList.contains('hidden')) {
                menuModal.classList.remove('hidden');
                menuModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            } else {
                menuModal.classList.add('hidden');
                menuModal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        function openModal(type) {
            currentModalType = type; // Catat tipe modal saat dibuka
            const modal = document.getElementById('authModal');
            const title = document.getElementById('modalTitle');
            const descKecamatan = document.getElementById('descKecamatan');

            if (type === 'login') {
                title.innerText = "Masuk ke SiEval DSS sebagai:";
                descKecamatan.innerText = "Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran berbasis algoritma keputusan AI.";
            } else {
                title.innerText = "Daftar Akun SiEval DSS sebagai:";
                descKecamatan.innerHTML = "Akses otorisasi akun Kecamatan dikunci penuh oleh Administrator. Silakan login menggunakan akun terdaftar.";
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        // FUNGSI BARU: Eksekusi pengalihan URL yang aman dan mutlak tanpa tersangkut rute html bawaan
        function redirectToAuth(role) {
            if (currentModalType === 'login') {
                window.location.href = "/login?role=" + role;
            } else {
                if (role === 'kecamatan') {
                    window.location.href = "/login?role=kecamatan";
                } else {
                    window.location.href = "/register";
                }
            }
        }

        function closeModal() {
            const modal = document.getElementById('authModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            const authModal = document.getElementById('authModal');
            if (event.target == authModal) {
                closeModal();
            }
        }
    </script>
</body>
</html>