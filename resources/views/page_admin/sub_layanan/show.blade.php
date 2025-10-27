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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Sub Layanan</a></li>
                                <li class="breadcrumb-item" aria-current="page">Detail Data Sub Layanan</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Detail Data Sub Layanan</h2>
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
                            <h5 class="mb-0">Detail Data Sub Layanan</h5>
                            <div>
                                <a href="{{ route('sub-layanan.edit', $subLayanan->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('sub-layanan.index') }}" class="btn btn-light">Kembali</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Layanan Induk</label>
                                        <p class="mb-0">
                                            <span class="badge bg-primary">{{ $subLayanan->layanan->judul ?? '-' }}</span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Sub Layanan</label>
                                        <p class="mb-0">{{ $subLayanan->judul }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Deskripsi</label>
                                        <div class="bg-light rounded p-3">
                                            {{ $subLayanan->deskripsi ?? 'Tidak ada deskripsi' }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Slug</label>
                                        <p class="mb-0">{{ $subLayanan->slug }}</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tanggal Dibuat</label>
                                                <p class="mb-0">{{ $subLayanan->created_at->format('d F Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Terakhir Diperbarui</label>
                                                <p class="mb-0">{{ $subLayanan->updated_at->format('d F Y H:i') }}</p>
                                            </div>
                                        </div>
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
