<!DOCTYPE html>
<html>
<head>
    <title>Tambah Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: #f4f1ea; color: #2e2a26; 
        }
        .container { 
            max-width: 480px; 
            margin: 0 auto; 
            padding: 40px 20px;
        }
        h1 { 
            font-size: 24px; 
            color: #5b3a29; 
            border-left: 6px solid #4a7c6e; 
            padding-left: 12px; 
            margin-bottom: 24px; 
        }
        .form-card { 
            background: #fff; 
            border-radius: 10px; 
            padding: 28px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.07); 
        }
        .field { 
            margin-bottom: 16px; 
        }
        .field label { 
            display: block; 
            font-size: 13px; 
            font-weight: 600; 
            color: #5b3a29;
            margin-bottom: 6px; 
        }
        .field input { 
            width: 100%; 
            padding: 10px 12px; 
            border: 1px solid #ddd3c4; 
            border-radius: 6px; 
            font-size: 14px; }
        .field input:focus { 
            outline: none; 
            border-color: #4a7c6e; 
        }
        .actions { 
            display: flex; 
            gap: 10px; 
            margin-top: 22px; 
        }
        .btn-save { 
            background: #4a7c6e; 
            color: #fff; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 6px; 
            font-weight: 600; 
            cursor: pointer; 
        }
        .btn-save:hover { 
            background: #386155; 
        }
        .btn-cancel { 
            background: #eee; 
            color: #555; 
            padding: 10px 20px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: 600; 
        }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <div class="container">
        <h1>Tambah Anggota</h1>
        <div class="form-card">
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
                <div class="field">
                    <label>NIS</label>
                    <input type="text" name="nis" required>
                </div>
                <div class="field">
                    <label>Nama</label>
                    <input type="text" name="nama" required>
                </div>
                <div class="field">
                    <label>Kelas</label>
                    <input type="text" name="kelas" required>
                </div>
                <div class="actions">
                    <button type="submit" class="btn-save">Simpan</button>
                    <a href="{{ route('anggota.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>