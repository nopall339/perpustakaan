<!DOCTYPE html>
<html>
<head>
    <title>Daftar Wishlist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI', sans-serif; background:#f4f1ea; color:#2e2a26; }
        .container { max-width:900px; margin:0 auto; padding:40px 20px; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        .header h1 { font-size:26px; color:#5b3a29; border-left:6px solid #4a7c6e; padding-left:12px; }
        .alert { background:#dcefe0; color:#1e5631; padding:12px 16px; border-radius:6px; margin-bottom:20px; border-left:4px solid #1e5631; }
        .alert-error { background:#fdecea; color:#a83232; border-left-color:#a83232; }
        table { width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.06); }
        th, td { padding:12px 16px; text-align:left; }
        th { background:#4a7c6e; color:#fff; }
        tr:nth-child(even) { background:#faf8f4; }
        .empty { text-align:center; color:#a89f92; padding:30px; font-style:italic; }
        .btn-pinjam { background:#c9822a; color:#fff; border:none; padding:5px 12px; border-radius:5px; font-size:12px; cursor:pointer; }
        .btn-hapus { background:#a83232; color:#fff; border:none; padding:5px 12px; border-radius:5px; font-size:12px; cursor:pointer; margin-left:6px; }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <div class="container">
        <div class="header">
            <h1>Daftar Wishlist</h1>
        </div>

        @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

        <table>
            <tr><th>Judul Buku</th><th>Anggota</th><th>Aksi</th></tr>
            @forelse($wishlist as $item)
            <tr>
                <td>{{ $item->buku->judul }}</td>
                <td>{{ $item->anggota->nama }}</td>
                <td>
                    <form action="{{ route('wishlist.pinjam', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-pinjam">Pinjam Sekarang</button>
                    </form>
                    <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus dari daftar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-hapus">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="empty">Daftar wishlist masih kosong.</td></tr>
            @endforelse
        </table>
    </div>
</body>
</html>