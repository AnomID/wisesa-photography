<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Booking::with(['user', 'layanan'])
            ->latest()
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Tanggal',
            'Waktu',
            'Layanan',
            'Alamat',
            'Status',
            'Telepon',
            'Email',
            'Instagram',
            'Universitas',
            'Lokasi Photo',
            'Catatan',
            'Dibuat Pada'
        ];
    }

    /**
     * @param Booking $booking
     * @return array
     */
    public function map($booking): array
    {
        static $counter = 0;
        $counter++;

        $startTime = $booking->booking_time ? date('H:i', strtotime($booking->booking_time)) : '-';
        $endTime = $booking->booking_end_time ? date('H:i', strtotime($booking->booking_end_time)) : '-';
        $timeRange = ($startTime !== '-' && $endTime !== '-') ? $startTime . ' - ' . $endTime : $startTime;

        return [
            $counter,
            $booking->user->name ?? '-',
            $booking->booking_date ? $booking->booking_date->format('d M Y') : '-',
            $timeRange,
            $booking->layanan->judul ?? '-',
            $booking->address ?? '-',
            $booking->status ?? '-',
            $booking->telephone ?? '-',
            $booking->user->email ?? '-',
            $booking->instagram ?? '-',
            $booking->universitas ?? '-',
            $booking->lokasi_photo ?? '-',
            $booking->catatan ?? '-',
            $booking->created_at ? $booking->created_at->format('d M Y H:i') : '-'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
