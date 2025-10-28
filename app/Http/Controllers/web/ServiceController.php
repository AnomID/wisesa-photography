<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Beranda;
use App\Models\Galeri;
use App\Models\Layanan;
use App\Models\Profil;

class ServiceController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        $layanans = Layanan::all();
        $profil = Profil::first();
        return view('page_web.service.index', compact('beranda', 'layanans', 'profil'));
    }

    public function detail($slug)
    {
        $beranda = Beranda::first();
        $layanan = Layanan::where('slug', $slug)->firstOrFail();
        $galeris = Galeri::where('layanan_id', $layanan->id)->get();
        $profil = Profil::first();
        return view('page_web.service.detail', compact('beranda', 'layanan', 'galeris', 'profil'));
    }
}
