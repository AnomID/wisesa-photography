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
                                <li class="breadcrumb-item"><a href="/dashboard-superadmin">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('layanan.index') }}">Layanan</a></li>
                                <li class="breadcrumb-item" aria-current="page">Detail Data Layanan</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Detail Data Layanan</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detail Data Layanan</h5>
                            <div>
                                <a href="{{ route('layanan.edit', $layanan->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('layanan.index') }}" class="btn btn-light">Kembali</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Layanan</label>
                                        <p class="mb-0">{{ $layanan->judul }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Slug</label>
                                        <p class="mb-0">{{ $layanan->slug }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Price List PDF</label>
                                        @if ($layanan->price_list_pdf)
                                            <p class="mb-0">
                                                <a href="{{ asset('upload/layanan/pdf/' . $layanan->price_list_pdf) }}"
                                                    target="_blank" class="btn btn-sm btn-info">
                                                    <i class="bx bx-file-pdf"></i> Lihat/Download PDF
                                                </a>
                                            </p>
                                        @else
                                            <p class="mb-0 text-muted">Tidak ada file PDF</p>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Dibuat</label>
                                        <p class="mb-0">{{ $layanan->created_at->format('d F Y H:i') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Terakhir Diperbarui</label>
                                        <p class="mb-0">{{ $layanan->updated_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Gambar</label>
                                        @if ($layanan->gambar)
                                            <div class="text-center">
                                                <img src="{{ asset('upload/layanan/' . $layanan->gambar) }}"
                                                    alt="Gambar {{ $layanan->judul }}" class="img-fluid rounded"
                                                    style="max-height: 300px;">
                                            </div>
                                        @else
                                            <div class="bg-light rounded p-4 text-center">
                                                <i class="bx bx-image" style="font-size: 4rem; color: #ccc;"></i>
                                                <p class="text-muted mt-2">Tidak ada gambar</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Deskripsi Layanan</label>
                                        <div class="bg-light rounded p-3">
                                            {!! $layanan->deskripsi !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Galeri dan Sub Layanan -->
            <div class="row mt-4">
                <!-- Galeri Layanan -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Galeri Layanan ({{ $layanan->galeris->count() }})</h5>
                            <a href="{{ route('galeri.create') }}?layanan_id={{ $layanan->id }}"
                                class="btn btn-sm btn-primary">
                                <i class="bx bx-plus"></i> Tambah
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($layanan->galeris->count() > 0)
                                <div class="row g-3">
                                    @foreach ($layanan->galeris as $galeri)
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}"
                                                    class="card-img-top" alt="{{ $galeri->keterangan }}"
                                                    style="height: 150px; object-fit: cover;">
                                                <div class="card-body p-2">
                                                    <p class="mb-0 small">{{ Str::limit($galeri->keterangan, 50) }}</p>
                                                    <div class="mt-2">
                                                        <a href="{{ route('galeri.show', $galeri->id) }}"
                                                            class="btn btn-sm btn-info">Detail</a>
                                                        <a href="{{ route('galeri.edit', $galeri->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bx bx-image-alt text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-3">Belum ada galeri untuk layanan ini</p>
                                    <a href="{{ route('galeri.create') }}?layanan_id={{ $layanan->id }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="bx bx-plus me-1"></i> Tambah Galeri
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sub Layanan -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sub Layanan ({{ $layanan->subLayanans->count() }})</h5>
                            <a href="{{ route('sub-layanan.create') }}?layanan_id={{ $layanan->id }}"
                                class="btn btn-sm btn-primary">
                                <i class="bx bx-plus"></i> Tambah
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($layanan->subLayanans->count() > 0)
                                <div class="list-group">
                                    @foreach ($layanan->subLayanans as $subLayanan)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $subLayanan->judul }}</h6>
                                                    <p class="mb-1 small text-muted">
                                                        {{ Str::limit($subLayanan->deskripsi, 80) }}</p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('sub-layanan.show', $subLayanan->id) }}"
                                                        class="btn btn-sm btn-info">Detail</a>
                                                    <a href="{{ route('sub-layanan.edit', $subLayanan->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bx bx-list-ul text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-3">Belum ada sub layanan untuk layanan ini</p>
                                    <a href="{{ route('sub-layanan.create') }}?layanan_id={{ $layanan->id }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="bx bx-plus me-1"></i> Tambah Sub Layanan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
