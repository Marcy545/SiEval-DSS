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
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
<body class="antialiased bg-white text-slate-900 overflow-x-hidden">

    <nav class="flex items-center justify-between px-6 md:px-24 py-5 bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0 shadow-sm">
                <img src="{{ asset('images/logo 1.png') }}" alt="Logo SiEval DSS" class="w-full h-full object-cover">
            </div>
            <span class="font-bold text-xl tracking-tight text-slate-900">SiEval DSS</span>
        </div>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-500">
            <a href="#" class="text-slate-950 font-semibold">Home</a>
            <a href="#cara-kerja" class="hover:text-slate-950 transition">Tentang</a>
            <a href="#fitur" class="hover:text-slate-950 transition">Fitur</a>
        </div>

        <div class="hidden md:flex items-center gap-4">
            <button onclick="openModal('login')" class="px-6 py-2.5 text-sm font-semibold border border-slate-200 rounded-full hover:bg-slate-50 transition active:scale-95">Masuk</button>
            <button onclick="openModal('register')" class="px-6 py-2.5 text-sm font-semibold bg-slate-950 text-white rounded-full hover:bg-slate-800 transition shadow-sm active:scale-95">Daftar</button>
        </div>

        <button onclick="toggleMobileMenu()" class="block md:hidden p-2 text-slate-900 hover:bg-slate-100 rounded-xl transition">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </nav>

    <div id="mobileMenuModal" class="fixed inset-0 z-50 hidden bg-slate-950/40 backdrop-blur-sm justify-end p-4" onclick="toggleMobileMenu()">
        <div class="bg-white w-72 h-fit rounded-3xl p-6 shadow-2xl flex flex-col space-y-6 transform transition-transform" onclick="event.stopPropagation()">
            <div class="flex justify-end">
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-400 hover:text-slate-900 rounded-full transition">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-4 font-semibold text-slate-600 px-2">
                <a href="#" class="text-slate-950 text-lg flex items-center gap-2"><div class="w-1.5 h-1.5 bg-slate-950 rounded-full"></div> Home</a>
                <a href="#cara-kerja" class="hover:text-slate-950 text-lg transition">Tentang</a>
                <a href="#fitur" class="hover:text-slate-950 text-lg transition">Fitur</a>
            </nav>
            <div class="flex flex-col gap-3 pt-4 border-t border-slate-100">
                <button onclick="toggleMobileMenu(); openModal('login');" class="w-full py-3 text-sm font-bold border border-slate-300 rounded-full hover:bg-slate-50 transition">Masuk</button>
                <button onclick="toggleMobileMenu(); openModal('register');" class="w-full py-3 text-sm font-bold bg-slate-950 text-white rounded-full hover:bg-slate-900 transition">Daftar</button>
            </div>
        </div>
    </div>

    <section class="mx-0 md:mx-5 my-0 md:my-3 relative">
        <div class="bg-slate-950 rounded-none md:rounded-[40px] pt-20 pb-16 px-6 md:px-12 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-4xl mx-auto relative z-10 mb-14">
                <h1 class="text-3xl md:text-[54px] font-bold leading-tight tracking-tight mb-6 max-w-4xl mx-auto">
                    Wujudkan Distribusi Bantuan Banjir Objektif, Transparan, dan Terukur
                </h1>
                <p class="text-slate-400 text-sm md:text-base max-w-3xl mx-auto leading-relaxed px-4 mb-10">
                    SiEval DSS menghubungkan laporan warga langsung ke dashboard kecamatan secara real-time. Rekomendasi AI yang transparan memastikan setiap bantuan jatuh ke tangan yang paling membutuhkan.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-md mx-auto sm:max-w-none px-4">
                    <a href="/register" class="px-8 py-3.5 border border-slate-700 rounded-full font-medium text-sm hover:bg-slate-900 transition tracking-wide active:scale-98">
                        Laporkan Banjir (Warga)
                    </a>
                    <a href="/login?role=kecamatan" class="px-8 py-3.5 bg-white text-slate-950 rounded-full font-medium text-sm hover:bg-slate-100 transition tracking-wide shadow-md active:scale-98">
                        Lihat Dashboard (Kecamatan)
                    </a>
                </div>
            </div>
            
            <div class="max-w-6xl mx-auto relative z-10 mt-6 px-2 md:px-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end justify-center">
                    <div class="md:col-span-4 flex justify-center max-w-[260px] md:max-w-none mx-auto w-full">
                        <img src="{{ asset('images/Form RW 1.png') }}" alt="Form RW Mobile View" class="rounded-xl w-full shadow-2xl border border-slate-800/80 transition-transform duration-300 hover:scale-[1.02]">
                    </div>
                    <div class="md:col-span-8 w-full">
                        <img src="{{ asset('images/Dashboard 1.png') }}" alt="Dashboard Kecamatan Web View" class="rounded-xl w-full shadow-2xl border border-slate-800/80 transition-transform duration-300 hover:scale-[1.01]">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="py-20 md:py-24 px-6 md:px-24 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-16 items-start">
            <div class="md:col-span-5 sticky top-28">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight leading-tight mb-4">Dari Laporan Warga ke Bantuan Tepat Sasaran</h2>
                <p class="text-slate-400 text-sm md:text-base leading-relaxed">Langkah sederhana yang menghubungkan warga, data, AI, dan keputusan kecamatan dalam satu alur terintegrasi.</p>
            </div>
            
            <div class="md:col-span-7 space-y-10 relative pl-4">
                <div class="absolute top-4 bottom-4 left-9 w-[2px] bg-slate-900 pointer-events-none hidden sm:block"></div>

                <div class="flex flex-col sm:flex-row gap-6 relative z-10">
                    <div class="flex-none w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">1</div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-lg">Input Laporan Kerugian Banjir</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">RW sebagai perwakilan warga mengisi form laporan kerugian yang berisi estimasi kerusakan, kondisi warga, dan upload foto banjir. Hasil laporan akan masuk ke database kecamatan secara real-time.</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-6 relative z-10">
                    <div class="flex-none w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">2</div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-lg">Data Laporan Tersaji Lengkap</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Petugas kecamatan dapat melihat data laporan banjir yang diinputkan warga seperti heatmap real-time, grafik ketinggian air per RW, dan tabel warga berdasarkan tingkat urgensi.</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-6 relative z-10">
                    <div class="flex-none w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">3</div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-lg">Peta Sebaran Banjir dan Rekomendasi Prioritas Otomatis</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">SiEval DSS akan menilai setiap laporan berdasarkan tingkat kerusakan, kondisi ekonomi keluarga, dan keberadaan anak/lansia. Output: Peta sebaran banjir dan skoring otomatis tingkat keparahan banjir.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white px-6 md:px-24 border-t border-slate-100">
        <div class="max-w-7xl mx-auto space-y-12">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-slate-900 tracking-tight">Fitur Utama SiEval DSS</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['n' => '1', 't' => 'Form Laporan Warga (RW)', 'd' => 'Halaman khusus untuk warga terutama RW agar dapat melaporkan banjir di wilayahnya dan nantinya data tersebut akan dikirimkan ke halaman kecamatan.'],
                        ['n' => '2', 't' => 'Dashboard Banjir', 'd' => 'Ringkasan mengenai data banjir meliputi peringatan evakuasi segera, data sektor terdampak, ketinggian air, hingga zona banjir.'],
                        ['n' => '3', 't' => 'Peta Sebaran Banjir', 'd' => 'Visualisasi sebaran banjir per lokasi. Warna merah = parah, kuning = sedang, hijau = ringan. Petugas kecamatan bisa lihat posisi dan kondisi area banjir.'],
                        ['n' => '4', 't' => 'AI Scoring dan Prioritas Bantuan', 'd' => 'Penilaian objektif berbasis data lapangan. Skoring prioritas 1–100 disertai alasan yang transparan dan bisa dijelaskan ke warga.'],
                        ['n' => '5', 't' => 'Notifikasi', 'd' => 'Push notification otomatis saat laporan diproses, prioritas diputuskan, atau jadwal pengambilan bantuan ditentukan.'],
                        ['n' => '6', 't' => 'Histori Banjir', 'd' => 'Data banjir lintas waktu untuk identifikasi hotspot berulang dan rekomendasi mitigasi infrastruktur jangka panjang.'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200/70 hover:shadow-md transition duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 bg-slate-950 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-sm">{{ $f['n'] }}</div>
                        <h4 class="font-bold text-xl text-slate-900 tracking-tight">{{ $f['t'] }}</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $f['d'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-0 md:mx-6 my-12">
        <div class="bg-slate-950 rounded-none md:rounded-[40px] py-16 px-6 text-center text-white relative overflow-hidden">
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[500px] h-[200px] bg-blue-500/10 blur-[100px] rounded-full pointer-events-none"></div>
            <div class="max-w-3xl mx-auto space-y-4 relative z-10 mb-8">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight">Siap Menggunakan SiEval DSS?</h2>
                <p class="text-slate-400 text-sm md:text-base max-w-xl mx-auto leading-relaxed">Gratis untuk pemerintah lokal Bojongsoang. Setup selesai dalam 1–2 hari kerja, termasuk training admin dan RT. Tim support siap 24/7 saat banjir terjadi.</p>
            </div>
            <div class="flex flex-col sm:flex-row justify-center gap-3.5 max-w-xs mx-auto sm:max-w-none relative z-10 px-4">
                <a href="/register" class="px-8 py-3.5 border border-slate-700 hover:bg-slate-900 transition rounded-full font-bold text-sm tracking-wide active:scale-98">Laporkan Banjir (Warga)</a>
                <a href="/login?role=kecamatan" class="px-8 py-3.5 bg-white text-slate-950 hover:bg-slate-100 transition rounded-full font-bold text-sm tracking-wide shadow-md active:scale-98">Lihat Dashboard (Kecamatan)</a>
            </div>
        </div>
    </section>

    <footer class="px-6 md:px-24 py-16 border-t border-slate-100 text-sm text-slate-400 bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-4 items-start">
            <div class="md:col-span-6 space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-full overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0 shadow-sm">
                        <img src="{{ asset('images/logo 1.png') }}" alt="Logo SiEval DSS" class="w-full h-full object-cover">
                    </div>
                    <span class="font-bold text-lg text-slate-900">SiEval DSS</span>
                </div>
                <p class="max-w-xs leading-relaxed text-xs text-slate-400">Jl. Telekomunikasi No 1, Terusan Buah Batu, Bojongsoang, Kabupaten Bandung, Jawa Barat.</p>
            </div>
            <div class="md:col-span-2 space-y-4">
                <h5 class="font-bold text-slate-900 text-base">Home</h5>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="#" class="hover:text-slate-950 transition">Header</a></li>
                    <li><a href="#" class="hover:text-slate-950 transition">Get started</a></li>
                </ul>
            </div>
            <div class="md:col-span-2 space-y-4">
                <h5 class="font-bold text-slate-900 text-base">Tentang</h5>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="#cara-kerja" class="hover:text-slate-950 transition">Cara kerja</a></li>
                    <li><a href="#cara-kerja" class="hover:text-slate-950 transition">Mengapa kami</a></li>
                </ul>
            </div>
            <div class="md:col-span-2 space-y-4">
                <h5 class="font-bold text-slate-900 text-base">Fitur</h5>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="#fitur" class="hover:text-slate-950 transition">Fitur kami</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-slate-100 text-center text-xs text-slate-400 font-medium">
            © 2026 SiEval DSS. All rights reserved.
        </div>
    </footer>

    <div id="authModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-2xl rounded-[32px] p-8 md:p-10 relative shadow-2xl border border-slate-100" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute right-6 top-6 p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-full transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <h2 id="modalTitle" class="text-xl md:text-2xl font-bold mb-6 md:mb-8 text-slate-900 tracking-tight">Masuk ke SiEval DSS sebagai:</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                <a href="#" id="linkWarga" class="group border border-slate-200/80 rounded-2xl p-5 md:p-6 hover:border-blue-500 hover:bg-blue-50/40 transition-all duration-200 relative overflow-hidden flex flex-col justify-between min-h-[140px]">
                    <div class="relative z-10">
                        <h3 class="font-bold text-base md:text-lg mb-1.5 text-slate-900 group-hover:text-blue-600 transition-colors">Warga (RW)</h3>
                        <p id="descWarga" class="text-slate-500 text-xs md:text-sm leading-relaxed">Laporkan data banjir di wilayah Anda untuk memudahkan pendataan.</p>
                    </div>
                </a>
                <a href="#" id="linkKecamatan" class="group border border-slate-200/80 rounded-2xl p-5 md:p-6 hover:border-blue-500 hover:bg-blue-50/40 transition-all duration-200 relative overflow-hidden flex flex-col justify-between min-h-[140px]">
                    <div class="relative z-10">
                        <h3 class="font-bold text-base md:text-lg mb-1.5 text-slate-900 group-hover:text-blue-600 transition-colors">Kecamatan</h3>
                        <p id="descKecamatan" class="text-slate-500 text-xs md:text-sm leading-relaxed">Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran dan akurat.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

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
            const modal = document.getElementById('authModal');
            const title = document.getElementById('modalTitle');
            const linkWarga = document.getElementById('linkWarga');
            const linkKecamatan = document.getElementById('linkKecamatan');
            const descKecamatan = document.getElementById('descKecamatan');

            if (type === 'login') {
                title.innerText = "Masuk ke SiEval DSS sebagai:";
                linkWarga.href = "/login?role=rw"; 
                linkKecamatan.href = "/login?role=kecamatan"; 
                descKecamatan.innerText = "Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran dan akurat";
            } else {
                title.innerText = "Daftar Akun SiEval DSS sebagai:";
                linkWarga.href = "/register"; 
                linkKecamatan.href = "/login?role=kecamatan"; 
                descKecamatan.innerHTML = "Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran dan akurat";
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
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