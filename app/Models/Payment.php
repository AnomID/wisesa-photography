<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'jenis_payment',
        'nominal',
        'bukti_transfer',
        'status',
    ];

    // Status constants
    const STATUS_PENDING = 'Pending';
    const STATUS_TERKONFIRMASI = 'Terkonfirmasi';
    const STATUS_DITOLAK = 'Ditolak';

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
