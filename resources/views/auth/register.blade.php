<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SiEval DSS</title>

    @vite(['resources/css/app.css'])

<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

=======
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide -->
>>>>>>> master
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
            Selamat Datang di SiEval DSS!
        </h1>

        <p class="text-gray-500 mt-3 text-[15px]">
=======
        <h1 class="text-[44px] leading-tight font-extrabold text-[#111827]">
            Selamat Datang di SiEval DSS!
        </h1>

        <p class="text-gray-500 mt-4 text-[15px]">
>>>>>>> master
            Daftar untuk memantau data banjir secara real-time di Bojongsoang.
        </p>

    </div>

<<<<<<< HEAD
    <!-- Error -->
    @if($errors->any())

    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-3 rounded-2xl mt-6 text-sm">

        {{ $errors->first() }}

    </div>

    @endif

    <!-- Form -->
    <form action="/register" method="POST" class="space-y-6 mt-8">

        @csrf

        <!-- RW -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Nama RW dan Desa<span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <i
                    data-lucide="user-circle"
                    class="absolute left-4 top-4 w-5 h-5 text-gray-400"
                ></i>

                <input
                    type="text"
                    name="rw_desa"
                    placeholder="Contoh: RW 09 - Cipagalo"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >

            </div>

=======
    <a href="/" class="absolute top-6 left-6 flex items-center gap-2 px-5 py-2.5 bg-white/20 hover:bg-white/40 backdrop-blur-md text-slate-700 hover:text-slate-900 rounded-full transition-all duration-300 group z-50 border border-white/30 shadow-lg">
        <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-sm font-semibold tracking-wide">Kembali ke Beranda</span>
    </a>


    <!-- Form -->
    <form action="/register" method="POST" class="space-y-6 mt-10">

        @csrf

        <!-- Input Hidden untuk Role -->
        <input type="hidden" name="role" id="role-input" value="{{ $role }}">

        <!-- Input Nama/RW (Hanya satu container yang dinamis) -->
        <div id="container-nama">
            <label id="name-label" class="block text-sm font-semibold text-gray-700 mb-3">
                {{ $role === 'warga' ? 'Nama Lengkap' : 'Nama RW dan Desa' }}<span class="text-red-500">*</span>
            </label>

            <div class="relative">
                <i id="name-icon" data-lucide="{{ $role === 'warga' ? 'user' : 'user-circle' }}" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>

                <input
                    type="text"
                    id="name-input"
                    name="{{ $role === 'warga' ? 'name' : 'rw_desa' }}"
                    placeholder="{{ $role === 'warga' ? 'Contoh: Budi Santoso' : 'Contoh: RW 09 - Cipagalo' }}"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                    value="{{ old('name') ?? old('rw_desa') }}"
                >
            </div>
            @error('name') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
            @error('rw_desa') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
>>>>>>> master
        </div>

        <!-- Email -->
        <div>
<<<<<<< HEAD

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Email<span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <i
                    data-lucide="mail"
                    class="absolute left-4 top-4 w-5 h-5 text-gray-400"
                ></i>

                <input
                    type="email"
                    name="email"
=======
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Email (Boleh Email Pribadi)<span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="mail" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
>>>>>>> master
                    placeholder="Contoh: email@mail.com"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
<<<<<<< HEAD

            </div>

=======
            </div>
            @error('email') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
>>>>>>> master
        </div>

        <!-- Password -->
        <div>
<<<<<<< HEAD

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Password 6 Digit<span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <i
                    data-lucide="lock"
                    class="absolute left-4 top-4 w-5 h-5 text-gray-400"
                ></i>

=======
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Password (6 Digit Angka)<span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="lock" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
>>>>>>> master
                <input
                    id="password"
                    type="password"
                    name="password"
<<<<<<< HEAD
                    placeholder="Contoh: 123456"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >

                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute right-4 top-4 text-gray-400 hover:text-gray-600"
                >
                    <i
                        id="eyeIcon"
                        data-lucide="eye-off"
                        class="w-5 h-5"
                    ></i>
                </button>

            </div>

=======
                    maxlength="6"
                    pattern="[0-9]{6}"
                    inputmode="numeric"
                    placeholder="Masukkan 6 digit angka"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                <button type="button" onclick="togglePassword()" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
                    <i id="eyeIcon" data-lucide="eye-off" class="w-5 h-5"></i>
                </button>
            </div>
            @error('password') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
>>>>>>> master
        </div>

        <!-- Checkbox -->
        <div class="flex items-start gap-3 pt-2">

            <input
                type="checkbox"
                required
                class="mt-1 rounded border-gray-300"
            >

            <p class="text-sm text-gray-600 leading-relaxed">
                Saya setuju dengan Syarat & Ketentuan dan Kebijakan Privasi.
            </p>

        </div>
<<<<<<< HEAD
        
        <!-- Button -->
        <button
            type="submit"
            class="w-full bg-blue-500 text-white py-4 rounded-full font-semibold text-sm hover:bg-blue-600 transition"
=======

        <!-- Button -->
        <button
            type="submit"
            class="w-full bg-[#E5E7EB] hover:bg-blue-500 hover:text-white text-gray-500 py-4 rounded-full font-semibold text-sm transition"
>>>>>>> master
        >
            Daftar Akun
        </button>

        <!-- Login -->
        <p class="text-center text-sm text-gray-500 pt-2">

            Sudah punya akun?

            <a
                href="/login"
                class="text-black font-semibold hover:underline"
            >
                Login
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
    // Jalankan saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const initialRole = "{{ $role }}";
        setRole(initialRole);
    });

    function setRole(role) {
        const btnWarga = document.getElementById('btn-warga');
        const btnRW = document.getElementById('btn-rw');
        const roleInput = document.getElementById('role-input');
        const nameLabel = document.getElementById('name-label');
        const nameInput = document.getElementById('name-input');
        const nameIcon = document.getElementById('name-icon');

        roleInput.value = role;

        if (role === 'warga') {
            btnWarga.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            btnWarga.classList.remove('text-gray-500');
            btnRW.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
            btnRW.classList.add('text-gray-500');

            nameLabel.innerHTML = 'Nama Lengkap<span class="text-red-500">*</span>';
            nameInput.placeholder = "Contoh: Budi Santoso";
            nameInput.name = "name";
            nameIcon.setAttribute('data-lucide', 'user');
        } else {
            btnRW.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            btnRW.classList.remove('text-gray-500');
            btnWarga.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
            btnWarga.classList.add('text-gray-500');

            nameLabel.innerHTML = 'Nama RW dan Desa<span class="text-red-500">*</span>';
            nameInput.placeholder = "Contoh: RW 09 - Cipagalo";
            nameInput.name = "rw_desa";
            nameIcon.setAttribute('data-lucide', 'user-circle');
        }
        lucide.createIcons();
    }

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
>>>>>>> master
</script>

</body>
</html>