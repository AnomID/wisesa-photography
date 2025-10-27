<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'layanan_id',
        'judul',
        'deskripsi',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subLayanan) {
            $subLayanan->slug = Str::slug($subLayanan->judul);
        });
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
