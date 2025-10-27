<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function index()
    {
        $profil = Profil::first();
        return view('page_web.contact.index', compact('profil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'pesan' => 'required|string',
            'h-captcha-response' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'no_hp.required' => 'No. HP wajib diisi',
            'no_hp.numeric' => 'No. HP harus berupa angka',
            'no_hp.digits_between' => 'No. HP harus antara 10-15 digit',
            'pesan.required' => 'Pesan wajib diisi',
            'h-captcha-response.required' => 'Captcha wajib diisi',
        ]);

        $hcaptchaResponse = $request->input('h-captcha-response');
        $secretKey = config('hcaptcha.secret_key');

        $response = Http::asForm()->post(config('hcaptcha.verify_url'), [
            'secret' => $secretKey,
            'response' => $hcaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $responseData = $response->json();

        if (!$responseData['success']) {
            Alert::error('Error', 'Verifikasi Captcha gagal. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }

        Kontak::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan,
            'status' => 'Unread',
        ]);

        Alert::success('Berhasil', 'Pesan Anda telah berhasil dikirim!');
        return redirect()->back();
    }
}
