<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;

class LandingController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        $anggota = auth()->check() ? Anggota::all() : collect();
        
        return view('landing', compact('buku', 'anggota'));
    }
}
