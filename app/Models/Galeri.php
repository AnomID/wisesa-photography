<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'layanan_id',
        'judul_galeri',
        'gambar',
        'keterangan',
        'slug',
        'list_gallery',
    ];

    protected $casts = [
        'list_gallery' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            $galeri->slug = Str::slug($galeri->keterangan);
        });
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
