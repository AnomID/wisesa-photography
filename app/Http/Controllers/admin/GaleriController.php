<?php

namespace App\Http\Controllers\admin;

use App\Models\Galeri;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
                'list_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
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

                // Proses upload multiple gambar untuk list_gallery
                $listGallery = [];
                if ($request->hasFile('list_gambar')) {
                    foreach ($request->file('list_gambar') as $index => $file) {
                        $listGambarName = time() . '_' . ($index + 1) . '.webp';
                        $listImage = $manager->read($file);
                        $listImage->toWebp(80);
                        $listImage->save($path . '/' . $listGambarName);

                        $listGallery[] = [
                            'judul_galeri' => $request->input('list_judul.' . $index, ''),
                            'gambar' => $listGambarName,
                            'keterangan' => $request->input('list_keterangan.' . $index, ''),
                            'slug' => Str::slug($request->input('list_judul.' . $index, '')),
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }

                $galeri = new Galeri();
                $galeri->judul_galeri = $request->judul_galeri;
                $galeri->gambar = $gambarName;
                $galeri->keterangan = $request->keterangan;
                $galeri->layanan_id = $request->layanan_id;
                $galeri->list_gallery = count($listGallery) > 0 ? $listGallery : null;

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
                'list_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            ]);

            $galeri->judul_galeri = $request->judul_galeri;
            $galeri->keterangan = $request->keterangan;
            $galeri->layanan_id = $request->layanan_id;

            $path = public_path('upload/galeri');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $manager = new ImageManager(new Driver());

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($galeri->gambar && file_exists(public_path('upload/galeri/' . $galeri->gambar))) {
                    unlink(public_path('upload/galeri/' . $galeri->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Konversi ke WebP
                $image = $manager->read($gambar);
                $image->toWebp(80);
                $image->save($path . '/' . $gambarName);

                $galeri->gambar = $gambarName;
            }

            // Proses update list_gallery
            $listGallery = $galeri->list_gallery ?? [];

            // Handle hapus item dari list_gallery
            if ($request->has('hapus_gambar')) {
                foreach ($request->hapus_gambar as $index) {
                    $item = $listGallery[$index] ?? null;
                    if ($item && isset($item['gambar']) && file_exists(public_path('upload/galeri/' . $item['gambar']))) {
                        unlink(public_path('upload/galeri/' . $item['gambar']));
                    }
                    unset($listGallery[$index]);
                }
                $listGallery = array_values($listGallery); // Re-index array
            }

            // Handle upload gambar baru untuk list_gallery
            if ($request->hasFile('list_gambar')) {
                foreach ($request->file('list_gambar') as $index => $file) {
                    $listGambarName = time() . '_' . ($index + 1) . '.webp';
                    $listImage = $manager->read($file);
                    $listImage->toWebp(80);
                    $listImage->save($path . '/' . $listGambarName);

                    // Update atau tambah item
                    if (isset($request->input('list_index')[$index])) {
                        $listIndex = $request->input('list_index')[$index];
                        if (isset($listGallery[$listIndex])) {
                            // Hapus gambar lama jika ada
                            if (isset($listGallery[$listIndex]['gambar']) && file_exists(public_path('upload/galeri/' . $listGallery[$listIndex]['gambar']))) {
                                unlink(public_path('upload/galeri/' . $listGallery[$listIndex]['gambar']));
                            }
                            $listGallery[$listIndex]['gambar'] = $listGambarName;
                        }
                    } else {
                        // Tambah item baru
                        $listGallery[] = [
                            'judul_galeri' => $request->input('list_judul.' . $index, ''),
                            'gambar' => $listGambarName,
                            'keterangan' => $request->input('list_keterangan.' . $index, ''),
                            'slug' => Str::slug($request->input('list_judul.' . $index, '')),
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }
            }

            // Update judul dan keterangan untuk list_gallery yang sudah ada
            if ($request->has('list_judul_existing')) {
                foreach ($request->input('list_judul_existing') as $index => $judul) {
                    if (isset($listGallery[$index])) {
                        $listGallery[$index]['judul_galeri'] = $judul;
                        $listGallery[$index]['keterangan'] = $request->input('list_keterangan_existing.' . $index, '');
                        $listGallery[$index]['slug'] = Str::slug($judul);
                        $listGallery[$index]['updated_at'] = now()->toDateTimeString();
                    }
                }
            }

            $galeri->list_gallery = count($listGallery) > 0 ? $listGallery : null;

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
     * Swap gambar dengan item gallery
     */
    public function swap(Request $request)
    {
        try {
            $request->validate([
                'gallery_id' => 'required|exists:galeris,id',
                'gallery_index' => 'required|integer',
            ]);

            $galeri = Galeri::findOrFail($request->gallery_id);

            if (!$galeri->list_gallery || !isset($galeri->list_gallery[$request->gallery_index])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item gallery tidak ditemukan'
                ], 404);
            }

            // Simpan data untuk swap
            $mainJudul = $galeri->judul_galeri;
            $mainKeterangan = $galeri->keterangan;
            $mainGambar = $galeri->gambar;

            $galleryItem = $galeri->list_gallery[$request->gallery_index];
            $galleryJudul = $galleryItem['judul_galeri'] ?? '';
            $galleryKeterangan = $galleryItem['keterangan'] ?? '';
            $galleryGambar = $galleryItem['gambar'] ?? '';

            $mainPath = public_path('upload/galeri/' . $mainGambar);
            $galleryPath = public_path('upload/galeri/' . $galleryGambar);

            if (file_exists($mainPath) && file_exists($galleryPath)) {
                $tempPath = public_path('upload/galeri/temp_' . time() . '_' . $mainGambar);
                copy($mainPath, $tempPath);
                copy($galleryPath, $mainPath);
                copy($tempPath, $galleryPath);

                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
            }

            $galeri->judul_galeri = $galleryJudul;
            $galeri->keterangan = $galleryKeterangan;

            $listGallery = $galeri->list_gallery;
            $listGallery[$request->gallery_index]['judul_galeri'] = $mainJudul;
            $listGallery[$request->gallery_index]['keterangan'] = $mainKeterangan;
            $galeri->list_gallery = $listGallery;

            $galeri->save();

            return response()->json([
                'success' => true,
                'message' => 'Gambar, judul dan keterangan berhasil di-swap',
                'data' => [
                    'main_judul' => $galeri->judul_galeri,
                    'gallery_judul' => $listGallery[$request->gallery_index]['judul_galeri']
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in GaleriController@swap: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        try {
            // Hapus gambar utama
            if ($galeri->gambar && file_exists(public_path('upload/galeri/' . $galeri->gambar))) {
                unlink(public_path('upload/galeri/' . $galeri->gambar));
            }

            // Hapus semua gambar dari list_gallery
            if ($galeri->list_gallery && is_array($galeri->list_gallery)) {
                foreach ($galeri->list_gallery as $item) {
                    if (isset($item['gambar']) && file_exists(public_path('upload/galeri/' . $item['gambar']))) {
                        unlink(public_path('upload/galeri/' . $item['gambar']));
                    }
                }
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
