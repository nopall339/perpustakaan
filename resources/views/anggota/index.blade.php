<!DOCTYPE html>
<html>
<head>
    <title>Daftar Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', 
            sans-serif; 
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
            border-left: 6px solid #4a7c6e; 
            padding-left: 12px; 
        }
        .btn-add { 
            background: #4a7c6e; 
            color: #fff; 
            padding: 10px 18px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: 600; 
        }
        .btn-add:hover { 
            background: #386155; 
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
            background: #4a7c6e; 
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
    </style>
</head>
<body>
    @include('layouts.navigation')
    <div class="container">
        <div class="header">
            <h1>Daftar Anggota</h1>
            <a href="{{ route('anggota.create') }}" class="btn-add">+ Tambah Anggota</a>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <table>
            <tr><th>NIS</th><th>Nama</th><th>Kelas</th></tr>
            @forelse($anggota as $item)
            <tr>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kelas }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="empty">Belum ada data anggota.</td></tr>
            @endforelse
        </table>
    </div>
</body>
</html>