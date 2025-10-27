<?php

namespace App\Http\Controllers\admin;

use App\Models\Profil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profils = Profil::latest()->get();
        return view('page_admin.profil.index', compact('profils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.profil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_perusahaan' => 'required',
                'no_telp_perusahaan' => 'required',
                'logo_perusahaan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'alamat_perusahaan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'email_perusahaan' => 'required|email',
                'instagram_perusahaan' => 'nullable|string',
                'facebook_perusahaan' => 'nullable|string',
                'tiktok_perusahaan' => 'nullable|string',
                'whatsapp_perusahaan' => 'nullable|string',
            ]);

            $profil = new Profil();
            $profil->nama_perusahaan = $request->nama_perusahaan;
            $profil->no_telp_perusahaan = $request->no_telp_perusahaan;
            $profil->alamat_perusahaan = $request->alamat_perusahaan;
            $profil->latitude = $request->latitude;
            $profil->longitude = $request->longitude;
            $profil->email_perusahaan = $request->email_perusahaan;
            $profil->instagram_perusahaan = $request->instagram_perusahaan;
            $profil->facebook_perusahaan = $request->facebook_perusahaan;
            $profil->tiktok_perusahaan = $request->tiktok_perusahaan;
            $profil->whatsapp_perusahaan = $request->whatsapp_perusahaan;

            if ($request->hasFile('logo_perusahaan')) {
                $logo = $request->file('logo_perusahaan');
                $logoName = time() . '.webp';
                $path = public_path('upload/profil');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($logo);
                $image->toWebp(80);
                $image->save($path . '/' . $logoName);
                $profil->logo_perusahaan = $logoName;
            }

            $profil->save();
            Alert::toast('Profil berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('profil.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profil $profil)
    {
        return view('page_admin.profil.show', compact('profil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profil $profil)
    {
        return view('page_admin.profil.edit', compact('profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profil $profil)
    {
        try {
            $request->validate([
                'nama_perusahaan' => 'required',
                'no_telp_perusahaan' => 'required',
                'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'alamat_perusahaan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'email_perusahaan' => 'required|email',
                'instagram_perusahaan' => 'nullable|string',
                'facebook_perusahaan' => 'nullable|string',
                'tiktok_perusahaan' => 'nullable|string',
                'whatsapp_perusahaan' => 'nullable|string',
            ]);

            $profil->nama_perusahaan = $request->nama_perusahaan;
            $profil->no_telp_perusahaan = $request->no_telp_perusahaan;
            $profil->alamat_perusahaan = $request->alamat_perusahaan;
            $profil->latitude = $request->latitude;
            $profil->longitude = $request->longitude;
            $profil->email_perusahaan = $request->email_perusahaan;
            $profil->instagram_perusahaan = $request->instagram_perusahaan;
            $profil->facebook_perusahaan = $request->facebook_perusahaan;
            $profil->tiktok_perusahaan = $request->tiktok_perusahaan;
            $profil->whatsapp_perusahaan = $request->whatsapp_perusahaan;

            if ($request->hasFile('logo_perusahaan')) {
                // Hapus logo lama jika ada
                if ($profil->logo_perusahaan && file_exists(public_path('upload/profil/' . $profil->logo_perusahaan))) {
                    unlink(public_path('upload/profil/' . $profil->logo_perusahaan));
                }
                $logo = $request->file('logo_perusahaan');
                $logoName = time() . '.webp';
                $path = public_path('upload/profil');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($logo);
                $image->toWebp(80);
                $image->save($path . '/' . $logoName);
                $profil->logo_perusahaan = $logoName;
            }

            $profil->save();
            Alert::toast('Profil berhasil diubah', 'success')->position('top-end');
            return redirect()->route('profil.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil $profil)
    {
        try {
            // Hapus gambar jika ada
            if ($profil->logo_perusahaan && file_exists(public_path('upload/profil/' . $profil->logo_perusahaan))) {
                unlink(public_path('upload/profil/' . $profil->logo_perusahaan));
            }

            $profil->delete();
            Alert::toast('Profil berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('profil.index');
        } catch (\Exception $e) {
            Log::error('Error in ProfilController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back();
        }
    }
}
