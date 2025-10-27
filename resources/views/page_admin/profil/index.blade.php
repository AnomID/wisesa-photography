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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Profil</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tabel Data Profil</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tabel Data Profil</h2>
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
                            <h5 class="mb-0">Tabel Data Profil</h5>
                            <a href="{{ route('profil.create') }}"
                                class="btn btn-primary @if ($profils->count() > 0) disabled @endif"
                                @if ($profils->count() > 0) aria-disabled="true" tabindex="-1" @endif>Tambah Data
                                Profil</a>
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
                                            <th>Nama Perusahaan</th>
                                            <th>No. Telepon</th>
                                            <th>Logo Perusahaan</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Koordinat</th>
                                            <th>Media Sosial</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profils as $e => $profil)
                                            <tr>
                                                <td>{{ $e + 1 }}</td>
                                                <td>{{ $profil->nama_perusahaan }}</td>
                                                <td>{{ $profil->no_telp_perusahaan }}</td>
                                                <td>
                                                    <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}"
                                                        alt="Logo Perusahaan" class="img-fluid" style="max-width: 100px;">
                                                </td>
                                                <td>{{ $profil->email_perusahaan }}</td>
                                                <td>{{ $profil->alamat_perusahaan }}</td>
                                                <td>{{ $profil->latitude }}, {{ $profil->longitude }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if ($profil->instagram_perusahaan)
                                                            <a href="https://instagram.com/{{ $profil->instagram_perusahaan }}"
                                                                target="_blank" class="btn btn-sm btn-danger">
                                                                <i class="fab fa-instagram"></i>
                                                            </a>
                                                        @endif
                                                        @if ($profil->facebook_perusahaan)
                                                            <a href="https://facebook.com/{{ $profil->facebook_perusahaan }}"
                                                                target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="fab fa-facebook-f"></i>
                                                            </a>
                                                        @endif
                                                        @if ($profil->tiktok_perusahaan)
                                                            <a href="https://tiktok.com/{{ $profil->tiktok_perusahaan }}"
                                                                target="_blank" class="btn btn-sm btn-dark">
                                                                <i class="fab fa-tiktok"></i>
                                                            </a>
                                                        @endif
                                                        @if ($profil->whatsapp_perusahaan)
                                                            <a href="https://wa.me/{{ $profil->whatsapp_perusahaan }}"
                                                                target="_blank" class="btn btn-sm btn-success">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('profil.show', $profil->id) }}"
                                                        class="btn btn-sm btn-info">Detail</a>
                                                    <a href="{{ route('profil.edit', $profil->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('profil.destroy', $profil->id) }}"
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
                                            <th>Nama Perusahaan</th>
                                            <th>No. Telepon</th>
                                            <th>Logo Perusahaan</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Koordinat</th>
                                            <th>Media Sosial</th>
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
