<?php

namespace App\Http\Controllers\admin;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produks = Produk::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $produks = Produk::where('judul', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.produk.index', compact('produks', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriProduks = KategoriProduk::all();
        return view('page_admin.produk.create', compact('kategoriProduks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan produk');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'master_kategori_produk_id' => 'required|exists:kategori_produk,id',
                'deskripsi' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $produk = new Produk();
            $produk->judul = $request->judul;
            $produk->master_kategori_produk_id = $request->master_kategori_produk_id;
            $produk->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/produk');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/produk');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $produk->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data produk ke database');
            if (!$produk->save()) {
                Log::error('Gagal menyimpan data produk ke database');
                throw new \Exception('Gagal menyimpan data produk');
            }

            Log::info('Produk berhasil disimpan');
            Alert::toast('Produk berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('produk.index');
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        return view('page_admin.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategoriProduks = KategoriProduk::all();
        return view('page_admin.produk.edit', compact('produk', 'kategoriProduks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'master_kategori_produk_id' => 'required|exists:kategori_produk,id',
            'deskripsi' => 'required',
        ]);

        try {
            $produk->judul = $request->judul;
            $produk->master_kategori_produk_id = $request->master_kategori_produk_id;
            $produk->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar && file_exists(public_path('upload/produk/' . $produk->gambar))) {
                    unlink(public_path('upload/produk/' . $produk->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/produk');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $produk->gambar = $gambarName;
            }

            $produk->save();
            Alert::toast('Produk berhasil diubah', 'success')->position('top-end');
            return redirect()->route('produk.index');
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@update: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        try {
            // Hapus gambar jika ada
            if ($produk->gambar && file_exists(public_path('upload/produk/' . $produk->gambar))) {
                unlink(public_path('upload/produk/' . $produk->gambar));
            }

            $produk->delete();
            Alert::toast('Produk berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('produk.index');
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back();
        }
    }
}
