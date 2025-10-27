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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Beranda</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tabel Data Beranda</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tabel Data Beranda</h2>
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
                            <h5 class="mb-0">Tabel Data Beranda</h5>
                            @if ($berandas->isEmpty())
                                <a href="{{ route('beranda.create') }}" class="btn btn-primary">Tambah Data Beranda</a>
                            @endif
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
                                            <th>Gambar Utama</th>
                                            <th>Judul Utama</th>
                                            <th>Slogan</th>
                                            <th>Gambar Sekunder</th>
                                            <th>Judul Sekunder</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($berandas as $e => $beranda)
                                            <tr>
                                                <td>{{ $e + 1 }}</td>
                                                <td>
                                                    @if ($beranda->gambar_utama)
                                                        <img src="{{ asset('upload/beranda/' . $beranda->gambar_utama) }}"
                                                            alt="Gambar Utama" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-2">
                                                            <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $beranda->judul_utama }}</td>
                                                <td>{{ $beranda->slogan }}</td>
                                                <td>
                                                    @if ($beranda->gambar_sekunder)
                                                        <img src="{{ asset('upload/beranda/' . $beranda->gambar_sekunder) }}"
                                                            alt="Gambar Sekunder" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-2">
                                                            <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $beranda->judul_sekunder }}</td>
                                                <td>{!! Str::limit($beranda->keterangan, 50) !!}</td>
                                                <td>
                                                    <a href="{{ route('beranda.show', $beranda->id) }}"
                                                        class="btn btn-sm btn-info">Detail</a>
                                                    <a href="{{ route('beranda.edit', $beranda->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar Utama</th>
                                            <th>Judul Utama</th>
                                            <th>Slogan</th>
                                            <th>Gambar Sekunder</th>
                                            <th>Judul Sekunder</th>
                                            <th>Keterangan</th>
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
    <script>
        $(document).ready(function() {
            $('#simpletable').DataTable();
        });
    </script>
@endsection
