<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiEval DSS</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body
<<<<<<< HEAD
    class="min-h-screen flex items-center justify-center bg-cover bg-center"
=======
    class="min-h-screen flex items-center justify-center bg-cover bg-center px-5"
>>>>>>> master
    style="
        font-family: 'Inter', sans-serif;
        background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=2070&auto=format&fit=crop');
    "
>

<<<<<<< HEAD
<div class="w-full max-w-2xl bg-white rounded-[28px] shadow-2xl px-12 py-10">
=======
<div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl px-14 py-12">
>>>>>>> master

    <!-- Heading -->
    <div class="text-center">

<<<<<<< HEAD
        <h1 class="text-[42px] font-extrabold text-[#111827]">
            Selamat Datang Kembali di SiEval DSS!
        </h1>

        <p class="text-gray-500 mt-3 text-[15px]">
=======
        <h1 class="text-[44px] leading-tight font-extrabold text-[#111827]">
            Selamat Datang Kembali di SiEval DSS!
        </h1>

        <p class="text-gray-500 mt-4 text-[15px]">
>>>>>>> master
            Masuk untuk memantau data banjir secara real-time di Bojongsoang.
        </p>

    </div>

<<<<<<< HEAD
    <!-- Success -->
    @if(session('success'))

    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-2xl mt-6 text-sm">

        {{ session('success') }}

    </div>

    @endif

    <!-- Error -->
    @if(session('error'))

    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-3 rounded-2xl mt-6 text-sm">

        {{ session('error') }}

    </div>

    @endif

    <!-- Form -->
    <form action="/login" method="POST" class="space-y-6 mt-8">

        @csrf

        <!-- Email -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Email<span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <i
                    data-lucide="mail"
                    class="absolute left-4 top-4 w-5 h-5 text-gray-400"
                ></i>

=======
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-full mb-6 text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Label Konfirmasi Role Otomatis -->
    <div class="mb-4 text-center">
        <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase tracking-wider">
            Mode: {{ $role === 'rw' ? 'Portal Kecamatan' : 'Portal Warga' }}
        </span>
    </div>

    <a href="/" class="absolute top-6 left-6 flex items-center gap-2 px-5 py-2.5 bg-white/20 hover:bg-white/40 backdrop-blur-md text-slate-700 hover:text-slate-900 rounded-full transition-all duration-300 group z-50 border border-white/30 shadow-lg">
        <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-sm font-semibold tracking-wide">Kembali ke Beranda</span>
    </a>

    <!-- Form -->
    <form action="/login?role={{ $role }}" method="POST" class="space-y-6 mt-10">
        @csrf
        
        <!-- Pastikan role dikirim kembali ke controller -->
        <input type="hidden" name="role" value="{{ $role }}">

        <!-- Tampilkan Alert Error jika Role Tidak Cocok -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-full mb-6 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Email -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Email <span id="role-text">({{ $role === 'warga' ? 'Warga' : 'Kecamatan' }})</span><span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="mail" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
>>>>>>> master
                <input
                    type="email"
                    name="email"
                    placeholder="Contoh: email@mail.com"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
<<<<<<< HEAD

            </div>

=======
            </div>
>>>>>>> master
        </div>

        <!-- Password -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Password<span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <i
                    data-lucide="lock"
                    class="absolute left-4 top-4 w-5 h-5 text-gray-400"
                ></i>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >

                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute right-4 top-4 text-gray-400 hover:text-gray-600"
                >
<<<<<<< HEAD
=======

>>>>>>> master
                    <i
                        id="eyeIcon"
                        data-lucide="eye-off"
                        class="w-5 h-5"
                    ></i>
<<<<<<< HEAD
=======

>>>>>>> master
                </button>

            </div>

        </div>

<<<<<<< HEAD
=======
        <!-- Remember -->
        <div class="flex items-center justify-between pt-1">

            <label class="flex items-center gap-3 text-sm text-gray-600">

                <input
                    type="checkbox"
                    class="rounded border-gray-300"
                >

                Remember me

            </label>

            <a
                href="#"
                class="text-sm text-gray-500 hover:text-black"
            >
                Forgot Password?
            </a>

        </div>

>>>>>>> master
        <!-- Button -->
        <button
            type="submit"
            class="w-full bg-blue-500 text-white py-4 rounded-full font-semibold text-sm hover:bg-blue-600 transition"
        >
            Masuk Akun
        </button>

        <!-- Register -->
        <p class="text-center text-sm text-gray-500 pt-2">

            Belum punya akun?

            <a
                href="/register"
                class="text-black font-semibold hover:underline"
            >
                Daftar di sini
            </a>

        </p>

    </form>

</div>

<script>
<<<<<<< HEAD

    lucide.createIcons();

    function togglePassword() {

        const password = document.getElementById('password');

        if (password.type === 'password') {

            password.type = 'text';

        } else {

            password.type = 'password';
        }
    }

=======
    lucide.createIcons();

    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye');
        } else {
            password.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        }
        lucide.createIcons();
    }

    function setLoginRole(role) {
        const btnWarga = document.getElementById('btn-warga');
        const btnRW = document.getElementById('btn-rw');
        const roleText = document.getElementById('role-text');

        if (role === 'warga') {
            btnWarga.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            btnWarga.classList.remove('text-gray-500');
            btnRW.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
            btnRW.classList.add('text-gray-500');
            roleText.innerText = '(Warga)';
        } else {
            btnRW.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            btnRW.classList.remove('text-gray-500');
            btnWarga.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
            btnWarga.classList.add('text-gray-500');
            roleText.innerText = '(Pengurus RW)';
        }
    }
>>>>>>> master
</script>

</body>
</html>