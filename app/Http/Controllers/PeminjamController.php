<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Models\Buku;
use App\Models\Anggota;

class PeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $peminjam = Peminjam::with(['buku', 'anggota'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()->get();

        return view('peminjaman.index', compact('peminjam', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buku = Buku::all();
        $anggota = Anggota::all();
        return view('peminjaman.create', compact('buku','anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $anggotaId = auth()->user()->role === 'admin'
            ? $request->input('anggota_id')
            : auth()->user()->anggota_id;

        $request->merge(['anggota_id' => $anggotaId]);

        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        $jumlahDipinjam = Peminjam::where('anggota_id', $anggotaId)
            ->whereRaw('LOWER(status) = ?', ['dipinjam'])
            ->count();

        if ($jumlahDipinjam >= 2) {
            return back()->with('error', 'Kamu sudah meminjam 2 buku, tidak bisa meminjam lagi sebelum mengembalikan salah satunya.');
        }

        Peminjam::create([
            'buku_id' => $request->buku_id,
            'anggota_id' => $anggotaId,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'Dipinjam',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function kembalikan($id)
    {
        $peminjam = Peminjam::findOrFail($id);

        $peminjam->update([
            'tanggal_kembali' => now()->toDateString(),
            'status' => 'Dikembalikan',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan!');
    }
}
