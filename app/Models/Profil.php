<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'no_telp_perusahaan',
        'logo_perusahaan',
        'alamat_perusahaan',
        'latitude',
        'longitude',
        'email_perusahaan',
        'instagram_perusahaan',
        'facebook_perusahaan',
        'tiktok_perusahaan',
        'whatsapp_perusahaan',
        'gambar',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profil) {
            $profil->slug = Str::slug($profil->nama_perusahaan);
        });
    }
}
