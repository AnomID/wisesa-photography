<?php

namespace App\Http\Controllers\admin;

use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RealRashid\SweetAlert\Facades\Alert;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $layanans = Layanan::withCount(['galeris', 'subLayanans'])->paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $layanans = Layanan::where('judul', 'like', '%' . $filter . '%')
                ->withCount(['galeris', 'subLayanans'])
                ->paginate(10);
        }
        return view('page_admin.layanan.index', compact('layanans', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan layanan');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'price_list_pdf' => 'nullable|mimes:pdf|max:10000',
                'deskripsi' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $layanan = new Layanan();
            $layanan->judul = $request->judul;
            $layanan->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/layanan');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/layanan');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80);
                $image->save($path . '/' . $gambarName);

                $layanan->gambar = $gambarName;
            }

            // Upload PDF Price List
            if ($request->hasFile('price_list_pdf')) {
                $pdf = $request->file('price_list_pdf');
                $pdfName = time() . '_price_list.pdf';

                // Pastikan direktori ada
                $pdfPath = public_path('upload/layanan/pdf');
                if (!file_exists($pdfPath)) {
                    Log::info('Membuat direktori upload/layanan/pdf');
                    mkdir($pdfPath, 0777, true);
                }

                $pdf->move($pdfPath, $pdfName);
                $layanan->price_list_pdf = $pdfName;
            }

            Log::info('Mencoba menyimpan data layanan ke database');
            if (!$layanan->save()) {
                Log::error('Gagal menyimpan data layanan ke database');
                throw new \Exception('Gagal menyimpan data layanan');
            }

            Log::info('Layanan berhasil disimpan');
            Alert::toast('Layanan berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('layanan.index');
        } catch (\Exception $e) {
            Log::error('Error in LayananController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        $layanan->load(['galeris', 'subLayanans']);
        return view('page_admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('page_admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'price_list_pdf' => 'nullable|mimes:pdf|max:10000',
                'deskripsi' => 'required',
            ]);

            $layanan->judul = $request->judul;
            $layanan->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($layanan->gambar && file_exists(public_path('upload/layanan/' . $layanan->gambar))) {
                    unlink(public_path('upload/layanan/' . $layanan->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/layanan');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $layanan->gambar = $gambarName;
            }

            // Upload PDF Price List
            if ($request->hasFile('price_list_pdf')) {
                // Hapus PDF lama jika ada
                if ($layanan->price_list_pdf && file_exists(public_path('upload/layanan/pdf/' . $layanan->price_list_pdf))) {
                    unlink(public_path('upload/layanan/pdf/' . $layanan->price_list_pdf));
                }

                $pdf = $request->file('price_list_pdf');
                $pdfName = time() . '_price_list.pdf';

                // Pastikan direktori ada
                $pdfPath = public_path('upload/layanan/pdf');
                if (!file_exists($pdfPath)) {
                    mkdir($pdfPath, 0777, true);
                }

                $pdf->move($pdfPath, $pdfName);
                $layanan->price_list_pdf = $pdfName;
            }

            $layanan->save();
            Alert::toast('Layanan berhasil diubah', 'success')->position('top-end');
            return redirect()->route('layanan.index');
        } catch (\Exception $e) {
            Log::error('Error in LayananController@update: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        try {
            // Hapus gambar jika ada
            if ($layanan->gambar && file_exists(public_path('upload/layanan/' . $layanan->gambar))) {
                unlink(public_path('upload/layanan/' . $layanan->gambar));
            }

            // Hapus PDF jika ada
            if ($layanan->price_list_pdf && file_exists(public_path('upload/layanan/pdf/' . $layanan->price_list_pdf))) {
                unlink(public_path('upload/layanan/pdf/' . $layanan->price_list_pdf));
            }

            $layanan->delete();
            Alert::toast('Layanan berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('layanan.index');
        } catch (\Exception $e) {
            Log::error('Error in LayananController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back();
        }
    }
}
