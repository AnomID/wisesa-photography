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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Booking</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tabel Data Booking</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tabel Data Booking</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Zero config table start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tabel Data Booking</h5>
                            <div>
                                <a href="{{ route('admin.booking.export') }}" class="btn btn-success me-2">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Layanan</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $e => $booking)
                                            <tr>
                                                <td>{{ $e + 1 }}</td>
                                                <td>{{ $booking->user->name ?? '-' }}</td>
                                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                                <td>
                                                    @if ($booking->booking_end_time)
                                                        {{ date('H:i', strtotime($booking->booking_time)) }} -
                                                        {{ date('H:i', strtotime($booking->booking_end_time)) }}
                                                    @else
                                                        {{ date('H:i', strtotime($booking->booking_time)) }}
                                                    @endif
                                                </td>
                                                <td>{{ $booking->layanan->judul ?? '-' }}</td>
                                                <td>{{ $booking->address ?? '-' }}</td>
                                                <td>
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
                                                    @else
                                                        <span
                                                            class="badge bg-light text-dark">{{ $booking->status ?? 'Unknown' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.booking.show', $booking->id) }}"
                                                        class="btn btn-sm btn-info">Detail</a>
                                                    <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('admin.booking.destroy', $booking->id) }}"
                                                        method="POST" style="display:inline;" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Layanan</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#simpletable').DataTable();
        });
    </script>
@endsection
