<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Password Baru - SiEval DSS</title>
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
                    Buat Password Baru
                </h1>
                <p class="text-gray-500 text-[15px] leading-relaxed font-normal">
                    Silakan buat password baru. Pastikan password baru berbeda dengan password lama.
                </p>
            </div>
        </div>

        <form action="{{ route('password.update') }}" method="POST" id="reset-form" class="space-y-6" novalidate>
            @csrf
            
            {{-- Hidden input opsional, tapi biarkan saja jika sewaktu-waktu dibutuhkan --}}
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="space-y-3">
                <label for="password" class="text-sm font-bold text-gray-800 block pl-1">Password</label>
                <div class="relative">
                    <span class="absolute left-5 top-4 text-gray-400">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </span>
                    
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Minimal 8 karakter (Huruf + Angka)" 
                        required
                        class="w-full bg-white border @error('password') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 @enderror rounded-full pl-14 pr-12 py-4 text-sm focus:outline-none focus:ring-2 transition placeholder-gray-400 font-medium text-gray-900 shadow-sm" 
                    />

                    <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-1')" class="absolute right-5 top-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i id="eye-icon-1" data-lucide="eye-off" class="w-5 h-5"></i>
                    </button>
                </div>
                
                @error('password')
                    <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-2 ml-4">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-3">
                <label for="password_confirmation" class="text-sm font-bold text-gray-800 block pl-1">Konfirmasi Password</label>
                <div class="relative">
                    <span class="absolute left-5 top-4 text-gray-400">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </span>
                    
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        placeholder="Konfirmasi Password" 
                        required
                        class="w-full bg-white border border-gray-300 focus:ring-blue-500 rounded-full pl-14 pr-12 py-4 text-sm focus:outline-none focus:ring-2 transition placeholder-gray-400 font-medium text-gray-900 shadow-sm" 
                    />

                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-2')" class="absolute right-5 top-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i id="eye-icon-2" data-lucide="eye-off" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <button 
                type="submit" 
                id="btn-reset"
                disabled
                class="w-full bg-[#EAEAEA] text-gray-400 font-bold py-4 rounded-full text-sm shadow-sm transition-all duration-300 disabled:opacity-100"
            >
                Reset Password
            </button>
        </form>

    </div>

    <script>
        // Pastikan lucide ter-render jika dipanggil ulang
        if (window.lucide) {
            lucide.createIcons();
        }

        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const btnReset = document.getElementById('btn-reset');

        function validatePasswords() {
            const passVal = passwordInput.value;
            const confirmVal = confirmInput.value;

            // Validasi client-side sederhana: Minimal 8 karakter, ada huruf, ada angka, dan kedua input cocok
            const hasLetter = /[A-Za-z]/.test(passVal);
            const hasNumber = /\d/.test(passVal);
            const isLongEnough = passVal.length >= 8;
            const isMatched = passVal === confirmVal;

            if (isLongEnough && hasLetter && hasNumber && isMatched) {
                // Aktifkan tombol (Ubah jadi hitam)
                btnReset.disabled = false;
                btnReset.classList.remove('bg-[#EAEAEA]', 'text-gray-400', 'pointer-events-none');
                btnReset.classList.add('bg-[#111827]', 'text-white', 'hover:bg-black', 'active:scale-[0.98]');
            } else {
                // Matikan tombol (Ubah jadi abu-abu)
                btnReset.disabled = true;
                btnReset.classList.add('bg-[#EAEAEA]', 'text-gray-400');
                btnReset.classList.remove('bg-[#111827]', 'text-white', 'hover:bg-black', 'active:scale-[0.98]');
            }
        }

        // Pasang listener ketikan pada kedua input password
        passwordInput.addEventListener('input', validatePasswords);
        confirmInput.addEventListener('input', validatePasswords);

        // Fungsi pembantu toggle show/hide password text
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye-off');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>