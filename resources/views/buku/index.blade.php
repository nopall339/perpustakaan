<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f1ea;
            color: #2e2a26;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .header h1 {
            font-size: 26px;
            color: #5b3a29;
            border-left: 6px solid #c9822a;
            padding-left: 12px;
        }
        .btn-add {
            background: #c9822a;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-add:hover { 
            background: #a8681c; 
        }
        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #ddd3c4;
            border-radius: 8px;
            padding: 4px 4px 4px 16px;
            margin-bottom: 20px;
            max-width: 500px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: border-color 0.2s;
        }
        .search-bar:focus-within {
            border-color: #c9822a;
        }
        .search-bar svg {
            width: 18px;
            height: 18px;
            color: #a8a196;
            flex-shrink: 0;
        }
        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            padding: 10px 10px;
            font-size: 14px;
            background: transparent;
        }
        .search-bar button {
            background: #c9822a;
            color: #fff;
            border: none;
            padding: 9px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            white-space: nowrap;
        }
        .search-bar button:hover {
            background: #a8681c;
        }
        .search-bar .btn-reset {
            color: #a8681c;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 0 8px;
            white-space: nowrap;
        }
        .alert {
            background: #dcefe0;
            color: #1e5631;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #1e5631;
        }
        .book-list {
            display: grid;
            gap: 14px;
        }
        .book-card {
            background: #fff;
            border-radius: 10px;
            padding: 16px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 5px solid #c9822a;
        }
        .book-info h3 { font-size: 17px; color: #3a2e22; margin-bottom: 4px; }
        .book-info p { font-size: 13px; color: #7a6f63; }
        .book-meta {
            text-align: right;
            font-size: 13px;
            color: #5b3a29;
        }
        .stok-badge {
            display: inline-block;
            background: #f4e3d0;
            color: #a8681c;
            padding: 3px 10px;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 4px;
        }
        .empty {
            text-align: center;
            color: #a89f92;
            padding: 40px;
            font-style: italic;
        }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <div class="container">
        <div class="header">
            <h1>Daftar Buku Perpustakaan</h1>
            <a href="{{ route('buku.create') }}" class="btn-add">+ Tambah Buku</a>
        </div>
        <form method="GET" action="{{ route('buku.index') }}" class="search-bar">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            <input type="text" name="cari" value="{{ $keyword ?? '' }}" placeholder="Cari judul atau pengarang...">
            @if(!empty($keyword))
            <a href="{{ route('buku.index') }}" class="btn-reset">Reset</a>
            @endif
            <button type="submit">Cari</button>
        </form>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="book-list">
            @forelse($buku as $item)
            <div class="book-card">
                <div class="book-info">
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ $item->pengarang }} &middot; {{ $item->penerbit }} ({{ $item->tahun_terbit }})</p>
                </div>
                <div class="book-meta">
                    <div>Kode: {{ $item->kode_buku }}</div>
                    <span class="stok-badge">Stok: {{ $item->stok }}</span>
                    <div style="margin-top:8px; display:flex; gap:6px; justify-content:flex-end;">
                        <a href="{{ route('buku.edit', $item->id) }}" style="background:#4a7c6e;color:#fff;padding:4px 10px;border-radius:5px;text-decoration:none;font-size:12px;">Edit</a>
                        <form action="{{ route('buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                             @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#c0392b;color:#fff;border:none;padding:4px 10px;border-radius:5px;font-size:12px;cursor:pointer;">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty">Belum ada data buku.</div>
            @endforelse
        </div>
    </div>
</body>
</html>