<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingProgress;
use App\Models\Layanan;
use App\Models\SubLayanan;
use App\Models\Payment;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingAdminRequest;
use App\Services\FonteeWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings (untuk user)
     */
    public function index()
    {
        $bookings = Booking::with(['layanan', 'subLayanan', 'payment', 'progress'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('page_web.booking.index', compact('bookings'));
    }

    /**
     * Display a listing of all bookings (untuk admin)
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'layanan', 'subLayanan', 'payment', 'progress'])
            ->latest()
            ->paginate(20);

        return view('page_admin.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $user = auth()->user();
        $layanans = Layanan::all();

        return view('page_web.booking.create', compact('user', 'layanans'));
    }

    /**
     * Store a newly created booking
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'telephone' => $request->telephone,
            'area' => $request->area,
            'instagram' => $request->instagram,
            'address' => $request->address,
            'layanan_id' => $request->layanan_id,
            'sub_layanan_id' => $request->sub_layanan_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'booking_end_time' => $request->booking_end_time,
            'universitas' => $request->universitas,
            'lokasi_photo' => $request->lokasi_photo,
            'catatan' => $request->catatan,
            'status' => 'Pending',
        ]);

        return redirect()->route('booking.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }

    /**
     * Display the specified booking
     */
    public function show($id)
    {
        $booking = Booking::with(['layanan', 'subLayanan', 'payment', 'progress'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('page_web.booking.show', compact('booking'));
    }

    /**
     * Show the form for editing booking (untuk admin)
     */
    public function edit($id)
    {
        $booking = Booking::with(['user', 'layanan', 'subLayanan'])->findOrFail($id);

        return view('page_admin.booking.edit', compact('booking'));
    }

    /**
     * Update booking (untuk admin)
     */
    public function update(UpdateBookingAdminRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update($request->only([
            'nama',
            'telephone',
            'address',
            'booking_date',
            'layanan_id',
            'sub_layanan_id',
            'area',
            'fotografer',
            'instagram',
            'booking_time',
            'booking_end_time',
            'biaya',
            'lokasi_photo',
            'universitas',
            'status'
        ]));

        return redirect()->route('admin.booking.show', $id)
            ->with('success', 'Booking berhasil diupdate!');
    }

    /**
     * Update booking status via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Pending,Diterima,Diproses,Selesai,Ditolak,Dibatalkan',
                'catatan' => 'nullable|string|max:1000'
            ]);

            $booking = Booking::with('layanan')->findOrFail($id);
            $oldStatus = $booking->status;

            $updateData = [
                'status' => $request->status,
                'updated_at' => now()
            ];

            if ($request->filled('catatan')) {
                $catatanData = $booking->catatan;

                if (!is_array($catatanData)) {
                    $catatanData = [];
                }

                $catatanBaru = [
                    'tanggal' => now()->format('d/m/Y'),
                    'waktu' => now()->format('H:i'),
                    'status' => $request->status,
                    'isi' => $request->catatan
                ];

                $catatanData[] = $catatanBaru;
                $updateData['catatan'] = json_encode($catatanData);
            }

            DB::table('bookings')
                ->where('id', $booking->id)
                ->update($updateData);

            if ($request->status === 'Diproses' && !$booking->progress) {
                BookingProgress::create(['booking_id' => $booking->id]);
            }

            if ($oldStatus !== $request->status) {
                try {
                    $fonteeService = new FonteeWhatsAppService();
                    $catatanText = $request->filled('catatan') ? $request->catatan : null;
                    $message = $fonteeService->formatStatusMessage($request->status, $catatanText, $booking);
                    $fonteeService->sendMessage($booking->telephone, $message);
                } catch (\Exception $e) {
                    logger()->error('Failed to send WhatsApp status notification: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Status booking berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display booking detail (untuk admin)
     */
    public function adminShow($id)
    {
        $booking = Booking::with(['user', 'layanan', 'subLayanan', 'payment', 'progress'])
            ->findOrFail($id);

        return view('page_admin.booking.show', compact('booking'));
    }

    /**
     * Get sub layanan by layanan id (untuk AJAX)
     */
    public function getSubLayanan($layananId)
    {
        $subLayanans = SubLayanan::where('layanan_id', $layananId)->get();

        return response()->json($subLayanans);
    }

    /**
     * Delete booking (soft delete)
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('page_admin.booking.index')
            ->with('success', 'Booking berhasil dihapus!');
    }

    /**
     * Show payment form
     */
    public function payment($id)
    {
        $booking = Booking::with(['layanan', 'subLayanan'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('page_web.booking.payment', compact('booking'));
    }

    /**
     * Store payment data
     */
    public function storePayment(Request $request, $id)
    {
        $request->validate([
            'jenis_payment' => 'required|in:DP,Fullpayment',
            'nominal' => 'required|numeric|min:1',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/payments', $filename);
        }

        Payment::create([
            'booking_id' => $booking->id,
            'jenis_payment' => $request->jenis_payment,
            'nominal' => $request->nominal,
            'bukti_transfer' => $filename,
            'status' => 'Pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment berhasil disimpan!'
        ]);
    }

    /**
     * Cancel booking order
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if (in_array($booking->status, [Booking::STATUS_DIPROSES, Booking::STATUS_SELESAI])) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak dapat dibatalkan karena status sudah ' . $booking->status
            ], 400);
        }

        $booking->update([
            'status' => Booking::STATUS_DIBATALKAN,
            'catatan' => $booking->catatan . "\n[Dibatalkan oleh user pada " . now()->format('d/m/Y H:i') . "]"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibatalkan!'
        ]);
    }

    /**
     * Export booking data to Excel
     */
    public function export()
    {
        return Excel::download(new BookingExport, 'booking_data_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Update booking progress
     */
    public function updateProgress(Request $request, $id)
    {
        $booking = Booking::with(['layanan', 'progress'])->findOrFail($id);

        $progress = $booking->progress ?? BookingProgress::create(['booking_id' => $booking->id]);
        $oldProgress = $progress->toArray();

        $progress->update([
            'jadwal_foto' => $request->has('jadwal_foto'),
            'jadwal_foto_at' => $request->has('jadwal_foto') ? now() : null,
            'file_jpg_upload' => $request->has('file_jpg_upload'),
            'file_jpg_upload_at' => $request->has('file_jpg_upload') ? now() : null,
            'selected_photos' => $request->has('selected_photos'),
            'selected_photos_at' => $request->has('selected_photos') ? now() : null,
            'file_raw_upload' => $request->has('file_raw_upload'),
            'file_raw_upload_at' => $request->has('file_raw_upload') ? now() : null,
            'editing_foto' => $request->has('editing_foto'),
            'editing_foto_at' => $request->has('editing_foto') ? now() : null,
            'foto_edited_upload' => $request->has('foto_edited_upload'),
            'foto_edited_upload_at' => $request->has('foto_edited_upload') ? now() : null,
            'file_jpg_link' => $request->google_drive_link,
        ]);

        $progress->refresh();

        $progressData = [];
        $changesDetected = false;

        $fields = [
            'jadwal_foto',
            'file_jpg_upload',
            'selected_photos',
            'file_raw_upload',
            'editing_foto',
            'foto_edited_upload'
        ];

        foreach ($fields as $field) {
            $newValue = $progress->$field;
            $oldValue = $oldProgress[$field] ?? false;

            if ($newValue != $oldValue) {
                $changesDetected = true;
                $progressData[$field] = $newValue;
            }
        }

        if ($request->filled('google_drive_link')) {
            $progressData['file_jpg_link'] = $request->google_drive_link;
        }

        if ($request->filled('selected_photos_link')) {
            $progressData['selected_photos_link'] = $request->selected_photos_link;
        }

        if ($changesDetected) {
            try {
                $fonteeService = new FonteeWhatsAppService();
                $message = $fonteeService->formatProgressMessage($progressData, $booking);

                if (!empty($message)) {
                    $fonteeService->sendMessage($booking->telephone, $message);
                }
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.booking.show', $id)
            ->with('success', 'Progress booking berhasil diupdate!');
    }

    /**
     * Store selected photos link for user
     */
    public function storeSelectedPhotos(Request $request, $id)
    {
        $request->validate([
            'selected_photos_link' => 'required|string|max:2000'
        ]);

        try {
            $booking = Booking::with(['layanan', 'progress'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

            $progress = $booking->progress ?? BookingProgress::create(['booking_id' => $booking->id]);

            $progress->update([
                'selected_photos_link' => $request->selected_photos_link,
                'selected_photos' => true,
                'selected_photos_at' => now()
            ]);

            try {
                $fonteeService = new FonteeWhatsAppService();
                $adminMessage = $fonteeService->formatSelectedPhotosFromUser($request->selected_photos_link, $booking);
                $adminPhone = config('services.fontee.admin_phone', '6287875633258');
                $fonteeService->sendMessage($adminPhone, $adminMessage);
                $userMessage = $fonteeService->formatSelectedPhotosConfirmation($request->selected_photos_link, $booking);
                $fonteeService->sendMessage($booking->telephone, $userMessage);
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification for selected photos: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Selected photos berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
