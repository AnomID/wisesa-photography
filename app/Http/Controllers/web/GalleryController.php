<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Beranda;
use App\Models\Galeri;
use App\Models\Layanan;
use App\Models\Profil;

class GalleryController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        $layanans = Layanan::all();
        $galeris = Galeri::with('layanan')->latest()->get();
        $profil = Profil::first();
        return view('page_web.gallery.index', compact('beranda', 'galeris', 'layanans', 'profil'));
    }

    public function detail($slug)
    {
        $beranda = Beranda::first();
        $galeri = Galeri::with('layanan')->where('slug', $slug)->firstOrFail();
        $galeris = Galeri::with('layanan')->where('id', '!=', $galeri->id)->latest()->take(4)->get();
        $profil = Profil::first();
        return view('page_web.gallery.detail', compact('beranda', 'galeri', 'galeris', 'profil'));
    }
}
