<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'no_wa' => 'required|string|max:20|unique:users,no_wa',
            'instagram' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'password' => 'required|min:6|confirmed',
            'agree-terms' => 'required',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar',
            'instagram.required' => 'Instagram wajib diisi',
            'instagram.max' => 'Instagram maksimal 100 karakter',
            'area.required' => 'Area wajib diisi',
            'area.max' => 'Area maksimal 100 karakter',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'agree-terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        try {
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'no_wa' => $data['no_wa'],
                'instagram' => $data['instagram'],
                'area' => $data['area'],
                'password' => Hash::make($data['password']),
                'role' => 'user',
            ]);

            Auth::login($user);
            Alert::success('Pendaftaran berhasil!', 'Selamat datang di Linkskuy!');
            return redirect('/');
        } catch (\Exception $e) {
            Alert::error('Gagal mendaftar', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            return back()->withInput();
        }
    }
}
