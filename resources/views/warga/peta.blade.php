<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Banjir - SiEval DSS</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div class="p-8">
        <h1 class="text-2xl font-bold">Halaman Peta Banjir (Portal Warga)</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}. Anda masuk sebagai Warga.</p>
        
        <form action="/logout" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="text-red-500 underline">Keluar (Logout)</button>
        </form>
    </div>
</body>
</html>