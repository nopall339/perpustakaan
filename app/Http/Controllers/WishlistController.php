<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Peminjam;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = auth()->user()->role === 'admin'
            ? Wishlist::with(['buku', 'anggota'])->latest()->get()
            : Wishlist::with(['buku', 'anggota'])->where('anggota_id', auth()->user()->anggota_id)->latest()->get();

        return view('wishlist.index', compact('wishlist'));
    }

    public function store(Request $request)
    {
        $anggotaId = auth()->user()->role === 'admin'
            ? $request->input('anggota_id')
            : auth()->user()->anggota_id;

        $request->merge(['anggota_id' => $anggotaId]);

        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'anggota_id' => 'required|exists:anggotas,id',
        ]);

        $sudahAda = Wishlist::where('anggota_id', $anggotaId)
            ->where('buku_id', $request->buku_id)->exists();

        if ($sudahAda) {
            return back()->with('error', 'Buku ini sudah ada di daftarmu.');
        }

        Wishlist::create(['anggota_id' => $anggotaId, 'buku_id' => $request->buku_id]);

        return back()->with('success', 'Buku dimasukkan ke daftar!');
    }

    public function destroy(string $id)
    {
        wishlist::findOrFail($id)->delete();
        return redirect()->route('wishlist.index')->with('succes', 'Dihapus dari daftar wishlist.');
    }

    public function pinjam(string $id)
    {
        $wish = Wishlist::findOrFail($id);

        $jumlahDipinjam = Peminjam::where('anggota_id', $wish->anggota_id)
            ->whereRaw('LOWER(status) = ?', ['dipinjam'])
            ->count();

        if ($jumlahDipinjam >= 2) {
            return back()->with('error', 'Anggota ini sudah meminjam 2 buku, tidak bisa meminjam lagi.');
        }

        Peminjam::create([
            'buku_id' => $wish->buku_id,
            'anggota_id' => $wish->anggota_id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'dipinjam'
        ]);

        $wish->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dipinjam.');
    }
}
