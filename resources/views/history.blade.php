<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Banjir</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<<<<<<< HEAD
=======

    <script src="https://unpkg.com/lucide@latest"></script>
>>>>>>> master
</head>

<body class="bg-[#f5f6fa]" style="font-family: 'Inter', sans-serif;">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-[260px] bg-white border-r border-gray-200 flex flex-col justify-between">

        <div>
<<<<<<< HEAD

            <!-- Logo -->
            <div class="px-8 py-7 border-b border-gray-100">

                <h1 class="text-2xl font-extrabold">
                    SiEval DSS
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kecamatan Bojongsoang
                </p>

            </div>

            <!-- Menu -->
            <div class="px-5 mt-8 space-y-3">

                <a href="/dashboard" class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-500 hover:bg-gray-100">
                    Dashboard
                </a>

                <a href="#" class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-500 hover:bg-gray-100">
                    Peta Sebaran Banjir
                </a>

                <a href="/history" class="flex items-center gap-3 bg-gray-100 px-5 py-4 rounded-2xl font-semibold text-black">
                    Histori Banjir
                </a>

            </div>

        </div>

=======
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
                <a href="{{ route('peta') }}" class="flex items-center gap-3 p-3 {{ request()->is('rw/peta-banjir') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500' }} hover:bg-gray-50 rounded-xl transition">
                    <i data-lucide="map" class="w-5 h-5"></i>
                    <span class="text-large">Peta Sebaran Banjir</span>
                </a>

                <!-- Menu Histori Banjir -->
                <a href="{{ route('history') }}" class="flex items-center gap-3 p-3 {{ request()->is('history') ? 'bg-blue-50 text-gray-500 font-bold' : 'text-gray-500' }} hover:bg-gray-50 rounded-xl transition">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span class="text-large">Histori Banjir</span>
                </a>
            </nav>
        </div>


>>>>>>> master
        <!-- User -->
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

    <!-- CONTENT -->
    <main class="flex-1">

        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-10 py-6 flex justify-between items-center">

            <h1 class="text-4xl font-extrabold text-[#111827]">
                Histori Banjir
            </h1>

            <div class="flex items-center gap-4">

                <input
                    type="text"
                    placeholder="Cari RW atau wilayah..."
                    class="bg-[#f5f6fa] border border-gray-200 rounded-full px-6 py-3 w-[320px] outline-none"
                >

                <div class="w-12 h-12 rounded-full bg-white border border-gray-200"></div>

            </div>

        </div>

        <!-- Table -->
        <div class="p-8">

            <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden">

                <!-- Title -->
                <div class="px-8 py-6 border-b border-gray-100">

                    <h2 class="text-2xl font-bold">
                        Zona Banjir
                    </h2>

                </div>

                <!-- Table -->
                <table class="w-full">

                    <thead class="text-left text-gray-400 text-sm border-b border-gray-100">

                        <tr>

                            <th class="px-8 py-5">NAMA RW</th>
                            <th>KETINGGIAN AIR (CM)</th>
                            <th>JUMLAH KK</th>
                            <th>TANGGAL KEJADIAN</th>
                            <th>STATUS KEPARAHAN</th>
                            <th class="pr-8 text-right">AKSI</th>

                        </tr>

                    </thead>

                    <tbody>

                        @for ($i = 0; $i < 8; $i++)

                        <tr class="border-b border-gray-100 hover:bg-gray-50">

                            <td class="px-8 py-6">

                                <h2 class="font-bold text-[#111827]">
                                    RW 07
                                </h2>

                                <p class="text-sm text-gray-400 mt-1">
                                    Sukamaju Sector
                                </p>

                            </td>

                            <td class="font-bold">
                                180
                            </td>

                            <td class="text-gray-500">
                                420 KK
                            </td>

                            <td class="text-gray-500">
                                23 April 2026, 12:00 WIB
                            </td>

                            <td>

                                <span class="bg-red-100 text-red-500 px-4 py-2 rounded-full text-sm font-semibold">
                                    PARAH
                                </span>

                            </td>

                            <td class="pr-8 text-right">

                                <!-- BUTTON DETAIL -->
                                <button
                                    onclick="openModal()"
                                    class="bg-black text-white px-6 py-2 rounded-full text-sm"
                                >
                                    Detail
                                </button>

                            </td>

                        </tr>

                        @endfor

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

<!-- MODAL -->
<div
    id="detailModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50"
