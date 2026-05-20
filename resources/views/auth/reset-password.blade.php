<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perbarui Password - SiEval DSS</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="w-full max-w-md bg-white border border-slate-200 shadow-xl rounded-2xl p-8 space-y-6">
        
        <div class="space-y-2 text-center">
            <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center mx-auto text-white shadow-md">
                <i data-lucide="lock" class="w-5 h-5 text-emerald-400"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Buat Kata Sandi Baru</h1>
            <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                Silakan ketik kombinasi kata sandi baru Anda yang kuat dan aman di bawah ini.
            </p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="space-y-1.5">
                <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Sandi Baru</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400"><i data-lucide="key" class="w-4 h-4"></i></span>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                           class="w-full bg-slate-50 border @error('password') border-red-500 focus:ring-red-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 transition font-medium" />
                </div>
                @error('password')
                    <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label for="password_confirmation" class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Ulangi Sandi Baru</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400"><i data-lucide="check-square" class="w-4 h-4"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ketik ulang sandi"
                           class="w-full bg-slate-50 border border-slate-200 focus:ring-blue-500 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 transition font-medium" />
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl text-sm shadow-md transition flex items-center justify-center gap-2 active:scale-98">
                Simpan Password Baru
            </button>
        </form>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>