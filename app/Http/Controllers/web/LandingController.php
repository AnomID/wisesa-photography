<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Beranda;
use App\Models\Tentang;
use App\Models\Galeri;
use App\Models\Testimoni;
use App\Models\Layanan;
use App\Models\Profil;

class LandingController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        $tentang = Tentang::first();
        $galeris = Galeri::with('layanan')->latest()->take(4)->get();
        $testimonis = Testimoni::latest()->take(5)->get();
        $profil = Profil::first();

        $layanans = Layanan::with('galeris')
            ->whereIn('id', [1, 2, 3, 4])
            ->orderBy('id', 'asc')
            ->get();

        return view('page_web.landing.index', compact('beranda', 'tentang', 'galeris', 'testimonis', 'layanans', 'profil'));
    }
}
