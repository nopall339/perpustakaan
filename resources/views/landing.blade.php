<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI', sans-serif; background:#f4f1ea; color:#2e2a26; }
        .topbar { background:#fff; padding:16px 40px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
        .topbar h1 { font-size:20px; color:#5b3a29; }
        .topbar a { background:#c9822a; color:#fff; padding:8px 18px; border-radius:6px; text-decoration:none; font-weight:600; font-size:14px; }
        .wrap { max-width:1100px; margin:0 auto; padding:40px 20px; }
        .wrap h2 { color:#5b3a29; border-left:6px solid #c9822a; padding-left:12px; margin-bottom:24px; }
    </style>
</head>
<body>
    <div class="topbar">
        <h1>📚 Perpustakaan Digital</h1>
        @auth
            <a href="{{ route('dashboard') }}">Ke Dashboard</a>
        @else
            <div style="display:flex; gap:10px;">
                <a href="{{ route('register') }}" style="background:#4a7c6e;">Daftar</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
        @endauth
    </div>
    <div class="wrap">
        <h2>Koleksi Buku</h2>
        @include('partials.buku-gallery')
    </div>  
</body>
</html>