<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peminjaman</title>
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
        }
        .btn-add:hover { 
            background: #a8681c; 
        }
        .alert { 
            background: #dcefe0; 
            color: #1e5631; 
            padding: 12px 16px; 
            border-radius: 6px; 
            margin-bottom: 20px; 
            border-left: 4px solid #1e5631; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: #fff; 
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 2px 6px rgba(0,0,0,0.06); 
        }
        th, td { 
            padding: 12px 16px; 
            text-align: left; 
        }
        th { 
            background: #c9822a; 
            color: #fff; 
        }
        tr:nth-child(even) { 
            background: #faf8f4; 
        }
        .empty { 
            text-align: center; 
            color: #a89f92; 
            padding: 30px; 
            font-style: italic; 
        }
        .badge { 
            padding: 3px 10px; 
            border-radius: 12px; 
            font-size: 12px; 
            font-weight: 600; 
            background: #f4e3d0; 
            color: #a8681c; 
            }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <div class="container">
        <div class="header">
            <h1>Daftar Peminjaman</h1>
            <a href="{{ route('peminjaman.create') }}" class="btn-add">+ Tambah Peminjaman</a>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div style="margin-bottom:16px; display:flex; gap:8px;">
            <a href="{{ route('peminjaman.index') }}" style="padding:6px 14px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600; background:{{ !$status ? '#c9822a' : '#eee' }}; color:{{ !$status ? '#fff' : '#555' }};">Semua</a>
            <a href="{{ route('peminjaman.index', ['status' => 'Dipinjam']) }}" style="padding:6px 14px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600; background:{{ $status == 'Dipinjam' ? '#c9822a' : '#eee' }}; color:{{ $status == 'Dipinjam' ? '#fff' : '#555' }};">Sedang Dipinjam</a>
            <a href="{{ route('peminjaman.index', ['status' => 'Dikembalikan']) }}" style="padding:6px 14px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600; background:{{ $status == 'Dikembalikan' ? '#c9822a' : '#eee' }}; color:{{ $status == 'Dikembalikan' ? '#fff' : '#555' }};">Riwayat (Sudah Kembali)</a>
        </div>

        <table>
            <tr>
                <th>Judul Buku</th>
                <th>Nama Anggota</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            @forelse($peminjam as $item)
            <tr>
                <td>{{ $item->buku->judul }}</td>
                <td>{{ $item->anggota->nama }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                <td><span class="badge">{{ $item->status }}</span></td>
                <td>
                    @if(strtolower($item->status) === 'dipinjam')
                    <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST" onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" style="background:#4a7c6e; color:#fff; border:none; padding:4px 10px; border-radius:5px; font-size:12px; cursor:pointer;">Kembalikan</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty">Belum ada data peminjaman.</td></tr>
            @endforelse
        </table>
    </div>
</body>
</html>