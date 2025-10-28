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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Galeri</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tabel Data Galeri</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tabel Data Galeri</h2>
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
                            <h5 class="mb-0">Tabel Data Galeri</h5>
                            <a href="{{ route('galeri.create') }}" class="btn btn-primary">Tambah Data Galeri</a>
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
                                            <th>Gambar</th>
                                            <th>Judul Galeri</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah Item Gallery</th>
                                            <th>Layanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galeris as $e => $galeri)
                                            <tr>
                                                <td>{{ $e + 1 }}</td>
                                                <td>
                                                    @if ($galeri->gambar)
                                                        <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}"
                                                            alt="Gambar {{ $galeri->keterangan }}" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-2">
                                                            <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $galeri->judul_galeri ?? '-' }}</td>
                                                <td>{{ Str::limit(strip_tags($galeri->keterangan), 50) }}</td>
                                                <td>
                                                    @if ($galeri->list_gallery && count($galeri->list_gallery) > 0)
                                                        <span class="badge bg-success">{{ count($galeri->list_gallery) }}
                                                            Item</span>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Ada</span>
                                                    @endif
                                                </td>
                                                <td>{{ $galeri->layanan->judul ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('galeri.show', $galeri->id) }}"
                                                        class="btn btn-sm btn-info">Detail</a>
                                                    <a href="{{ route('galeri.edit', $galeri->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('galeri.destroy', $galeri->id) }}"
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
                                            <th>Gambar</th>
                                            <th>Judul Galeri</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah Item Gallery</th>
                                            <th>Layanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero config table end -->
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
