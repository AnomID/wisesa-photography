<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $table = 'kategori_produk';

    protected $fillable = [
        'kategori_produk',
        'slug',
        'deskripsi'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategoriProduk) {
            $kategoriProduk->slug = Str::slug($kategoriProduk->kategori_produk);
        });
    }

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
