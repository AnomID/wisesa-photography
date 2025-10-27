<?php

namespace App\Http\Controllers\admin;

use App\Models\Galeri;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RealRashid\SweetAlert\Facades\Alert;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $galeris = Galeri::with('layanan')->paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $galeris = Galeri::whereHas('layanan', function ($query) use ($filter) {
                $query->where('judul', 'like', '%' . $filter . '%');
            })->paginate(10);
        }
        return view('page_admin.galeri.index', compact('galeris', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanans = Layanan::all();
        return view('page_admin.galeri.create', compact('layanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan galeri');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul_galeri' => 'required|string|max:255',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'keterangan' => 'required',
                'layanan_id' => 'required|exists:layanans,id',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/galeri');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/galeri');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $galeri = new Galeri();
                $galeri->judul_galeri = $request->judul_galeri;
                $galeri->gambar = $gambarName;
                $galeri->keterangan = $request->keterangan;
                $galeri->layanan_id = $request->layanan_id;

                Log::info('Mencoba menyimpan data galeri ke database');
                if (!$galeri->save()) {
                    Log::error('Gagal menyimpan data galeri ke database');
                    throw new \Exception('Gagal menyimpan data galeri');
                }

                Log::info('Galeri berhasil disimpan');
                Alert::toast('Galeri berhasil ditambahkan', 'success')->position('top-end');
                return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan');
            } else {
                throw new \Exception('File gambar tidak ditemukan');
            }
        } catch (\Exception $e) {
            Log::error('Error in GaleriController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('page_admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        $layanans = Layanan::all();
        return view('page_admin.galeri.edit', compact('galeri', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        try {
            $request->validate([
                'judul_galeri' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'keterangan' => 'required',
                'layanan_id' => 'required|exists:layanans,id',
            ]);

            $galeri->judul_galeri = $request->judul_galeri;
            $galeri->keterangan = $request->keterangan;
            $galeri->layanan_id = $request->layanan_id;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($galeri->gambar && file_exists(public_path('upload/galeri/' . $galeri->gambar))) {
                    unlink(public_path('upload/galeri/' . $galeri->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/galeri');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $galeri->gambar = $gambarName;
            }

            $galeri->save();
            Alert::toast('Galeri berhasil diubah', 'success')->position('top-end');
            return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in GaleriController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        try {
            if ($galeri->gambar && file_exists(public_path('upload/galeri/' . $galeri->gambar))) {
                unlink(public_path('upload/galeri/' . $galeri->gambar));
            }
            $galeri->delete();
            Alert::toast('Galeri berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in GaleriController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
