<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Banjir Warga - SiEval DSS</title>
    
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Memastikan tombol kustom Leaflet rapi di HP */
        .custom-gps-btn {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 12px;
            border-radius: 9999px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .custom-gps-btn:active { transform: scale(0.95); }
    </style>
</head>
<body class="bg-[#F8F9FF]/40 min-h-screen text-[#0C0C0C] pb-12">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-50 px-4 py-3 shadow-sm">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#0C0C0C] rounded-full flex items-center justify-center text-white font-bold shadow-inner">
                    <i data-lucide="shield-alert" class="w-5 h-5 text-blue-400"></i>
                </div>
                <div>
                    <h1 class="text-base font-bold tracking-tight">SiEval DSS</h1>
                    <div class="flex items-center gap-1 text-xs text-gray-500">
                        <i data-lucide="user" class="w-3 h-3 text-blue-500"></i>
                        <span>{{ Auth::check() ? Auth::user()->name : 'Nama Warga / RW' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <button type="button" id="profileDropdownBtn" class="flex items-center focus:outline-none transition active:scale-95">
                    <div class="w-9 h-9 bg-gray-200 rounded-full overflow-hidden border border-gray-300 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=100&auto=format&fit=crop" alt="Profile" class="w-full h-full object-cover">
                    </div>
                </button>

                <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 transform opacity-0 scale-95 transition-all duration-200 origin-top-right">
                    <div class="p-3 border-b border-gray-100">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::check() ? Auth::user()->name : 'User RW' }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::check() ? Auth::user()->email : 'rw@bojongsoang.com' }}</p>
                    </div>
                    <div class="p-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <main class="max-w-md mx-auto px-4 mt-6 space-y-6">


        <div class="space-y-1">
            <h2 class="text-2xl font-bold tracking-tight text-[#0B1C30]">Laporan Banjir Warga</h2>
            <p class="text-xs text-[#45464D] leading-relaxed">
                Data Anda membantu tim penyelamat memprioritaskan respons darurat dan distribusi bantuan di Bojongsoang secara akurat.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded-xl text-sm text-center font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('rw.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="map" class="w-4 h-4 text-blue-500"></i>
                    Input Lokasi dan Identitas
                </h3>
                
                <div class="relative w-full h-60 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-inner">
                    <div id="map" class="w-full h-full z-10"></div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Latitude</label>
                        <input type="text" name="latitude" id="latitude" readonly required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 text-xs text-gray-600 focus:outline-none font-mono">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Longitude</label>
                        <input type="text" name="longitude" id="longitude" readonly required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 text-xs text-gray-600 focus:outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Nama RW dan Kelurahan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="home" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="rw_kelurahan" placeholder="Contoh: RW 05 - Cipagalo" required
                            class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="droplet" class="w-4 h-4 text-blue-500"></i>
                    Detail Banjir
                </h3>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Status Banjir Saat Ini <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="activity" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <select name="status_banjir" required class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 appearance-none cursor-pointer">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            <option value="Masih Menggenang">Masih Menggenang</option>
                            <option value="Mulai Surut">Mulai Surut</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Ketinggian Air (cm) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="ruler" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="number" name="ketinggian_air" placeholder="Contoh: 120" required min="0"
                            class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Sudah Berapa Lama Banjir Berlangsung <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="clock" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="durasi_banjir" placeholder="Contoh: 2 Jam" required
                            class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Penyebab Yang Terlihat <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="cloud-rain" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="penyebab" placeholder="Contoh: Curah Hujan Tinggi / Tanggul Jebol" required
                            class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                    Dampak ke Warga
                </h3>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Jumlah KK Terdampak <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="users-2" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="number" name="jumlah_kk" placeholder="Contoh: 130" required min="0"
                            class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Jumlah Jiwa Terdampak <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="user-check" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="number" name="jumlah_jiwa" placeholder="Contoh: 500" required min="0"
                            class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Ada Warga yang Perlu Dievakuasi? <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i data-lucide="life-buoy" class="absolute left-4 top-3.5 w-4 h-4 text-gray-400"></i>
                        <select name="butuh_evakuasi" required class="w-full bg-white border border-gray-200 rounded-full py-3 pl-11 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 appearance-none cursor-pointer">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya, Mendesak!">Ya, Mendesak!</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 block">Jumlah Lansia</label>
                        <input type="number" name="jumlah_lansia" placeholder="0" min="0"
                            class="w-full bg-white border border-gray-200 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 block">Jumlah Bayi/Bumil</label>
                        <input type="number" name="jumlah_bayi_bumil" placeholder="0" min="0"
                            class="w-full bg-white border border-gray-200 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="building-2" class="w-4 h-4 text-blue-500"></i>
                    Kondisi Rumah & Fasilitas
                </h3>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Jumlah Unit Rumah Tergenang <span class="text-red-500">*</span></label>
                    <input type="number" name="rumah_tergenang" placeholder="Contoh: 20" required min="0"
                        class="w-full bg-white border border-gray-200 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Tingkat Keparahan Mayoritas Rumah <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="tingkat_keparahan" required class="w-full bg-white border border-gray-200 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 appearance-none cursor-pointer">
                            <option value="Ringan">Ringan (Hanya halaman / semata kaki)</option>
                            <option value="Sedang">Sedang (Masuk dalam rumah / selutut)</option>
                            <option value="Parah">Parah (Hampir menenggelamkan bangunan)</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Jumlah Usaha/Toko Terdampak</label>
                    <input type="number" name="toko_terdampak" placeholder="Contoh: 50" min="0"
                        class="w-full bg-white border border-gray-200 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 block">Fasilitas Umum Terdampak</label>
                    <input type="text" name="fasum_terdampak" placeholder="Contoh: Sekolah, Masjid, Puskesmas"
                        class="w-full bg-white border border-gray-200 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <i data-lucide="camera" class="w-4 h-4 text-blue-500"></i>
                        Bukti Dokumentasi
                    </h3>
                    <span class="text-[11px] text-gray-400 font-medium">(Maksimal 3 Foto)</span>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    @for ($i = 1; $i <= 3; $i++)
                    <label class="relative flex flex-col items-center justify-center h-28 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/50 hover:bg-gray-50 cursor-pointer active:scale-95 transition-all group overflow-hidden">
                        <input type="file" name="dokumentasi[]" accept="image/*" class="hidden file-input" onchange="previewImage(this)">
                        <div class="text-center group-hover:scale-105 transition-transform preview-placeholder">
                            <i data-lucide="image-plus" class="w-5 h-5 mx-auto text-gray-400 mb-1"></i>
                            <span class="text-[10px] text-gray-500 font-medium block">+ Foto {{ $i }}</span>
                        </div>
                        <img class="hidden absolute inset-0 w-full h-full object-cover img-preview" alt="Preview">
                    </label>
                    @endfor
                </div>
            </div>

            <button type="submit" class="w-full bg-[#0C0C0C] hover:bg-slate-900 text-white py-4 rounded-full font-semibold text-base transition-all duration-200 active:scale-98 shadow-lg text-center flex items-center justify-center">
                Kirim Laporan
            </button>
        </form>
    </main>

    <script>
        lucide.createIcons();

        // 1. Set Koordinat Awal Peta (Bojongsoang, Bandung)
        const defaultLat = -6.9749;
        const defaultLng = 107.6369;

        const map = L.map('map', {
            zoomControl: true
        }).setView([defaultLat, defaultLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Buat Marker Pin yang Draggable
        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Ambil elemen DOM input form koordinat
        const inputLat = document.getElementById('latitude');
        const inputLng = document.getElementById('longitude');

        // Isi data inisial awal ke form
        inputLat.value = defaultLat;
        inputLng.value = defaultLng;

        // --- FITUR KLIK LANGSUNG DI PETA ---
        map.on('click', function(e) {
            const clickedLat = e.latlng.lat;
            const clickedLng = e.latlng.lng;
            
            marker.setLatLng([clickedLat, clickedLng]);
            
            inputLat.value = clickedLat.toFixed(8);
            inputLng.value = clickedLng.toFixed(8);
        });

        // Catat posisi jika pin digeser manual
        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            inputLat.value = position.lat.toFixed(8);
            inputLng.value = position.lng.toFixed(8);
        });

        // --- FITUR LEAFLET FLOATING BUTTON (ANTI-HILANG DI HP) ---
        const gpsControl = L.control({ position: 'bottomright' });

        gpsControl.onAdd = function() {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control border-none bg-transparent');
            container.innerHTML = `
                <button type="button" id="btn-gps-floating" class="custom-gps-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-navigation"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                    <span id="btn-gps-text">Deteksi Otomatis</span>
                </button>
            `;
            
            L.DomEvent.disableClickPropagation(container);
            return container;
        };
        gpsControl.addTo(map);

        document.getElementById('btn-gps-floating').addEventListener('click', getLocation);

        function getLocation() {
            const textSpan = document.getElementById('btn-gps-text');
            
            if (navigator.geolocation) {
                textSpan.innerText = "Mencari...";
                
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const myLat = position.coords.latitude;
                        const myLng = position.coords.longitude;

                        marker.setLatLng([myLat, myLng]);
                        map.setView([myLat, myLng], 16);

                        inputLat.value = myLat.toFixed(8);
                        inputLng.value = myLng.toFixed(8);

                        textSpan.innerText = "Lokasi Ditemukan!";
                        setTimeout(() => { textSpan.innerText = "Deteksi Otomatis"; }, 3000);
                    }, 
                    function (error) {
                        alert("Gagal melacak lokasi. Pastikan setelan lokasi/GPS di browser HP Anda sudah diizinkan.");
                        textSpan.innerText = "Deteksi Otomatis";
                    },
                    { enableHighAccuracy: true, timeout: 7000 }
                );
            } else {
                alert("Browser smartphone tidak mendukung Geolocation.");
            }
        }

        // --- FITUR DROPDOWN PROFIL LOGOUT ---
        const profileBtn = document.getElementById('profileDropdownBtn');
        const dropdownMenu = document.getElementById('profileDropdownMenu');

        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Mencegah event klik bocor ke background
            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                // Timeout kecil agar animasi Tailwind (opacity, scale) terlihat mulus
                setTimeout(() => {
                    dropdownMenu.classList.remove('opacity-0', 'scale-95');
                }, 10);
            } else {
                dropdownMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    dropdownMenu.classList.add('hidden');
                }, 200);
            }
        });

        // Menutup dropdown otomatis ketika pengguna mengklik area luar
        window.addEventListener('click', (e) => {
            if (!dropdownMenu.contains(e.target) && !profileBtn.contains(e.target)) {
                dropdownMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    dropdownMenu.classList.add('hidden');
                }, 200);
            }
        });

        // Image Preview Handler
        function previewImage(input) {
            const container = input.parentElement;
            const preview = container.querySelector('.img-preview');
            const placeholder = container.querySelector('.preview-placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>