<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Ketua RW - SiEval DSS</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body
    class="min-h-screen flex items-center justify-center bg-cover bg-center px-5"
    style="
        font-family: 'Inter', sans-serif;
        background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=2070&auto=format&fit=crop');
    "
>

<div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl px-14 py-12">

    <div class="text-center">
        <h1 class="text-[44px] leading-tight font-extrabold text-[#111827]">
            Pendaftaran Akun RW
        </h1>
        <p class="text-gray-500 mt-4 text-[15px]">
            Daftar sebagai Ketua RW untuk mulai memantau dan melaporkan data banjir secara real-time di wilayah Anda.
        </p>
    </div>

    <a href="/" class="absolute top-6 left-6 flex items-center gap-2 px-5 py-2.5 bg-white/20 hover:bg-white/40 backdrop-blur-md text-slate-700 hover:text-slate-900 rounded-full transition-all duration-300 group z-50 border border-white/30 shadow-lg">
        <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-sm font-semibold tracking-wide">Kembali ke Beranda</span>
    </a>

    <form action="/register" method="POST" class="space-y-6 mt-10">

        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Nama Lengkap RW & Desa<span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="map-pin" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
                <input
                    type="text"
                    name="rw_desa"
                    placeholder="Contoh: RW 07 - Cipagalo"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                    value="{{ old('rw_desa') }}"
                >
            </div>
            @error('rw_desa') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Email Perwakilan<span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="mail" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Contoh: rw07.cipagalo@mail.com"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>
            @error('email') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                No. HP Perwakilan (WhatsApp Active)<span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="phone" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
                <input
                    type="tel"
                    name="no_hp"
                    value="{{ old('no_hp') }}"
                    placeholder="Contoh: 081234567890"
                    pattern="[0-9]{10,14}"
                    inputmode="numeric"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>
            @error('no_hp') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Password (Min. 8 Karakter Kombinasi Huruf & Angka)<span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <i data-lucide="lock" class="absolute left-4 top-4 w-5 h-5 text-gray-400"></i>
                <input
                    id="password"
                    type="password"
                    name="password"
                    pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                    title="Password harus minimal 8 karakter dan mengandung kombinasi huruf serta angka"
                    placeholder="Minimal 8 karakter (Huruf + Angka)"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                <button type="button" onclick="togglePassword()" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i id="eyeIcon" data-lucide="eye-off" class="w-5 h-5"></i>
                </button>
            </div>
            @error('password') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-start gap-3 pt-2">
            <input
                type="checkbox"
                required
                class="mt-1 rounded border-gray-300 text-blue-500 focus:ring-blue-500 cursor-pointer"
            >
            <p class="text-sm text-gray-600 leading-relaxed cursor-pointer">
                Saya mewakili pengurus RW yang sah dan menyetujui Kebijakan Privasi aplikasi ini.
            </p>
        </div>

        <button
            type="submit"
            class="w-full bg-blue-500 text-white py-4 rounded-full font-semibold text-sm hover:bg-blue-600 transition shadow-lg hover:shadow-xl"
        >
            Daftar Akun RW
        </button>

        <p class="text-center text-sm text-gray-500 pt-2">
            Sudah punya akun?
            <a
                href="/login?role=rw"
                class="text-blue-600 font-semibold hover:underline"
            >
                Login di sini
            </a>
        </p>

    </form>

</div>

<script>
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
</script>

</body>
</html>