>

    <div class="bg-[#f5f6fa] w-[95%] max-w-7xl rounded-[30px] p-6 relative">

        <!-- CLOSE -->
        <button
            onclick="closeModal()"
            class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white border border-gray-200 text-xl"
        >
            ×
        </button>

        <!-- TOP -->
        <div class="grid grid-cols-12 gap-5">

            <!-- SCORE -->
            <div class="col-span-3 bg-white rounded-3xl p-6">

                <h2 class="font-bold text-lg mb-4">
                    Skor Prioritas AI
                </h2>

                <div class="flex justify-center">
                    <div class="relative w-28 h-28">

                        <svg class="w-28 h-28 rotate-[-90deg]">
                            <circle
                                cx="56"
                                cy="56"
                                r="46"
                                stroke="#e5e7eb"
                                stroke-width="10"
                                fill="none"
                            />

                            <circle
                                cx="56"
                                cy="56"
                                r="46"
                                stroke="#ef4444"
                                stroke-width="10"
                                fill="none"
                                stroke-linecap="round"
                                stroke-dasharray="289"
                                stroke-dashoffset="52"
                            />
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-extrabold">82</span>
                            <span class="text-sm text-gray-400">/100</span>
                        </div>

                    </div>
                </div>

                <p class="text-sm text-gray-500 text-center mt-5">
                    Status Kritis: Dibutuhkan intervensi segera dalam 6 jam ke depan.
                </p>

            </div>

            <!-- FAKTOR -->
            <div class="col-span-6 bg-white rounded-3xl p-6">

                <h2 class="font-bold text-lg mb-6">
                    Faktor Penentu Skor (Bobot AI)
                </h2>

                <div class="space-y-5">

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>Kerugian Material & Ekonomi</span>
                            <span class="text-red-500">30%</span>
                        </div>

                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="w-[30%] h-full bg-red-500 rounded-full"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">

                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Kelompok Rentan</span>
                                <span>25%</span>
                            </div>

                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="w-[25%] h-full bg-black rounded-full"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Tinggi Air Saat Ini</span>
                                <span>20%</span>
                            </div>

                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="w-[20%] h-full bg-black rounded-full"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Historis Kejadian</span>
                                <span>15%</span>
                            </div>

                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="w-[15%] h-full bg-black rounded-full"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Kecepatan Arus</span>
                                <span>10%</span>
                            </div>

                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="w-[10%] h-full bg-black rounded-full"></div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- ICON -->
            <div class="col-span-3 bg-white rounded-3xl p-6">

                <h2 class="font-bold text-lg mb-5">
                    Rumah dan Fasilitas Terdampak
                </h2>

                <div class="flex items-end justify-center gap-4 h-[150px]">

                    <div class="text-center">
                        <div class="w-14 h-28 rounded-2xl bg-red-500"></div>
                        <p class="text-xs mt-2 text-gray-500">Rumah</p>
                    </div>

                    <div class="text-center">
                        <div class="w-14 h-20 rounded-2xl bg-black"></div>
                        <p class="text-xs mt-2 text-gray-500">Usaha/Toko</p>
                    </div>

                    <div class="text-center">
                        <div class="w-14 h-14 rounded-2xl bg-gray-300"></div>
                        <p class="text-xs mt-2 text-gray-500">Fasilitas</p>
                    </div>

                </div>

            </div>

        </div>

        <!-- DATA -->
        <div class="grid grid-cols-4 gap-5 mt-5">

            <div class="bg-white rounded-2xl p-5">
                <p class="text-sm text-gray-400">JUMLAH KK TERDAMPAK</p>
                <h2 class="text-4xl font-extrabold mt-2">142</h2>
            </div>

            <div class="bg-white rounded-2xl p-5">
                <p class="text-sm text-gray-400">JUMLAH JIWA TERDAMPAK</p>
                <h2 class="text-4xl font-extrabold mt-2">568</h2>
            </div>

            <div class="bg-white rounded-2xl p-5">
                <p class="text-sm text-gray-400">JUMLAH LANSIA (>60TH)</p>
                <h2 class="text-4xl font-extrabold mt-2">60</h2>
            </div>

            <div class="bg-white rounded-2xl p-5">
                <p class="text-sm text-gray-400">JUMLAH BALITA/IBU HAMIL</p>
                <h2 class="text-4xl font-extrabold mt-2">28</h2>
            </div>

        </div>

        <!-- BOTTOM -->
        <div class="grid grid-cols-12 gap-5 mt-5">

            <!-- FOTO -->
            <div class="col-span-8 bg-white rounded-3xl p-5">

                <h2 class="font-bold text-xl mb-5">
                    Bukti Dokumentasi Warga
                </h2>

                <div class="grid grid-cols-3 gap-4">

                    <img
                        src="https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=1200"
                        class="rounded-2xl h-[240px] object-cover w-full"
                    >

                    <img
                        src="https://images.unsplash.com/photo-1594394489098-74f27d1f77fd?q=80&w=1200"
                        class="rounded-2xl h-[240px] object-cover w-full"
                    >

                    <img
                        src="https://images.unsplash.com/photo-1624969862644-791f3dc98927?q=80&w=1200"
                        class="rounded-2xl h-[240px] object-cover w-full"
                    >

                </div>

            </div>

            <!-- REKOMENDASI -->
            <div class="col-span-4 bg-black text-white rounded-3xl p-5">

                <h2 class="font-bold text-xl mb-5">
                    ✨ Rekomendasi Bantuan
                </h2>

                <div class="space-y-4">

                    <div class="bg-white/10 rounded-2xl p-4">
                        <h3 class="font-semibold mb-1">Evakuasi Segera</h3>
                        <p class="text-sm text-gray-300">
                            Titik kumpul Lapangan RW 07 sudah mulai tergenang.
                        </p>
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4">
                        <h3 class="font-semibold mb-1">Logistik Makanan Siap Saji</h3>
                        <p class="text-sm text-gray-300">
                            Dibutuhkan 200 porsi makanan siap saji.
                        </p>
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4">
                        <h3 class="font-semibold mb-1">Tim Medis & Obat-obatan</h3>
                        <p class="text-sm text-gray-300">
                            Fokus pada lansia dengan riwayat penyakit kronis.
                        </p>
                    </div>

                </div>

                <button class="mt-6 w-full bg-white text-black py-4 rounded-full font-semibold">
                    Hubungi RW
                </button>

            </div>

        </div>

    </div>

</div>

<!-- SCRIPT -->
<script>

    function openModal() {
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }

<<<<<<< HEAD
=======
    lucide.createIcons();


>>>>>>> master
</script>

</body>
</html>