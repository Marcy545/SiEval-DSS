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
    class="min-h-screen flex items-center justify-center bg-cover bg-center px-5"
    style="
        font-family: 'Inter', sans-serif;
        background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=2070&auto=format&fit=crop');
    "
>

<div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl px-14 py-12">

    <!-- Heading -->
    <div class="text-center">

        <h1 class="text-[44px] leading-tight font-extrabold text-[#111827]">
            Selamat Datang Kembali di SiEval DSS!
        </h1>

        <p class="text-gray-500 mt-4 text-[15px]">
            Masuk untuk memantau data banjir secara real-time di Bojongsoang.
        </p>

    </div>

    @if(session('error'))

    <div class="bg-red-100 text-red-600 px-4 py-3 rounded-2xl text-sm mt-8">
        {{ session('error') }}
    </div>

    @endif

    <!-- Form -->
    <form action="/login" method="POST" class="space-y-6 mt-8">

        @csrf

        <!-- Email -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Email (Boleh Email Pribadi)<span class="text-red-500">*</span>
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

                    <i
                        id="eyeIcon"
                        data-lucide="eye-off"
                        class="w-5 h-5"
                    ></i>

                </button>

            </div>

        </div>

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