<x-app-layout>
    @php
        $buku = \App\Models\Buku::all();
        $anggota = \App\Models\Anggota::all();
        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $totalBuku = $buku->count();
            $sedangDipinjam = \App\Models\Peminjam::whereRaw('LOWER(status) = ?', ['dipinjam'])->count();
            $totalAnggota = $anggota->count();
        }
    @endphp

    <style>
        .dash-wrap { max-width:1100px; margin:0 auto; padding:32px 20px; }
        .dash-greeting h3 { font-size:22px; font-weight:600; color:#5b3a29; }
        .dash-greeting p { font-size:14px; color:#7a6f63; margin-top:2px; }
        .stat-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:14px; margin:20px 0 32px; }
        .stat-card { background:#fff; border:1px solid #e6dfd0; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:12px; }
        .stat-icon { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
        .stat-label { font-size:13px; color:#7a6f63; }
        .stat-value { font-size:24px; font-weight:600; color:#3a2e22; }
        .section-title { font-size:17px; font-weight:600; color:#5b3a29; border-left:5px solid #c9822a; padding-left:12px; margin:0 0 16px; }
    </style>

    <div class="dash-wrap">
        <div class="dash-greeting">
            <h3>Halo, {{ auth()->user()->name }}</h3>
            <p>Ringkasan perpustakaan hari ini</p>
        </div>

        @if($isAdmin)
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f4e3d0;">📖</div>
                <div>
                    <div class="stat-label">Total buku</div>
                    <div class="stat-value">{{ $totalBuku }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#dcebe6;">🔄</div>
                <div>
                    <div class="stat-label">Sedang dipinjam</div>
                    <div class="stat-value">{{ $sedangDipinjam }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#e3ecf3;">👥</div>
                <div>
                    <div class="stat-label">Anggota terdaftar</div>
                    <div class="stat-value">{{ $totalAnggota }}</div>
                </div>
            </div>
        </div>
        @endif

        <h4 class="section-title" style="{{ $isAdmin ? '' : 'margin-top:24px;' }}">Koleksi buku</h4>
        @include('partials.buku-gallery')
    </div>
</x-app-layout>