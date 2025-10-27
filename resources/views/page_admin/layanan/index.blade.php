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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Layanan</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tabel Data Layanan</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tabel Data Layanan</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tabel Data Layanan</h5>
                            <a href="{{ route('layanan.create') }}" class="btn btn-primary">Tambah Layanan</a>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Price List</th>
                                            <th>Galeri</th>
                                            <th>Sub Layanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($layanans as $index => $layanan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($layanan->gambar)
                                                        <img src="{{ asset('storage/layanan/' . $layanan->gambar) }}"
                                                            alt="Gambar {{ $layanan->judul }}" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-2 text-center"><i class="bx bx-image"
                                                                style="font-size: 2rem;"></i></div>
                                                    @endif
                                                </td>
                                                <td>{{ $layanan->judul }}</td>
                                                <td>{!! Str::limit($layanan->deskripsi, 100) !!}</td>
                                                <td>
                                                    @if ($layanan->price_list_pdf)
                                                        <a href="{{ asset('upload/layanan/pdf/' . $layanan->price_list_pdf) }}"
                                                            target="_blank"
                                                            class="badge bg-success text-white text-decoration-none">
                                                            <i class="bx bx-file-pdf"></i> Ada PDF
                                                        </a>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Ada</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $layanan->galeris_count ?? 0 }}
                                                        Gambar</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">{{ $layanan->sub_layanans_count ?? 0 }}
                                                        Sub</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('layanan.show', $layanan->id) }}"
                                                        class="btn btn-sm btn-info">Detail</a>
                                                    <a href="{{ route('layanan.edit', $layanan->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('layanan.destroy', $layanan->id) }}"
                                                        method="POST" style="display:inline;" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                    <form
                                                        action=@if ($layanan->price_list_pdf) <a href="{{ asset('upload/layanan/pdf/' . $layanan->price_list_pdf) }}"
                                                            target="_blank"
                                                        <button type="submit" class="btn btn-sm btn-success">Download PDF</button>
                                                    @else
                                                        <span class=""></span> @endif
                                                        </td>
                                                    </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Price List</th>
                                            <th>Galeri</th>
                                            <th>Sub Layanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data ini akan dihapus secara permanen!',
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
@endsection
