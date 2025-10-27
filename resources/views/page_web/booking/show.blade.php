@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-dibatalkan {
            background-color: #dc3545 !important;
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <main>
        <section class="order-detail-section">
            <div class="order-detail-container">
                <div class="order-detail-form-container">
                    <!-- Header Section -->
                    <div class="order-detail-header">
                        <h1 class="order-detail-title">Order Detail</h1>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif


                    <div class="order-detail-grid">
                        <div
                            class="order-detail-card card-col-6 card-height-auto card-order-1 card-shadow-md card-align-start card-hover-lift card-fade-in card-responsive card-rounded-md card-clickable">
                            <div class="card-header-custom">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Status Booking ID{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }} | Status
                                </h3>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $booking->status)) }}">
                                    {{ $booking->status }}
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <div class="info-label">Nama Pemesan</div>
                                    <div class="info-value">{{ $booking->nama }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Alamat</div>
                                    <div class="info-value">{{ $booking->address }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Telepon</div>
                                    <div class="info-value">{{ $booking->telephone }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Instagram</div>
                                    <div class="info-value">{{ $booking->instagram ?: '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Tanggal Booking</div>
                                    <div class="info-value">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $booking->booking_date->format('l d F Y') }}
                                        <i class="fas fa-clock ms-2 me-1"></i>
                                        @if ($booking->booking_end_time)
                                            {{ date('H.i', strtotime($booking->booking_time)) }} -
                                            {{ date('H.i', strtotime($booking->booking_end_time)) }}
                                        @else
                                            {{ date('H.i', strtotime($booking->booking_time)) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="order-detail-card card-col-6 card-height-auto card-order-2 card-shadow-md card-align-start card-hover-lift card-fade-in card-responsive card-rounded-md card-clickable">
                            <div class="card-header-custom">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Informasi Booking
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <div class="info-label">Paket Foto</div>
                                    <div class="info-value">{{ $booking->layanan->judul ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Area</div>
                                    <div class="info-value">{{ $booking->area }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Lokasi</div>
                                    <div class="info-value">{{ $booking->lokasi_photo }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Biaya</div>
                                    <div class="info-value">Rp
                                        {{ number_format($booking->biaya ?? 0, 0, ',', '.') }},-</div>
                                </div>
                                @if ($booking->fotografer)
                                    <div class="info-row">
                                        <div class="info-label">Fotografer</div>
                                        <div class="info-value">{{ $booking->fotografer }}</div>
                                    </div>
                                @endif

                                <div class="info-row">
                                    <div class="info-label">Detail Paket</div>
                                    <div class="info-value">
                                        {{ $booking->layanan->deskripsi ?? 'Paket foto ' . strtolower($booking->layanan->judul ?? '') . ' sederhana dengan 2 fotografer dst..' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($booking->status == 'Diproses')
                            <div
                                class="order-detail-card card-col-6 card-height-auto card-order-3 card-shadow-md card-align-start card-hover-lift card-fade-in card-responsive card-rounded-md card-clickable">
                                <div class="card-header-custom">
                                    <h3 class="card-title">
                                        <i class="fas fa-sync-alt"></i>
                                        Update Progress Booking
                                    </h3>
                                </div>
                                <div class="card-body">
                                    @if ($booking->progress)
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox"
                                                {{ $booking->progress->jadwal_foto ? 'checked' : '' }} disabled>
                                            <span class="progress-text">Jadwal Foto</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox"
                                                {{ $booking->progress->file_jpg_upload ? 'checked' : '' }} disabled>
                                            <span class="progress-text">File JPG Upload</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox"
                                                {{ $booking->progress->selected_photos ? 'checked' : '' }} disabled>
                                            <span class="progress-text">
                                                Selected Photos
                                                <a href="javascript:void(0)" onclick="openSelectedPhotosModal()"
                                                    style="margin-left: 5px; color: inherit; text-decoration: none; cursor: pointer;"
                                                    onmouseover="this.style.color='#ffc60a'"
                                                    onmouseout="this.style.color='inherit'">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox"
                                                {{ $booking->progress->file_raw_upload ? 'checked' : '' }} disabled>
                                            <span class="progress-text">File RAW Upload</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox"
                                                {{ $booking->progress->editing_foto ? 'checked' : '' }} disabled>
                                            <span class="progress-text">Editing Foto</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox"
                                                {{ $booking->progress->foto_edited_upload ? 'checked' : '' }} disabled>
                                            <span class="progress-text">Foto Edited Upload</span>
                                        </div>
                                    @else
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox" disabled>
                                            <span class="progress-text">Jadwal Foto</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox" disabled>
                                            <span class="progress-text">File JPG Upload</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox" disabled>
                                            <span class="progress-text">
                                                Selected Photos
                                                <a href="javascript:void(0)" onclick="openSelectedPhotosModal()"
                                                    style="margin-left: 5px; color: inherit; text-decoration: none; cursor: pointer;"
                                                    onmouseover="this.style.color='#ffc60a'"
                                                    onmouseout="this.style.color='inherit'">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox" disabled>
                                            <span class="progress-text">File RAW Upload</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox" disabled>
                                            <span class="progress-text">Editing Foto</span>
                                        </div>
                                        <div class="progress-item">
                                            <input type="checkbox" class="progress-checkbox" disabled>
                                            <span class="progress-text">Foto Edited Upload</span>
                                        </div>
                                    @endif

                                    <div class="google-drive-section">
                                        <div class="google-drive-label">Link Google Drive</div>
                                        @if ($booking->progress && $booking->progress->file_jpg_link)
                                            <div class="google-drive-link-container"
                                                style="padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; overflow-wrap: break-word;">
                                                <a href="{{ $booking->progress->file_jpg_link }}" target="_blank"
                                                    style="color: #007bff; text-decoration: underline; word-break: break-all; display: block;">
                                                    {{ $booking->progress->file_jpg_link }}
                                                </a>
                                            </div>
                                        @else
                                            <input type="text" class="google-drive-input"
                                                placeholder="Masukkan link Google Drive..." value="" readonly>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="order-detail-card card-col-6 card-height-auto card-order-3 card-shadow-md card-align-start card-hover-lift card-fade-in card-responsive card-rounded-md card-clickable">
                                <div class="card-header-custom">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle"></i>
                                        Informasi Booking
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div style="text-align: center; padding: 40px 20px;">
                                        <div style="font-size: 64px; color: #ffc60a; margin-bottom: 20px;">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">
                                            Menunggu Konfirmasi Admin
                                        </h4>
                                        <p style="color: #666; line-height: 1.6; max-width: 400px; margin: 0 auto;">
                                            Booking Anda sedang menunggu konfirmasi dari admin.
                                            Anda akan mendapatkan notifikasi Whatsapp setelah booking dikonfirmasi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div
                            class="order-detail-card card-col-6 card-height-auto card-order-4 card-shadow-md card-align-start card-hover-lift card-fade-in card-responsive card-rounded-md card-clickable">
                            <div class="card-header-custom">
                                <h3 class="card-title">
                                    <i class="fas fa-mouse-pointer"></i>
                                    Tindakan
                                </h3>
                                @if ($booking->payment)
                                    <span class="status-badge"
                                        style="background-color: #d4edda; color: #155724;">Dibayar</span>
                                @else
                                    <span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Belum
                                        Dibayar</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="action-buttons">
                                    @if ($booking->status == 'Diterima' && !$booking->payment)
                                        <button type="button" class="btn-action btn-payment"
                                            onclick="openPaymentModal()">
                                            <i class="fas fa-credit-card"></i> Payment
                                        </button>
                                    @endif

                                    @if (
                                        $booking->status != 'Selesai' &&
                                            $booking->status != 'Ditolak' &&
                                            $booking->status != 'Diproses' &&
                                            $booking->status != 'Dibatalkan')
                                        <button type="button" class="btn-action btn-cancel"
                                            onclick="confirmCancel({{ $booking->id }})">
                                            <i class="fas fa-times"></i> Cancel Order
                                        </button>
                                    @endif

                                    <a href="{{ route('booking.index') }}" class="btn-action btn-back">
                                        <i class="fas fa-arrow-left"></i> Back to Orders
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function confirmCancel(bookingId) {
            Swal.fire({
                title: 'Konfirmasi Pembatalan',
                text: 'Apakah Anda yakin ingin membatalkan order ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang membatalkan order...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send AJAX request to cancel booking
                    fetch(`/booking/${bookingId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Reload page to show updated status
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message,
                                    confirmButtonColor: '#dc3545',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat membatalkan order. Silakan coba lagi.',
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        function openSelectedPhotosModal() {
            // Check if modal exists in the DOM
            const modal = document.getElementById('selectedPhotosModal');
            const footer = document.getElementById('selectedPhotosFooter');

            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';

                // Update clickable links display
                setTimeout(function() {
                    if (typeof updateSelectedPhotosDisplay === 'function') {
                        updateSelectedPhotosDisplay();
                    }
                }, 100);

                // Check if selected_photos is already true, then hide buttons
                @if ($booking->progress && $booking->progress->selected_photos)
                    if (footer) {
                        footer.style.display = 'none';
                    }
                @else
                    if (footer) {
                        footer.style.display = 'flex';
                    }
                @endif
            }
        }
    </script>

    <!-- Include Payment Modal -->
    @include('page_web.booking.modal.payment')

    <!-- Include Selected Photos Modal -->
    @include('page_web.booking.modal.selected_photos_modal')
@endsection
