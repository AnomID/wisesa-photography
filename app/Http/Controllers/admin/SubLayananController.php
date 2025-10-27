<?php

namespace App\Http\Controllers\admin;

use App\Models\SubLayanan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SubLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subLayanans = SubLayanan::with('layanan')->paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $subLayanans = SubLayanan::where('judul', 'like', '%' . $filter . '%')
                ->orWhereHas('layanan', function ($query) use ($filter) {
                    $query->where('judul', 'like', '%' . $filter . '%');
                })
                ->paginate(10);
        }
        return view('page_admin.sub_layanan.index', compact('subLayanans', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanans = Layanan::all();
        return view('page_admin.sub_layanan.create', compact('layanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan sub layanan');
            Log::info('Request data:', $request->all());

            $request->validate([
                'layanan_id' => 'required|exists:layanans,id',
                'judul' => 'required',
                'deskripsi' => 'nullable',
            ]);

            $subLayanan = new SubLayanan();
            $subLayanan->layanan_id = $request->layanan_id;
            $subLayanan->judul = $request->judul;
            $subLayanan->deskripsi = $request->deskripsi;

            Log::info('Mencoba menyimpan data sub layanan ke database');
            if (!$subLayanan->save()) {
                Log::error('Gagal menyimpan data sub layanan ke database');
                throw new \Exception('Gagal menyimpan data sub layanan');
            }

            Log::info('Sub layanan berhasil disimpan');
            Alert::toast('Sub layanan berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('sub-layanan.index');
        } catch (\Exception $e) {
            Log::error('Error in SubLayananController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubLayanan $subLayanan)
    {
        return view('page_admin.sub_layanan.show', compact('subLayanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubLayanan $subLayanan)
    {
        $layanans = Layanan::all();
        return view('page_admin.sub_layanan.edit', compact('subLayanan', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubLayanan $subLayanan)
    {
        try {
            $request->validate([
                'layanan_id' => 'required|exists:layanans,id',
                'judul' => 'required',
                'deskripsi' => 'nullable',
            ]);

            $subLayanan->layanan_id = $request->layanan_id;
            $subLayanan->judul = $request->judul;
            $subLayanan->deskripsi = $request->deskripsi;
            $subLayanan->save();

            Alert::toast('Sub layanan berhasil diubah', 'success')->position('top-end');
            return redirect()->route('sub-layanan.index');
        } catch (\Exception $e) {
            Log::error('Error in SubLayananController@update: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubLayanan $subLayanan)
    {
        try {
            $subLayanan->delete();
            Alert::toast('Sub layanan berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('sub-layanan.index');
        } catch (\Exception $e) {
            Log::error('Error in SubLayananController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back();
        }
    }
}
