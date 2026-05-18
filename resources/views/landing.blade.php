<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiEval DSS - Bojongsoang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-['Inter'] antialiased bg-white text-slate-900">

    <nav class="flex items-center justify-between px-10 py-5 bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                <i data-lucide="layers" class="text-white w-4 h-4"></i>
            </div>
            <span class="font-bold text-xl tracking-tight">SiEval DSS</span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openModal('login')" class="px-6 py-2 text-sm font-semibold border border-gray-300 rounded-full hover:bg-gray-50 transition">Masuk</button>
            <button onclick="openModal('register')" class="px-6 py-2 text-sm font-semibold bg-black text-white rounded-full hover:bg-gray-800 transition">Daftar</button>
        </div>
    </nav>

    <section class="bg-[#111827] pt-20 pb-10 px-6 text-center text-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Wujudkan Distribusi Bantuan Banjir Objektif, Transparan, dan Terukur
            </h1>
            <p class="text-gray-400 text-lg mb-10 max-w-2xl mx-auto">
                SiEval DSS menghubungkan laporan warga langsung ke dashboard kecamatan secara real-time. Rekomendasi AI yang transparan memastikan setiap bantuan jatuh ke tangan yang paling membutuhkan.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4 mb-16">
                <a href="/register" class="px-8 py-3 bg-transparent border border-gray-600 rounded-full font-semibold hover:bg-gray-800 transition">Laporan Banjir (Warga)</a>
                <a href="/login?role=kecamatan" class="px-8 py-3 bg-white text-black rounded-full font-semibold hover:bg-gray-100 transition">Lihat Dashboard (Kecamatan)</a>
            </div>
        </div>
        
        <div class="max-w-6xl mx-auto mt-10 rounded-t-3xl border-x border-t border-gray-700 bg-gray-900/50 p-4 shadow-2xl">
            <img src="{{ asset('images/dashboard-preview.png') }}" alt="SiEval Dashboard Preview" class="rounded-t-2xl w-full shadow-lg">
        </div>
    </section>

    <section class="py-24 px-10 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl font-extrabold mb-6">Dari Laporan Warga ke Bantuan Tepat Sasaran</h2>
                <p class="text-gray-500 leading-relaxed">Langkah sederhana yang menghubungkan warga, data, AI, dan keputusan kecamatan dalam satu alur terintegrasi.</p>
            </div>
            <div class="space-y-10">
                <div class="flex gap-6">
                    <div class="flex-none w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">1</div>
                    <div>
                        <h4 class="font-bold text-lg">Input Laporan Kerugian Banjir</h4>
                        <p class="text-gray-500 text-sm mt-1">RW sebagai perwakilan warga mengisi form laporan kerugian yang berisi estimasi kerusakan, kondisi warga, dan upload foto banjir.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-none w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">2</div>
                    <div>
                        <h4 class="font-bold text-lg">Data Laporan Tersaji Lengkap</h4>
                        <p class="text-gray-500 text-sm mt-1">Petugas kecamatan dapat melihat data laporan banjir yang diinputkan warga seperti heatmap real-time, grafik ketinggian air per RW, dan tabel warga berdasarkan tingkat urgensi.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-none w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">3</div>
                    <div>
                        <h4 class="font-bold text-lg">Peta Sebaran Banjir dan Rekomendasi Prioritas Otomatis</h4>
                        <p class="text-gray-500 text-sm mt-1">SiEval DSS akan menilai setiap laporan berdasarkan tingkat kerusakan, kondisi ekonomi keluarga, dan keberadaan anak/lansia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-50 px-10">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-extrabold text-center mb-16">Fitur Utama SiEval DSS</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $features = [
                        ['n' => '1', 't' => 'Form Laporan Warga (RW)', 'd' => 'Halaman khusus warga terutama RW agar dapat melaporkan banjir di wilayahnya.'],
                        ['n' => '2', 't' => 'Dashboard Banjir', 'd' => 'Ringkasan mengenai data banjir meliputi peringatan evakuasi segera, data sektor terdampak, dll.'],
                        ['n' => '3', 't' => 'Peta Sebaran Banjir', 'd' => 'Visualisasi sebaran banjir per lokasi dengan indikator warna sesuai tingkat keparahan.'],
                        ['n' => '4', 't' => 'AI Scoring & Prioritas', 'd' => 'Penilaian objektif berbasis data lapangan untuk menentukan prioritas bantuan.'],
                        ['n' => '5', 't' => 'Notifikasi', 'd' => 'Push notification otomatis saat laporan diproses atau jadwal bantuan ditentukan.'],
                        ['n' => '6', 't' => 'Histori Banjir', 'd' => 'Data banjir lintas waktu untuk identifikasi hotspot berulang dan mitigasi infrastruktur.'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold mb-6">{{ $f['n'] }}</div>
                    <h4 class="font-bold text-xl mb-3">{{ $f['t'] }}</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['d'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-10 my-20 bg-[#111827] rounded-[40px] py-20 px-6 text-center text-white">
        <h2 class="text-4xl font-extrabold mb-4">Siap Menggunakan SiEval DSS?</h2>
        <p class="text-gray-400 mb-10">Gratis untuk pemerintah dan warga desa Bojongsoang. Setup selesai dalam 1-2 hari kerja.</p>
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="/register" class="px-8 py-3 border border-gray-600 hover:bg-gray-800 transition rounded-full font-semibold">Laporan Banjir (Warga)</a>
            <a href="/login?role=kecamatan" class="px-8 py-3 bg-white text-black hover:bg-gray-200 transition rounded-full font-semibold">Lihat Dashboard (Kecamatan)</a>
        </div>
    </section>

    <footer class="px-10 py-16 border-t border-gray-100 text-sm">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-6 h-6 bg-black rounded-full"></div>
                    <span class="font-bold text-lg">SiEval DSS</span>
                </div>
                <p class="text-gray-500 max-w-xs">Jl. Telekomunikasi No 1, Terusan Buah Batu, Bojongsoang.</p>
            </div>
            <div>
                <h5 class="font-bold mb-6">Home</h5>
                <ul class="text-gray-500 space-y-4">
                    <li><a href="#" class="hover:text-black">Header</a></li>
                    <li><a href="#" class="hover:text-black">Get Started</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold mb-6">Tentang</h5>
                <ul class="text-gray-500 space-y-4">
                    <li><a href="#" class="hover:text-black">Cara kerja</a></li>
                    <li><a href="#" class="hover:text-black">Mengapa kami</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-gray-50 text-center text-gray-400">
            ©2026 SiEval DSS. All rights reserved.
        </div>
    </footer>

    <div id="authModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        
        <div class="bg-white w-full max-w-2xl rounded-[32px] p-10 relative shadow-2xl animate-in fade-in zoom-in duration-300">
            
            <button onclick="closeModal()" class="absolute right-8 top-8 text-gray-400 hover:text-black">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <h2 id="modalTitle" class="text-2xl font-bold mb-8 text-[#111827]">Masuk ke SiEval DSS sebagai:</h2>

            <div class="grid md:grid-cols-2 gap-6">
                
                <a href="#" id="linkWarga" class="group border border-gray-100 rounded-2xl p-6 hover:border-blue-500 hover:bg-blue-50/50 transition-all duration-200 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-lg mb-2 group-hover:text-blue-600">Warga (RW)</h3>
                        <p id="descWarga" class="text-gray-500 text-sm leading-relaxed">
                            Laporkan data banjir di wilayah Anda untuk memudahkan pendataan
                        </p>
                    </div>
                    <i data-lucide="home" class="absolute -right-2 -bottom-2 w-20 h-20 text-gray-50 group-hover:text-blue-100/50 transition-colors"></i>
                </a>

                <a href="#" id="linkKecamatan" class="group border border-gray-100 rounded-2xl p-6 hover:border-blue-500 hover:bg-blue-50/50 transition-all duration-200 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-lg mb-2 group-hover:text-blue-600">Kecamatan</h3>
                        <p id="descKecamatan" class="text-gray-500 text-sm leading-relaxed">
                            Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran dan akurat
                        </p>
                    </div>
                    <i data-lucide="search" class="absolute -right-2 -bottom-2 w-20 h-20 text-gray-50 group-hover:text-blue-100/50 transition-colors"></i>
                </a>

            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

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
                linkWarga.href = "/register"; // RW bebas daftar
                
                // Meskipun dia pencet "Daftar", Kecamatan tetap diarahkan ke Login (Tidak bisa daftar)
                linkKecamatan.href = "/login?role=kecamatan"; 
                descKecamatan.innerHTML = "<span class='text-gray-500 text-sm leading-relaxed'>Kelola data wilayah banjir dan persiapkan bantuan tepat sasaran dan akurat</span>";
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Kunci scroll di background
        }

        function closeModal() {
            const modal = document.getElementById('authModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; // Buka scroll
        }

        window.onclick = function(event) {
            const modal = document.getElementById('authModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>