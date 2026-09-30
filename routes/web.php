<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\WishlistController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bisa diakses semua yang login (admin & anggota) — buat pinjam buku
    Route::post('/peminjaman', [PeminjamController::class, 'store'])->name('peminjaman.store');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{id}/pinjam', [WishlistController::class, 'pinjam'])->name('wishlist.pinjam');
});

// Khusus admin — kelola data master & peminjaman
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('buku', BukuController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('peminjaman', PeminjamController::class)->except(['store']);
    Route::put('/peminjaman/{id}/kembalikan', [PeminjamController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});

Route::get('/', [LandingController::class, 'index'])->name('landing');

require __DIR__.'/auth.php';
