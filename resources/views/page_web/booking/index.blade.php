@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        /* Booking Page Styles - Konsisten dengan profil.blade.php */
        .booking-section {
            padding: 80px 0;
            background-color: #f7f7f7;
        }

        .booking-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 19px;
        }

        @media (min-width: 1400px) {
            .booking-container {
                max-width: 1920px;
                padding: 0 80px;
            }
        }

        .booking-form-container {
            background: #ffffff;
            padding: 60px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .booking-form-container {
                padding: 40px 30px;
            }
        }

        /* Header Styles */
        .booking-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .booking-title {
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: #000000;
            margin-bottom: 20px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 15px 30px;
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .btn-primary-custom {
            background-color: #FFC60A;
            color: #000000;
        }

        .btn-primary-custom:hover {
            background-color: #000000;
            color: #ffffff;
        }

        .btn-secondary-custom {
            background-color: transparent;
            color: #000000;
            border: 2px solid #000000;
        }

        .btn-secondary-custom:hover {
            background-color: #000000;
            color: #ffffff;
        }

        /* Order Cards */
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .order-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .order-card-header {
            padding: 20px 25px 15px;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id {
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: #000000;
            margin: 0;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 0;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-diterima {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-diproses {
            background-color: #cce5ff;
            color: #004085;
        }

        .order-card-body {
            padding: 25px;
        }

        .order-info {
            margin-bottom: 15px;
            font-family: "Neue Montreal", "Arial", sans-serif;
        }

        .order-info:last-child {
            margin-bottom: 0;
        }

        .order-info-label {
            font-size: 13px;
            font-weight: 600;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .order-info-value {
            font-size: 15px;
            color: #6c757d;
            line-height: 1.4;
        }

        .order-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 10px 20px;
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .btn-detail {
            background-color: #FFC60A;
            color: #000000;
        }

        .btn-detail:hover {
            background-color: #000000;
            color: #ffffff;
        }

        .btn-invoice {
            background-color: #20c997;
            color: #ffffff;
        }

        .btn-invoice:hover {
            background-color: #17a2b8;
        }

        .btn-notes {
            background-color: #dc3545;
            color: #ffffff;
        }

        .btn-notes:hover {
            background-color: #c82333;
        }

        .btn-update {
            background-color: #FFC60A;
            color: #000000;
        }

        .btn-update:hover {
            background-color: #000000;
            color: #ffffff;
        }

        .btn-payment {
            background-color: #fd7e14;
            color: #ffffff;
        }

        .btn-payment:hover {
            background-color: #e55a00;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: #ffffff;
            border: 1px solid #e9ecef;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #FFC60A;
            margin-bottom: 20px;
        }

        .empty-state-title {
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #000000;
            margin-bottom: 10px;
        }

        .empty-state-text {
            font-size: 15px;
            color: #6c757d;
            margin-bottom: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .booking-container {
                padding: 0 19px;
            }

            .orders-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .order-card-header {
                padding: 15px 20px 10px;
            }

            .order-card-body {
                padding: 20px;
            }

            .order-actions {
                flex-direction: column;
                gap: 15px;
            }

            .action-buttons {
                width: 100%;
                justify-content: center;
            }

            .header-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endsection
@section('content')
    <main>
        <section class="booking-section">
            <div class="booking-container">
                <div class="booking-form-container">
                    <!-- Header Section -->
                    <div class="booking-header">
                        <h1 class="booking-title">My Orders</h1>
                        <div class="header-actions">

                            <!-- Booking Button -->
                            <a href="{{ route('booking.create') }}" class="action-btn btn-primary-custom">
                                <i class="fas fa-plus"></i> Booking
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    @if ($bookings->count() > 0)
                        <div class="orders-grid">
                            @foreach ($bookings as $booking)
                                <div class="order-card">
                                    <!-- Order Header -->
                                    <div class="order-card-header">
                                        <h3 class="order-id">Order #{{ $booking->id }}</h3>
                                        <span class="status-badge status-{{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </div>

                                    <!-- Order Body -->
                                    <div class="order-card-body">
                                        <!-- Order Information -->
                                        <div class="order-info">
                                            <div class="order-info-label">Booking Date</div>
                                            <div class="order-info-value">
                                                {{ $booking->booking_date->format('d M Y') }},
                                                @if ($booking->booking_end_time)
                                                    {{ date('H:i', strtotime($booking->booking_time)) }} -
                                                    {{ date('H:i', strtotime($booking->booking_end_time)) }}
                                                @else
                                                    {{ date('H:i', strtotime($booking->booking_time)) }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="order-info">
                                            <div class="order-info-label">Services</div>
                                            <div class="order-info-value">
                                                {{ $booking->layanan->judul ?? '-' }}
                                                @if ($booking->subLayanan)
                                                    - {{ $booking->subLayanan->judul }}
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Payment Information (only for Diterima status) -->
                                        @if ($booking->status == 'Diterima' && $booking->payment)
                                            <div class="order-info">
                                                <div class="order-info-label">Status Payment</div>
                                                <div class="order-info-value">
                                                    @if ($booking->payment->status == 'pending')
                                                        <span class="text-warning">Menunggu Verifikasi</span>
                                                    @elseif($booking->payment->status == 'verified')
                                                        <span class="text-success">Lunas</span>
                                                    @else
                                                        <span class="text-danger">Kekurangan</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="order-info">
                                                <div class="order-info-label">Full Payment</div>
                                                <div class="order-info-value">Rp
                                                    {{ number_format($booking->biaya ?? 0, 0, ',', '.') }}</div>
                                            </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div class="order-actions">
                                            <div class="action-buttons">
                                                @if ($booking->status == 'Selesai')
                                                    <a href="#" class="btn-action btn-invoice">
                                                        <i class="fas fa-print"></i> Cetak Invoice
                                                    </a>
                                                @elseif($booking->status == 'Ditolak')
                                                    <a href="#" class="btn-action btn-notes">
                                                        <i class="fas fa-sticky-note"></i> Catatan
                                                    </a>
                                                @elseif ($booking->status == 'Diterima' && !$booking->payment)
                                                    <button type="button" class="btn-action btn-payment"
                                                        onclick="openPaymentModal()">
                                                        <i class="fas fa-credit-card"></i> Payment
                                                    </button>
                                                @elseif (
                                                    $booking->status != 'Selesai' &&
                                                        $booking->status != 'Ditolak' &&
                                                        $booking->status != 'Diproses' &&
                                                        $booking->status != 'Dibatalkan')
                                                    <button type="button" class="btn-action btn-cancel"
                                                        onclick="confirmCancel({{ $booking->id }})">
                                                        <i class="fas fa-times"></i> Cancel Order
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="action-buttons">
                                                @if ($booking->status == 'Ditolak')
                                                    <a href="{{ route('booking.create') }}" class="btn-action btn-update">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                @else
                                                    <a href="{{ route('booking.show', $booking->id) }}"
                                                        class="btn-action btn-detail">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3 class="empty-state-title">Belum ada booking</h3>
                            <p class="empty-state-text">Silakan buat booking pertama Anda!</p>
                            <a href="{{ route('booking.create') }}" class="action-btn btn-primary-custom">
                                <i class="fas fa-plus"></i> Buat Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
    @include('page_web.booking.modal.payment')

@endsection
