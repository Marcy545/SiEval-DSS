<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - SiEval DSS</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2 family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="w-full max-w-md bg-white border border-slate-200 shadow-xl rounded-2xl p-8 space-y-6">
        
        <div class="space-y-2 text-center">
            <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center mx-auto text-white shadow-md">
                <i data-lucide="mail" class="w-5 h-5 text-blue-400"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Reset Kata Sandi</h1>
            <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                Masukkan alamat email Anda yang terdaftar untuk menerima tautan khusus pembuatan password baru.
            </p>
        </div>

        @if (session('status'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-xs text-green-700 font-semibold flex items-start gap-2">
                <i data-lucide="check-circle" class="w-4 h-4 shrink-0 text-green-600"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Alamat Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-slate-400"><i data-lucide="at-sign" class="w-4 h-4"></i></span>
                    <input type="email" name="email" id="email" placeholder="nama@email.com" value="{{ old('email') }}"
                           class="w-full bg-slate-50 border @error('email') border-red-500 focus:ring-red-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 transition font-medium" />
                </div>
                @error('email')
                    <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl text-sm shadow-md transition flex items-center justify-center gap-2 group active:scale-98">
                Kirim Link Ke Gmail
                <i data-lucide="send" class="w-4 h-4 text-blue-400 group-hover:translate-x-0.5 transition-transform"></i>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-100">
            <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition inline-flex items-center gap-1 group">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform"></i> Kembali ke Login
            </a>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>