<style>
    .gallery-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(150px,1fr)); gap:16px; }
    .cover-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.06); cursor:pointer; transition:transform 0.15s, box-shadow 0.15s; }
    .cover-card:hover { transform:translateY(-6px); box-shadow:0 12px 24px rgba(0,0,0,0.12); }
    .cover-art { position:relative; overflow:hidden; aspect-ratio:2/3; display:flex; align-items:center; justify-content:center; font-size:48px; font-weight:800; color:#fff; }
    .cover-art img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
    .cover-c1 { background:linear-gradient(135deg,#c9822a,#a8681c); }
    .cover-c2 { background:linear-gradient(135deg,#4a7c6e,#386155); }
    .cover-c3 { background:linear-gradient(135deg,#5b3a29,#3a2517); }
    .cover-c4 { background:linear-gradient(135deg,#a83232,#7a2323); }
    .cover-c5 { background:linear-gradient(135deg,#3a6b8a,#254a63); }
    .cover-info { padding:12px 14px; }
    .cover-info h4 { font-size:14px; color:#3a2e22; margin-bottom:2px; }
    .cover-info p { font-size:12px; color:#7a6f63; }
    .cover-stok { font-size:11px; font-weight:600; color:#a8681c; }

    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(46,42,38,0.4); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); z-index:50; align-items:center; justify-content:center; padding:20px; }
    .modal-overlay.active { display:flex; }
    .modal-box { background:#fff; border-radius:12px; max-width:820px; width:100%; padding:32px; max-height:85vh; overflow-y:auto; display:flex; gap:28px; }
    .modal-cover { width:240px; height:340px; flex-shrink:0; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:72px; font-weight:800; color:#fff; overflow:hidden; }
    .modal-info h2 { color:#5b3a29; margin-bottom:6px; font-size:24px; }
    .modal-info .meta { font-size:14px; color:#7a6f63; margin-bottom:18px; }
    .modal-info .sinopsis { font-size:14px; line-height:1.7; color:#3a2e22; margin-bottom:22px; max-height:none; overflow-y:visible; } .modal-info select { width:100%; padding:9px 10px; border:1px solid #ddd3c4; border-radius:6px; font-size:13px; margin-bottom:10px; }
    .modal-actions { display:flex; gap:8px; flex-wrap:wrap; }
    .btn-pinjam { background:#c9822a; color:#fff; border:none; padding:9px 16px; border-radius:6px; font-weight:600; cursor:pointer; font-size:13px; }
    .btn-pinjam:hover { background:#a8681c; }
    .btn-daftar { background:#4a7c6e; color:#fff; border:none; padding:9px 16px; border-radius:6px; font-weight:600; cursor:pointer; font-size:13px; }
    .btn-daftar:hover { background:#386155; }
    .btn-close { background:#eee; color:#555; border:none; padding:9px 16px; border-radius:6px; font-weight:600; cursor:pointer; font-size:13px; }</style>

<div class="gallery-grid">
    @forelse($buku as $item)
    <div class="cover-card" onclick="bukaModal({{ $item->id }})">
        @if($item->cover)
            <div class="cover-art">
                <img src="{{ asset('storage/'.$item->cover) }}" alt="{{ $item->judul }}">
            </div>
        @else
            <div class="cover-art cover-c{{ ($item->id % 5) + 1 }}">{{ strtoupper(substr($item->judul, 0, 1)) }}</div>
        @endif
        <div class="cover-info">
            <h4>{{ $item->judul }}</h4>
            <p>{{ $item->pengarang }}</p>
            <span class="cover-stok">Stok: {{ $item->stok }}</span>
        </div>
    </div>
    @empty
    <p style="color:#a89f92;">Belum ada buku.</p>
    @endforelse
</div>

<div class="modal-overlay" id="modalBuku">
    <div class="modal-box">
        <div class="modal-cover" id="modalCover"></div>
        <div class="modal-info">
            <h2 id="modalJudul"></h2>
            <div class="meta" id="modalMeta"></div>
            <div class="sinopsis" id="modalSinopsis"></div>

            @auth
            <form id="formAksi" method="POST">
                @csrf
                <input type="hidden" name="buku_id" id="modalBukuId">
                <input type="hidden" name="tanggal_pinjam" value="{{ now()->toDateString() }}">

                @if(auth()->user()->role === 'admin')
                <select name="anggota_id" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggota as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }} ({{ $a->nis }})</option>
                    @endforeach
                </select>
                @endif

                <div class="modal-actions">
                    <button type="submit" formaction="{{ route('wishlist.store') }}" class="btn-daftar">Masukkan Daftar</button>
                    <button type="submit" formaction="{{ route('peminjaman.store') }}" class="btn-pinjam">Pinjam</button>
                    <button type="button" class="btn-close" onclick="tutupModal()">Tutup</button>
                </div>
            </form>
            @else
            <div class="modal-actions">
                <a href="{{ route('login') }}" class="btn-pinjam" style="text-decoration:none;">Login untuk Meminjam</a>
                <button type="button" class="btn-close" onclick="tutupModal()">Tutup</button>
            </div>
            @endauth
        </div>
    </div>
</div>

<script>
    const dataBuku = @json($buku);

    function bukaModal(id) {
        const b = dataBuku.find(x => x.id === id);
        if (!b) return;
        const warna = ['#c9822a','#4a7c6e','#5b3a29','#a83232','#3a6b8a'];
        const cover = document.getElementById('modalCover');
        if (b.cover) {
            cover.style.background = 'none';
            cover.innerHTML = '<img src="/storage/' + b.cover + '" style="width:100%; height:100%; object-fit:cover; border-radius:8px;">';
        } else {
            cover.style.background = warna[id % 5];
            cover.innerHTML = b.judul.charAt(0).toUpperCase();
        }
        document.getElementById('modalJudul').innerText = b.judul;
        document.getElementById('modalMeta').innerText = b.pengarang + ' · ' + b.penerbit + ' (' + b.tahun_terbit + ')';
        document.getElementById('modalSinopsis').innerText = b.sinopsis || 'Belum ada sinopsis untuk buku ini.';
        const inputId = document.getElementById('modalBukuId');
        if (inputId) inputId.value = b.id;
        document.getElementById('modalBuku').classList.add('active');
    }                                                                    
    function tutupModal() {
        document.getElementById('modalBuku').classList.remove('active');
    }
</script>