<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FonteeWhatsAppService
{
    protected $token;
    protected $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->token = config('services.fontee.token');
    }

    /**
     * Send WhatsApp message using Fontee API
     *
     * @param string $phoneNumber Phone number with country code (e.g., 6281234567890)
     * @param string $message Message content
     * @return array
     */
    public function sendMessage($phoneNumber, $message)
    {
        try {
            // Clean phone number (remove +, spaces, dashes)
            $phoneNumber = $this->cleanPhoneNumber($phoneNumber);

            // Ensure phone number starts with country code
            if (!str_starts_with($phoneNumber, '62')) {
                // If it starts with 0, replace with 62
                if (str_starts_with($phoneNumber, '0')) {
                    $phoneNumber = '62' . substr($phoneNumber, 1);
                } else {
                    $phoneNumber = '62' . $phoneNumber;
                }
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->baseUrl}/send", [
                'target' => $phoneNumber,
                'message' => $message,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status']) {
                Log::info('Fontee WhatsApp message sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $result
                ]);

                return [
                    'success' => true,
                    'message' => 'Pesan WhatsApp berhasil dikirim',
                    'data' => $result
                ];
            } else {
                Log::error('Fontee WhatsApp message failed', [
                    'phone' => $phoneNumber,
                    'response' => $result
                ]);

                return [
                    'success' => false,
                    'message' => 'Gagal mengirim pesan WhatsApp: ' . ($result['message'] ?? 'Unknown error'),
                    'data' => $result
                ];
            }
        } catch (\Exception $e) {
            Log::error('Fontee WhatsApp service error', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Clean phone number format
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function cleanPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters except country code
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }

    /**
     * Format progress message for booking notification
     *
     * @param array $progressData
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatProgressMessage($progressData, $booking)
    {
        $messages = [];

        // Check what was updated
        foreach ($progressData as $key => $value) {
            if ($value === true || ($value !== null && $value !== '')) {
                switch ($key) {
                    case 'jadwal_foto':
                        $messages[] = "✅ Jadwal Foto sudah ditetapkan";
                        break;
                    case 'file_jpg_upload':
                        $messages[] = "✅ File JPG sudah diupload";
                        if (!empty($progressData['file_jpg_link'])) {
                            $messages[] = "📎 Link: " . $progressData['file_jpg_link'];
                        }
                        break;
                    case 'selected_photos':
                        $messages[] = "✅ Selected Photos sudah dipilih";
                        if (!empty($progressData['selected_photos_link'])) {
                            $messages[] = "📎 Link: " . $progressData['selected_photos_link'];
                        }
                        break;
                    case 'file_raw_upload':
                        $messages[] = "✅ File RAW sudah diupload";
                        break;
                    case 'editing_foto':
                        $messages[] = "✅ Editing foto sedang diproses";
                        break;
                    case 'foto_edited_upload':
                        $messages[] = "✅ Foto edited sudah diupload";
                        break;
                }
            }
        }

        if (empty($messages)) {
            return "";
        }

        // Get booking date in proper format
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "🎉 *Update Progress Booking*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n\n";
        $message .= "*Progress Update:*\n";
        $message .= implode("\n", $messages);
        $message .= "\n\n_*CV Wisesa Photography*_";

        return $message;
    }

    /**
     * Format status update message for booking notification
     *
     * @param string $status
     * @param string|null $catatan
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatStatusMessage($status, $catatan, $booking)
    {
        // Get booking date in proper format
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "📢 *Update Status Booking*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n\n";

        // Status badge
        $statusLabels = [
            'Pending' => '⏳ Pending - Menunggu konfirmasi',
            'Diterima' => '✅ Diterima - Booking dikonfirmasi',
            'Diproses' => '🔄 Diproses - Sedang dikerjakan',
            'Selesai' => '🎉 Selesai - Order telah selesai',
            'Ditolak' => '❌ Ditolak - Booking ditolak',
            'Dibatalkan' => '🚫 Dibatalkan - Booking dibatalkan',
        ];

        $message .= "*Status:* " . ($statusLabels[$status] ?? $status) . "\n\n";

        // Catatan jika ada
        if (!empty($catatan)) {
            $message .= "*Catatan:*\n" . $catatan . "\n\n";
        }
        if ($status === 'Diterima') {
            $message .= "_* Tolong Segera Lakukan Pembayaran Di Halaman Booking 😍 *_ \n\n";
        }
        $message .= "_*CV Wisesa Photography*_";

        return $message;
    }

    /**
     * Format selected photos message from user to admin
     *
     * @param string $selectedPhotosLink
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatSelectedPhotosFromUser($selectedPhotosLink, $booking)
    {
        // Get booking date in proper format
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "📸 *Informasi Foto Yang Terpilih Dari Customer*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n";
        $message .= "📱 Telepon: " . $booking->telephone . "\n\n";
        $message .= "*Selected Photos Link:*\n" . $selectedPhotosLink . "\n\n";
        $message .= "_*CV Wisesa Photography*_";

        return $message;
    }

    /**
     * Format confirmation message to user after submitting selected photos
     *
     * @param string $selectedPhotosLink
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatSelectedPhotosConfirmation($selectedPhotosLink, $booking)
    {
        // Get booking date in proper format
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "✅ *Selected Photos Berhasil Diterima*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n\n";
        $message .= "Selected photos Anda sudah berhasil diterima. Tim kami akan memproses foto yang terpilih.\n\n";
        $message .= "*Link yang dikirim:*\n" . $selectedPhotosLink . "\n\n";
        $message .= "Terima kasih atas kepercayaan Anda menggunakan layanan CV Wisesa Photography 🙏\n\n";
        $message .= "_*CV Wisesa Photography*_";

        return $message;
    }
}
