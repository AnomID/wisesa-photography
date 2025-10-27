<?php

namespace App\Http\Controllers\admin;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriProduks = KategoriProduk::paginate(10);
        return view('page_admin.kategoriProduk.index', compact('kategoriProduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategoriProduk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_produk' => 'required|unique:kategori_produk',
            'deskripsi' => 'nullable',
        ]);

        KategoriProduk::create($request->all());
        Alert::toast('Kategori produk berhasil ditambahkan', 'success')->position('top-end');
        return redirect()->route('kategoriProduk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProduk $kategoriProduk)
    {
        return view('page_admin.kategoriProduk.show', compact('kategoriProduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriProduk $kategoriProduk)
    {
        return view('page_admin.kategoriProduk.edit', compact('kategoriProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriProduk $kategoriProduk)
    {
        $request->validate([
            'kategori_produk' => 'required|unique:kategori_produk,kategori_produk,' . $kategoriProduk->id,
            'deskripsi' => 'nullable',
        ]);

        $kategoriProduk->update($request->all());
        Alert::toast('Kategori produk berhasil diubah', 'success')->position('top-end');
        return redirect()->route('kategoriProduk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriProduk $kategoriProduk)
    {
        $kategoriProduk->delete();
        Alert::toast('Kategori produk berhasil dihapus', 'success')->position('top-end');
        return redirect()->route('kategoriProduk.index');
    }
}
