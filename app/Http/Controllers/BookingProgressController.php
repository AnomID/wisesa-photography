<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingProgress;
use App\Http\Requests\UpdateBookingProgressRequest;
use Illuminate\Http\Request;

class BookingProgressController extends Controller
{
    /**
     * Show progress form (untuk admin)
     */
    public function edit($bookingId)
    {
        $booking = Booking::with('progress')->findOrFail($bookingId);

        // Pastikan booking status Diproses
        if ($booking->status !== 'Diproses') {
            return redirect()->route('admin.booking.show', $bookingId)
                ->with('error', 'Progress hanya bisa diupdate untuk booking dengan status Diproses.');
        }

        return view('admin.booking.progress', compact('booking'));
    }

    /**
     * Update progress
     */
    public function update(UpdateBookingProgressRequest $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $progress = $booking->progress;

        if (!$progress) {
            return redirect()->route('admin.booking.show', $bookingId)
                ->with('error', 'Progress belum dibuat.');
        }

        // Update dengan timestamp otomatis jika checklist dicentang
        $data = [];

        if ($request->has('jadwal_foto')) {
            $data['jadwal_foto'] = $request->jadwal_foto;
            if ($request->jadwal_foto) {
                $data['jadwal_foto_at'] = now();
            }
        }

        if ($request->has('file_jpg_upload')) {
            $data['file_jpg_upload'] = $request->file_jpg_upload;
            $data['file_jpg_link'] = $request->file_jpg_link;
            if ($request->file_jpg_upload) {
                $data['file_jpg_upload_at'] = now();
            }
        }

        if ($request->has('selected_photos')) {
            $data['selected_photos'] = $request->selected_photos;
            $data['selected_photos_link'] = $request->selected_photos_link;
            if ($request->selected_photos) {
                $data['selected_photos_at'] = now();
            }
        }

        if ($request->has('file_raw_upload')) {
            $data['file_raw_upload'] = $request->file_raw_upload;
            if ($request->file_raw_upload) {
                $data['file_raw_upload_at'] = now();
            }
        }

        if ($request->has('editing_foto')) {
            $data['editing_foto'] = $request->editing_foto;
            if ($request->editing_foto) {
                $data['editing_foto_at'] = now();
            }
        }

        if ($request->has('foto_edited_upload')) {
            $data['foto_edited_upload'] = $request->foto_edited_upload;
            if ($request->foto_edited_upload) {
                $data['foto_edited_upload_at'] = now();
            }
        }

        $progress->update($data);

        // Cek apakah semua progress selesai
        if (
            $progress->fresh()->jadwal_foto &&
            $progress->file_jpg_upload &&
            $progress->selected_photos &&
            $progress->file_raw_upload &&
            $progress->editing_foto &&
            $progress->foto_edited_upload
        ) {

            return redirect()->route('admin.booking.show', $bookingId)
                ->with('success', 'Progress berhasil diupdate! Semua tahapan selesai, Anda dapat mengubah status booking menjadi Selesai.');
        }

        return redirect()->route('admin.booking.show', $bookingId)
            ->with('success', 'Progress berhasil diupdate!');
    }

    /**
     * Quick update single progress item (untuk AJAX)
     */
    public function quickUpdate(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $progress = $booking->progress;

        if (!$progress) {
            return response()->json(['success' => false, 'message' => 'Progress tidak ditemukan'], 404);
        }

        $field = $request->field;
        $value = $request->value;
        $link = $request->link ?? null;

        $data = [$field => $value];

        // Set timestamp jika dicentang
        if ($value) {
            $data[$field . '_at'] = now();
        }

        // Set link jika ada
        if ($link && in_array($field, ['file_jpg_upload', 'selected_photos'])) {
            $data[$field . '_link'] = $link;
        }

        $progress->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Progress berhasil diupdate',
            'timestamp' => $progress->{$field . '_at'} ? $progress->{$field . '_at'}->format('d M Y H:i') : null
        ]);
    }
}
