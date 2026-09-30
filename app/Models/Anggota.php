<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['nis', 'nama', 'kelas'];

        public function peminjaman()
    {
        return $this->hasMany(Peminjam::class);
    }       
}

