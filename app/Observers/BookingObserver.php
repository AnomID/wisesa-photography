<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\BookingProgress;

class BookingObserver
{
    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        if ($booking->isDirty('status') && $booking->status === 'Diproses') {
            BookingProgress::firstOrCreate([
                'booking_id' => $booking->id
            ]);
        }

        if ($booking->isDirty('status')) {
            $this->sendStatusNotification($booking);
        }
    }

    private function sendStatusNotification(Booking $booking): void
    {
        $statusMessages = [
            'Ditolak' => "Maaf, booking Anda telah ditolak.\nCatatan: {$booking->catatan}",
            'Diterima' => "Booking Anda telah diterima! Silakan lakukan pembayaran.\nFotografer: {$booking->fotografer}\nBiaya: Rp {$booking->biaya}",
            'Diproses' => "Booking Anda sedang diproses. Anda dapat melihat progress di halaman booking.",
            'Selesai' => "Booking Anda telah selesai. Terima kasih!",
        ];

        if (!isset($statusMessages[$booking->status])) {
            return;
        }

        $message = $statusMessages[$booking->status];
    }
}
