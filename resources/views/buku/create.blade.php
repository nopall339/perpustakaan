<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f1ea;
            color: #2e2a26;
        }
        .container { 
            max-width: 480px; 
            margin: 0 auto; 
            padding: 40px 20px;
        }
        h1 {
            font-size: 24px;
            color: #5b3a29;
            border-left: 6px solid #c9822a;
            padding-left: 12px;
            margin-bottom: 24px;
        }
        .form-card {
            background: #fff;
            border-radius: 10px;
            padding: 28px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .field { margin-bottom: 16px; }
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
            font-size: 14px;
        }
        .field input:focus {
            outline: none;
            border-color: #c9822a;
        }
        .actions { display: flex; gap: 10px; margin-top: 22px; }
        .btn-save {
            background: #c9822a;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-save:hover { background: #a8681c; }
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
        <h1>Tambah Buku Baru</h1>
        <div class="form-card">
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                <div class="alert" style="background:#fdecea; color:#a83232; border-left-color:#a83232;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="field">
                    <label>Cover Buku</label>
                    <input type="file" name="cover" accept="image/*">
                 </div>
                <div class="field">
                    <label>Kode Buku</label>
                    <input type="text" name="kode_buku" required>
                </div>
                <div class="field">
                    <label>Judul</label>
                    <input type="text" name="judul" required>
                </div>
                <div class="field">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" required>
                </div>
                <div class="field">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" required>
                </div>
                <div class="field">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" required>
                </div>
                <div class="field">
                    <label>Stok</label>
                    <input type="number" name="stok" required>
                </div>
                <div class="field">
                    <label>Sinopsis</label>
                    <textarea name="sinopsis" rows="4" style="width:100%; padding:10px 12px; border:1px solid #ddd3c4; border-radius:6px; font-size:14px; font-family:inherit;"></textarea>
                </div>
                <div class="actions">
                    <button type="submit" class="btn-save">Simpan</button>
                    <a href="{{ route('buku.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>