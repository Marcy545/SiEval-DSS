<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SiEval DSS</title>

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

                <a href="#" class="flex items-center gap-3 bg-gray-100 px-5 py-4 rounded-2xl font-semibold text-black">
                    Dashboard
                </a>

                <a href="#" class="flex items-center gap-3 px-5 py-4 rounded-2xl text-gray-500 hover:bg-gray-100">
                    Peta Sebaran Banjir
                </a>

                <a
                    href="{{ route('history') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-100 transition"
                >
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span>Histori Banjir</span> 
                </a>

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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 {{ request()->is('dashboard') ? 'bg-blue-50 text-gray-500 font-bold' : 'text-gray-500' }} rounded-xl transition">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                    <span class="text-large">Dashboard</span>
                </a>

                <!-- Menu Peta Sebaran Banjir -->
                <a href="{{ route('peta') }}" class="flex items-center gap-3 p-3 {{ request()->is('rw/peta-banjir') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500' }} hover:bg-gray-50 rounded-xl transition">
                    <i data-lucide="map" class="w-5 h-5"></i>
                    <span class="text-large">Peta Sebaran Banjir</span>
                </a>

                <!-- Menu Histori Banjir -->
                <a href="{{ route('history') }}" class="flex items-center gap-3 p-3 {{ request()->is('history') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500' }} hover:bg-gray-50 rounded-xl transition">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span class="text-large">Histori Banjir</span>
                </a>
            </nav>
>>>>>>> master
        </div>

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
    <main class="flex-1 p-8">

        <!-- Header -->
        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-4xl font-extrabold text-[#111827]">
                    Dashboard Banjir Bojongsoang
                </h1>
            </div>

            <div class="flex items-center gap-4">

                <input
                    type="text"
                    placeholder="Cari RW atau wilayah..."
                    class="bg-white border border-gray-200 rounded-full px-6 py-3 w-[320px] outline-none"
                >

                <div class="w-12 h-12 rounded-full bg-white border border-gray-200"></div>

            </div>

        </div>

        <!-- Alert -->
        <div class="bg-black rounded-3xl px-8 py-6 mt-8 flex justify-between items-center">

            <div>

                <h2 class="text-white text-2xl font-bold">
                    Peringatan Evakuasi Segera: RW 07, Citeureup
                </h2>

                <p class="text-gray-300 mt-2">
                    Tingkat air mencapai 1,8m. Pemindahan warga disarankan segera.
                </p>

            </div>

            <button class="bg-white px-6 py-3 rounded-full font-semibold">
                Hubungi RW
            </button>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-3 gap-6 mt-8">

            <div class="bg-white rounded-3xl p-7">

                <p class="text-gray-400 text-sm">
                    RUMAH TERDAMPAK
                </p>

                <h1 class="text-5xl font-extrabold mt-4">
                    1,248
                </h1>

                <p class="text-red-500 mt-4 text-sm">
                    +12% dari pembaruan terakhir
                </p>

            </div>

            <div class="bg-white rounded-3xl p-7">

                <p class="text-gray-400 text-sm">
                    PERKIRAAN KERUGIAN
                </p>

                <h1 class="text-5xl font-extrabold mt-4">
                    Rp 4.2B
                </h1>

                <p class="text-green-500 mt-4 text-sm">
                    Berdasarkan data BNPB
                </p>

            </div>

            <div class="bg-white rounded-3xl p-7">

                <p class="text-gray-400 text-sm">
                    JUMLAH RW MELAPOR
                </p>

                <h1 class="text-5xl font-extrabold mt-4">
                    24/42
                </h1>

                <div class="w-full h-3 bg-gray-200 rounded-full mt-5 overflow-hidden">

                    <div class="w-[57%] h-full bg-black rounded-full"></div>

                </div>

            </div>

        </div>

        <!-- Bottom -->
        <div class="grid grid-cols-2 gap-6 mt-8">

            <!-- Pie -->
            <div class="bg-white rounded-3xl p-8">

                <h2 class="text-2xl font-bold">
                    Sektor Terdampak
                </h2>

                <div class="w-[260px] h-[260px] rounded-full border-[30px] border-black border-t-red-500 border-l-red-500 border-r-gray-200 mt-10 mx-auto"></div>

                <div class="space-y-4 mt-10">

                    <div class="flex justify-between">
                        <p>Perumahan</p>
                        <p class="font-bold">65%</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Bisnis/Toko</p>
                        <p class="font-bold">22%</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Infrastruktur</p>
                        <p class="font-bold">13%</p>
                    </div>

                </div>

            </div>

            <!-- Progress -->
            <div class="bg-white rounded-3xl p-8">

                <h2 class="text-2xl font-bold mb-10">
                    Ketinggian Air per RW
                </h2>

                <div class="space-y-8">

                    <div>
                        <div class="flex justify-between mb-2">
                            <p>RW 07</p>
                            <p>180 cm</p>
                        </div>

                        <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                            <div class="w-[90%] h-full bg-red-500 rounded-full"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <p>RW 12</p>
                            <p>140 cm</p>
                        </div>

                        <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                            <div class="w-[70%] h-full bg-orange-400 rounded-full"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <p>RW 03</p>
                            <p>80 cm</p>
                        </div>

                        <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                            <div class="w-[45%] h-full bg-green-500 rounded-full"></div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

<<<<<<< HEAD
=======
<script>
    lucide.createIcons();
</script>

>>>>>>> master
</body>
</html>