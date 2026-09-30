<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'stok',
        'sinopsis',
        'cover'
    ];

    

    public function peminjaman()
    {
        return $this->hasMany(Peminjam::class);
    }
}
