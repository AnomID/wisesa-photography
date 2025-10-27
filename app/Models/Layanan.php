<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar',
        'price_list_pdf',
        'deskripsi',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->judul);
        });
    }

    public function galeris()
    {
        return $this->hasMany(Galeri::class, 'layanan_id');
    }

    public function subLayanans()
    {
        return $this->hasMany(SubLayanan::class, 'layanan_id');
    }
}
