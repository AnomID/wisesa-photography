@extends('template_admin.layout')

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard-asisten">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.booking.index') }}">Booking</a></li>
                                <li class="breadcrumb-item" aria-current="page">Detail Booking
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Detail Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Card 1: Status Booking -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Status Booking ID{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }} |
                                        @if ($booking->status == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status == 'Ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($booking->status == 'Diterima')
                                            <span class="badge bg-info">Diterima</span>
                                        @elseif($booking->status == 'Diproses')
                                            <span class="badge bg-primary">Diproses</span>
                                        @elseif($booking->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($booking->status == 'Dibatalkan')
                                            <span class="badge bg-secondary">Dibatalkan</span>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Nama Pemesan:</strong> {{ $booking->nama }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Alamat:</strong> {{ $booking->area }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Telepon:</strong> {{ $booking->telephone }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Instagram:</strong> {{ $booking->instagram ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Tanggal Booking:</strong>
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
                                    <div class="mb-2">
                                        <strong>Catatan:</strong>
                                        @if ($booking->catatan && is_array($booking->catatan) && count($booking->catatan) > 0)
                                            <a href="#" class="ms-2" data-bs-toggle="modal"
                                                data-bs-target="#riwayatCatatanModal"
                                                title="Lihat Riwayat Catatan ({{ count($booking->catatan) }})">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        @else
                                            <span class="text-muted ms-2">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Informasi Booking -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Informasi Booking
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Paket Foto:</strong> {{ $booking->layanan->judul ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Area:</strong> {{ $booking->area }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Lokasi:</strong> {{ $booking->lokasi_photo }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Biaya:</strong> Rp {{ $booking->biaya ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Fotografer:</strong> {{ $booking->fotografer ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Detail Paket:</strong> {{ $booking->layanan->deskripsi ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Update Progress Booking -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        Update Progress Booking
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if ($booking->progress)
                                        <form action="{{ route('admin.booking.progress.update.new', $booking->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="jadwal_foto"
                                                    value="1" id="jadwal_foto"
                                                    {{ $booking->progress->jadwal_foto ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jadwal_foto">
                                                    Jadwal Foto
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="file_jpg_upload"
                                                    value="1" id="file_jpg_upload"
                                                    {{ $booking->progress->file_jpg_upload ? 'checked' : '' }}>
                                                <label class="form-check-label" for="file_jpg_upload">
                                                    File JPG Upload
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="selected_photos"
                                                    value="1" id="selected_photos"
                                                    {{ $booking->progress->selected_photos ? 'checked' : '' }}>
                                                <label class="form-check-label" for="selected_photos">
                                                    Selected Photos
                                                    @if ($booking->progress->selected_photos_link)
                                                        <a href="#" class="ms-2" data-bs-toggle="modal"
                                                            data-bs-target="#selectedPhotosModal"
                                                            title="Lihat Selected Photos">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="file_raw_upload"
                                                    value="1" id="file_raw_upload"
                                                    {{ $booking->progress->file_raw_upload ? 'checked' : '' }}>
                                                <label class="form-check-label" for="file_raw_upload">
                                                    File RAW Upload
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="editing_foto"
                                                    value="1" id="editing_foto"
                                                    {{ $booking->progress->editing_foto ? 'checked' : '' }}>
                                                <label class="form-check-label" for="editing_foto">
                                                    Editing Foto
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="foto_edited_upload"
                                                    value="1" id="foto_edited_upload"
                                                    {{ $booking->progress->foto_edited_upload ? 'checked' : '' }}>
                                                <label class="form-check-label" for="foto_edited_upload">
                                                    Foto Edited Upload
                                                </label>
                                            </div>

                                            <div class="mb-3">
                                                <label for="google_drive_link" class="form-label">Link Google
                                                    Drive</label>
                                                <input type="url" class="form-control" id="google_drive_link"
                                                    name="google_drive_link"
                                                    value="{{ $booking->progress->file_jpg_link ?? '' }}"
                                                    placeholder="Masukkan link Google Drive">
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Update Progress
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-info">
                                            Progress akan otomatis dibuat saat status booking diubah ke "Diproses"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Tindakan -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-mouse-pointer me-2"></i>
                                        Tindakan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateStatusModal" data-booking-id="{{ $booking->id }}">
                                            <i class="fas fa-edit"></i> Update Status
                                        </button>

                                        <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit Pesanan
                                        </a>

                                        @if ($booking->payment)
                                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#paymentModal" data-booking-id="{{ $booking->id }}">
                                                <i class="fas fa-check"></i> Lihat Pembayaran
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary" disabled>
                                                <i class="fas fa-times"></i> Belum Ada Pembayaran
                                            </button>
                                        @endif

                                        <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger w-100"
                                                onclick="return confirm('Yakin ingin menghapus pesanan?')">
                                                <i class="fas fa-trash"></i> Hapus Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include Update Status Modal -->
    @include('page_admin.booking.modal.update_status')

    <!-- Include Riwayat Catatan Modal -->
    @include('page_admin.booking.modal.riwayat_catatan')

    <!-- Include Selected Photos Modal -->
    @include('page_admin.booking.modal.selected_photos')

    <!-- Include Payment Modal -->
    @include('page_admin.booking.modal.payment')
@endsection

@section('script')
    <!-- Ensure SweetAlert2 is loaded -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endsection
