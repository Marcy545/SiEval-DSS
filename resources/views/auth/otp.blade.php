<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi OTP - SiEval DSS</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4" style="font-family: 'Inter', sans-serif;">

    <div class="w-full max-w-md px-4 py-8 space-y-10">
        
        <div class="space-y-6">
            <div class="flex items-center gap-3 justify-start pl-1">
                <div class="w-10 h-10 bg-[#1A1A1A] rounded-full flex items-center justify-center text-white shadow-sm">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </div>
                <span class="text-xl font-extrabold text-[#111827] tracking-tight">SiEval DSS</span>
            </div>

            <div class="space-y-3">
                <h1 class="text-[32px] font-extrabold text-[#111827] tracking-tight leading-tight">
                    Cek Email Anda
                </h1>
                <p class="text-gray-500 text-[15px] leading-relaxed font-normal">
                    Buka email Anda dan masukkan kode OTP yang telah kami kirim ke email 
                    <span class="text-gray-800 font-semibold">
                        {{ Str::mask(session('reset_email') ?? $email ?? 'user@gmail.com', '*', 3, 5) }}
                    </span>.
                </p>
            </div>
        </div>

        <form action="{{ route('password.verify') }}" method="POST" id="otp-form" class="space-y-10">
            @csrf
            <input type="hidden" name="email" value="{{ session('reset_email') ?? $email }}">
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="space-y-4">
                <div class="grid grid-cols-6 gap-2 sm:gap-3">
                    @for ($i = 1; $i <= 6; $i++)
                        <input 
                            type="text" 
                            id="otp-{{ $i }}"
                            maxlength="1" 
                            pattern="[0-9]*" 
                            inputmode="numeric"
                            class="otp-input w-full h-14 sm:h-16 text-center text-xl font-bold border @error('otp') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-2xl outline-none transition-all shadow-sm"
                        />
                    @endfor
                </div>

                @error('otp')
                    <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-2 ml-2">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Hidden field untuk menampung gabungan 6 angka OTP --}}
            <input type="hidden" name="otp" id="full-otp">

            <div class="space-y-6">
                <button 
                    type="submit" 
                    id="btn-lanjutkan"
                    disabled
                    class="w-full bg-[#EAEAEA] text-gray-400 font-bold py-4 rounded-full text-sm shadow-sm transition-all duration-300 disabled:opacity-100"
                >
                    Lanjutkan
                </button>

                <p class="text-left text-sm text-gray-500 font-medium">
                    Tidak mendapatkan kode OTP? 
                    <a href="#" class="text-[#111827] font-extrabold hover:underline">Kirim ulang</a>
                </p>
            </div>
        </form>

    </div>

    <script>
        lucide.createIcons();

        const inputs = document.querySelectorAll('.otp-input');
        const btnLanjutkan = document.getElementById('btn-lanjutkan');
        const fullOtpInput = document.getElementById('full-otp');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.inputType === "deleteContentBackward") {
                    checkCompletion();
                    return;
                }
                
                if (!/^\d$/.test(input.value)) {
                    input.value = "";
                    return;
                }

                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                checkCompletion();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        function checkCompletion() {
            let otpValue = "";
            inputs.forEach(input => otpValue += input.value);

            // LOGIC KEMBALI KE 6 DIGIT
            if (otpValue.length === 6) {
                btnLanjutkan.disabled = false;
                btnLanjutkan.classList.remove('bg-[#EAEAEA]', 'text-gray-400');
                btnLanjutkan.classList.add('bg-[#111827]', 'text-white', 'hover:bg-black', 'active:scale-[0.98]');
                fullOtpInput.value = otpValue; 
            } else {
                btnLanjutkan.disabled = true;
                btnLanjutkan.classList.add('bg-[#EAEAEA]', 'text-gray-400');
                btnLanjutkan.classList.remove('bg-[#111827]', 'text-white', 'hover:bg-black', 'active:scale-[0.98]');
                fullOtpInput.value = "";
            }
        }

        document.getElementById('otp-form').addEventListener('submit', function(e) {
            let otpValue = "";
            inputs.forEach(input => otpValue += input.value);
            fullOtpInput.value = otpValue;
        });
    </script>
</body>
</html>