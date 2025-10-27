<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama',
        'telephone',
        'area',
        'instagram',
        'address',
        'layanan_id',
        'sub_layanan_id',
        'booking_date',
        'booking_time',
        'booking_end_time',
        'universitas',
        'lokasi_photo',
        'fotografer',
        'biaya',
        'status',
        'catatan',
    ];

    // Status constants
    const STATUS_PENDING = 'Pending';
    const STATUS_DITOLAK = 'Ditolak';
    const STATUS_DITERIMA = 'Diterima';
    const STATUS_DIPROSES = 'Diproses';
    const STATUS_SELESAI = 'Selesai';
    const STATUS_DIBATALKAN = 'Dibatalkan';

    protected $casts = [
        'booking_date' => 'date',
        'catatan' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
    ];

    protected $appends = [];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function subLayanan()
    {
        return $this->belongsTo(SubLayanan::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function progress()
    {
        return $this->hasOne(BookingProgress::class);
    }
}
