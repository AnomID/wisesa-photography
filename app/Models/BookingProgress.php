<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingProgress extends Model
{
    use HasFactory;

    protected $table = 'booking_progress';

    protected $fillable = [
        'booking_id',
        'jadwal_foto',
        'jadwal_foto_at',
        'file_jpg_upload',
        'file_jpg_link',
        'file_jpg_upload_at',
        'selected_photos',
        'selected_photos_link',
        'selected_photos_at',
        'file_raw_upload',
        'file_raw_upload_at',
        'editing_foto',
        'editing_foto_at',
        'foto_edited_upload',
        'foto_edited_upload_at',
    ];

    protected $casts = [
        'jadwal_foto' => 'boolean',
        'jadwal_foto_at' => 'datetime',
        'file_jpg_upload' => 'boolean',
        'file_jpg_upload_at' => 'datetime',
        'selected_photos' => 'boolean',
        'selected_photos_at' => 'datetime',
        'file_raw_upload' => 'boolean',
        'file_raw_upload_at' => 'datetime',
        'editing_foto' => 'boolean',
        'editing_foto_at' => 'datetime',
        'foto_edited_upload' => 'boolean',
        'foto_edited_upload_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
