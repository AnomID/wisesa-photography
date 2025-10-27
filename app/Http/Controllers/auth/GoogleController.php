<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Alert::error('Terjadi kesalahan saat redirect ke Google. Silakan coba lagi.');
            return redirect('/login');
        }
    }

    public function handleGoogleCallback()
    {
        try {
            // Socialite sudah dikonfigurasi dengan Guzzle verify => false di AppServiceProvider
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                Auth::login($user);

                // Cek apakah username, no_wa, instagram, dan area sudah ada
                if (empty($user->username) || empty($user->no_wa) || empty($user->instagram) || empty($user->area)) {
                    // Jika belum ada, redirect ke halaman lengkapi data
                    return redirect()->route('google.complete', ['user_id' => $user->id]);
                }

                // Redirect langsung untuk user yang sudah terdaftar dan sudah lengkap datanya
                if ($user->role == 'superadmin') {
                    return redirect()->route('dashboard-superadmin');
                } else {
                    return redirect('/');
                }
            }

            // Jika user belum terdaftar, buat user baru dengan data minimal
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(uniqid()),
                'role' => 'user',
                'google_id' => $googleUser->getId(),
                'foto_profile' => $googleUser->getAvatar(),
            ]);

            Auth::login($user);

            // Redirect langsung ke halaman lengkapi data untuk user baru
            return redirect()->route('google.complete', ['user_id' => $user->id]);
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Handle invalid state exception dengan redirect dan alert
            Alert::error('Sesi OAuth tidak valid', 'Silakan coba login lagi.');
            return redirect('/login');
        } catch (\Exception $e) {
            // Handle SSL certificate errors dan error lainnya dengan redirect dan alert
            $errorMessage = $e->getMessage();
            $customMessage = 'Terjadi kesalahan saat login dengan Google.';

            if (
                strpos($errorMessage, 'SSL certificate problem') !== false ||
                strpos($errorMessage, 'cURL error 60') !== false
            ) {
                $customMessage = 'Masalah SSL Certificate. Terjadi masalah dengan sertifikat SSL. Silakan coba lagi atau hubungi administrator.';
            } elseif (strpos($errorMessage, 'Client error') !== false) {
                $customMessage = 'Error OAuth. Terjadi kesalahan pada OAuth. Pastikan konfigurasi Google OAuth sudah benar.';
            } else {
                $customMessage = 'Terjadi kesalahan saat login dengan Google: ' . $errorMessage;
            }

            Alert::error('Error Google OAuth', $customMessage);
            return redirect('/login');
        }
    }

    public function showCompleteForm(Request $request)
    {
        $user_id = $request->query('user_id');
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            Alert::error('Data Google tidak ditemukan.', 'Silakan login dengan Google terlebih dahulu.');
            return redirect('/login');
        }

        return view('auth.complete-google-register', ['user' => $user]);
    }

    public function completeRegister(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'no_wa' => 'required|string|max:20|unique:users,no_wa',
            'instagram' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'agree-terms' => 'required',
            'user_id' => 'required|string|exists:users,id',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar',
            'instagram.required' => 'Instagram wajib diisi',
            'instagram.max' => 'Instagram maksimal 100 karakter',
            'area.required' => 'Area wajib diisi',
            'area.max' => 'Area maksimal 100 karakter',
            'agree-terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        $user = User::where('id', $data['user_id'])->first();

        if (!$user) {
            Alert::error('Data Google tidak ditemukan.', 'Silakan login dengan Google terlebih dahulu.');
            return redirect('/login');
        }

        try {
            $user->update([
                'username' => $data['username'],
                'no_wa' => $data['no_wa'],
                'instagram' => $data['instagram'],
                'area' => $data['area'],
            ]);

            Auth::login($user);

            Alert::success('Akun berhasil dibuat lewat Google!', 'Selamat datang di Linkskuy!');
            return redirect('/');
        } catch (\Exception $e) {
            Alert::error('Gagal menyelesaikan pendaftaran', 'Terjadi kesalahan. Silakan coba lagi.');
            return back()->withInput();
        }
    }
}
