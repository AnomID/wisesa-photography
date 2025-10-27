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
                                <li class="breadcrumb-item" aria-current="page">Detail Data Galeri</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Detail Data Galeri</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detail Data Galeri</h5>
                            <div>
                                <a href="{{ route('galeri.edit', $galeri->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('galeri.index') }}" class="btn btn-light">Kembali</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Galeri</label>
                                        <p class="mb-0">{{ $galeri->judul_galeri ?? '-' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Keterangan</label>
                                        <p class="mb-0">{{ $galeri->keterangan }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Layanan</label>
                                        <p class="mb-0">{{ $galeri->layanan->judul ?? '-' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Slug</label>
                                        <p class="mb-0">{{ $galeri->slug }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Dibuat</label>
                                        <p class="mb-0">{{ $galeri->created_at->format('d F Y H:i') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Terakhir Diperbarui</label>
                                        <p class="mb-0">{{ $galeri->updated_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Gambar</label>
                                        @if ($galeri->gambar)
                                            <div class="text-center">
                                                <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}"
                                                    alt="Gambar {{ $galeri->keterangan }}" class="img-fluid rounded"
                                                    style="max-height: 400px;">
                                            </div>
                                        @else
                                            <div class="bg-light rounded p-4 text-center">
                                                <i class="bx bx-image" style="font-size: 4rem; color: #ccc;"></i>
                                                <p class="text-muted mt-2">Tidak ada gambar</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
