<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SiEval DSS</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body
    class="min-h-screen flex items-center justify-center bg-cover bg-center"
    style="
        font-family: 'Inter', sans-serif;
        background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=2070&auto=format&fit=crop');
    "
>

<div class="w-full max-w-2xl bg-white rounded-[28px] shadow-2xl px-12 py-10">

    <!-- Heading -->
    <div class="text-center">

        <h1 class="text-[42px] font-extrabold text-[#111827]">
            Selamat Datang di SiEval DSS!
        </h1>

        <p class="text-gray-500 mt-3 text-[15px]">
            Daftar untuk memantau data banjir secara real-time di Bojongsoang.
        </p>

    </div>

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

        </div>

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

                <input
                    type="email"
                    name="email"
                    placeholder="Contoh: email@mail.com"
                    class="w-full border border-gray-300 rounded-full py-4 pl-12 pr-5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >

            </div>

        </div>

        <!-- Password -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Password 6 Digit<span class="text-red-500">*</span>
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
        
        <!-- Button -->
        <button
            type="submit"
            class="w-full bg-blue-500 text-white py-4 rounded-full font-semibold text-sm hover:bg-blue-600 transition"
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

    lucide.createIcons();

    function togglePassword() {

        const password = document.getElementById('password');

        if (password.type === 'password') {

            password.type = 'text';

        } else {

            password.type = 'password';
        }
    }

</script>

</body>
</html>