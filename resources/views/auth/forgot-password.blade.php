<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - SiEval DSS</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4" style="font-family: 'Inter', sans-serif;">

    <div class="w-full max-w-md px-4 py-8 space-y-8">
        
        <div class="space-y-6">
            <div class="flex items-center gap-3 justify-start pl-1">
                <div class="w-10 h-10 bg-[#1A1A1A] rounded-full flex items-center justify-center text-white shadow-sm">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </div>
                <span class="text-xl font-extrabold text-[#111827] tracking-tight">SiEval DSS</span>
            </div>

            <div class="space-y-3">
                <h1 class="text-[32px] font-extrabold text-[#111827] tracking-tight leading-tight">
                    Lupa Password
                </h1>
                <p class="text-gray-500 text-[15px] leading-relaxed font-normal">
                    Tulis email yang terhubung dengan akun anda dan kami akan mengirimkan kode OTP untuk mengubah password.
                </p>
            </div>
        </div>

        @if (session('status'))
            <div class="p-4 bg-green-50 border border-green-100 rounded-2xl text-xs text-green-700 font-semibold flex items-start gap-2 animate-fade-in">
                <i data-lucide="check-circle" class="w-4 h-4 shrink-0 text-green-600"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-3">
                <label for="email" class="text-sm font-bold text-gray-800 block pl-1">Email</label>
                <div class="relative">
                    <span class="absolute left-5 top-4 text-gray-400">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </span>
                    
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="Contoh: email@mail.com" 
                        value="{{ old('email') }}"
                        required
                        class="w-full bg-white border @error('email') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-full pl-14 pr-6 py-4 text-sm focus:outline-none focus:ring-2 transition placeholder-gray-400 font-medium text-gray-900 shadow-sm" 
                    />
                </div>
                
                @error('email')
                    <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-2 ml-4 animate-fade-in">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <button 
                type="submit" 
                id="btn-kirim"
                class="w-full bg-[#EAEAEA] text-gray-400 font-bold py-4 rounded-full text-sm shadow-sm transition-all duration-300 pointer-events-none"
            >
                Kirim
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-500 hover:text-gray-900 transition inline-flex items-center gap-1 group">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform"></i> Kembali ke Login
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Ambil elemen input email dan tombol kirim
        const emailInput = document.getElementById('email');
        const btnKirim = document.getElementById('btn-kirim');

        // Fungsi untuk memeriksa isi inputan email
        function checkInput() {
            // Jika ada teks di input email (setelah di-trim spasi kosongnya)
            if (emailInput.value.trim() !== "") {
                // Gambar Kedua: Aktif (Hitam Pekat)
                btnKirim.classList.remove('bg-[#EAEAEA]', 'text-gray-400', 'pointer-events-none');
                btnKirim.classList.add('bg-[#111827]', 'text-white', 'hover:bg-black', 'active:scale-[0.99]');
            } else {
                // Gambar Pertama: Mati (Abu-abu Terang)
                btnKirim.classList.add('bg-[#EAEAEA]', 'text-gray-400', 'pointer-events-none');
                btnKirim.classList.remove('bg-[#111827]', 'text-white', 'hover:bg-black', 'active:scale-[0.99]');
            }
        }

        // Jalankan fungsi saat user mengetik sesuatu
        emailInput.addEventListener('input', checkInput);

        // Jalankan sekali saat halaman pertama kali dimuat (antisipasi jika ada old value dari Laravel)
        window.addEventListener('DOMContentLoaded', checkInput);
    </script>
</body>
</html>