<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingProgress;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BookingProgressController extends Controller
{
    /**
     * Show the form for editing booking progress
     */
    public function edit($id)
    {
        $booking = Booking::with(['user', 'layanan', 'subLayanan', 'progress'])->findOrFail($id);

        return view('page_admin.booking.progress', compact('booking'));
    }

    /**
     * Update booking progress
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Diproses,Selesai,Ditolak',
            'catatan' => 'nullable|string|max:1000',
            'fotografer' => 'nullable|string|max:255',
            'biaya' => 'nullable|numeric|min:0',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'fotografer' => $request->fotografer,
            'biaya' => $request->biaya,
        ]);

        // Update atau create progress
        $progress = $booking->progress ?? new BookingProgress();
        $progress->booking_id = $booking->id;
        $progress->status = $request->status;
        $progress->catatan = $request->catatan;
        $progress->save();

        Alert::success('Berhasil', 'Progress booking berhasil diupdate!');
        return redirect()->route('admin.booking.show', $id);
    }

    /**
     * Quick update booking status
     */
    public function quickUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Diproses,Selesai,Ditolak',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        // Update progress
        $progress = $booking->progress ?? new BookingProgress();
        $progress->booking_id = $booking->id;
        $progress->status = $request->status;
        $progress->save();

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diupdate!'
        ]);
    }
}
