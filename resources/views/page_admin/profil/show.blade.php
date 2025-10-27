@extends('template_admin.layout')
@section('style')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
@endsection
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
                                <li class="breadcrumb-item" aria-current="page">Detail Data Profil</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Detail Data Profil</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Informasi Perusahaan -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bx bx-building me-2"></i>Detail Data Profil</h5>
                            <div>
                                <a href="{{ route('profil.edit', $profil->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bx bx-edit me-1"></i>Edit
                                </a>
                                <a href="{{ route('profil.index') }}" class="btn btn-light btn-sm">
                                    <i class="bx bx-arrow-back me-1"></i>Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Logo dan Info Utama -->
                                <div class="col-md-4 text-center mb-4">
                                    <div class="border rounded p-3 bg-light">
                                        <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}"
                                            alt="Logo Perusahaan" class="img-fluid rounded"
                                            style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <h4 class="text-primary mb-3">{{ $profil->nama_perusahaan }}</h4>

                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-phone text-success me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">No. Telepon</small>
                                                    <strong>{{ $profil->no_telp_perusahaan }}</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-envelope text-info me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Email</small>
                                                    <strong>{{ $profil->email_perusahaan }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bx bx-map text-warning me-2 mt-1"></i>
                                            <div>
                                                <small class="text-muted d-block">Alamat</small>
                                                <strong>{{ $profil->alamat_perusahaan }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Sosial -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-muted mb-3"><i class="bx bx-share-alt me-2"></i>Media Sosial</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if ($profil->instagram_perusahaan)
                                            <a href="https://instagram.com/{{ $profil->instagram_perusahaan }}"
                                                target="_blank" class="btn btn-icon btn-outline-danger btn-sm"
                                                title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if ($profil->facebook_perusahaan)
                                            <a href="https://facebook.com/{{ $profil->facebook_perusahaan }}"
                                                target="_blank" class="btn btn-icon btn-outline-primary btn-sm"
                                                title="Facebook">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        @endif
                                        @if ($profil->tiktok_perusahaan)
                                            <a href="https://tiktok.com/{{ $profil->tiktok_perusahaan }}" target="_blank"
                                                class="btn btn-icon btn-outline-dark btn-sm" title="TikTok">

                                                <i class="fab fa-tiktok"></i>
                                            </a>
                                        @endif
                                        @if ($profil->whatsapp_perusahaan)
                                            <a href="https://wa.me/{{ $profil->whatsapp_perusahaan }}" target="_blank"
                                                class="btn btn-icon btn-outline-success btn-sm" title="WhatsApp">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peta Lokasi -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bx bx-map me-2"></i>Lokasi Perusahaan</h6>
                        </div>
                        <div class="card-body">
                            @if ($profil->latitude && $profil->longitude)
                                <div id="map" style="height: 300px; width: 100%; border-radius: 5px;"></div>
                                <div class="mt-3">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Latitude</small>
                                            <strong class="text-primary">{{ $profil->latitude }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Longitude</small>
                                            <strong class="text-primary">{{ $profil->longitude }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bx bx-map-pin text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Lokasi belum ditentukan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
    <script>
        @if ($profil->latitude && $profil->longitude)
            // Inisialisasi Leaflet untuk menampilkan lokasi
            var map = L.map('map').setView([{{ $profil->latitude }}, {{ $profil->longitude }}], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Menambahkan marker untuk lokasi perusahaan
            var marker = L.marker([{{ $profil->latitude }}, {{ $profil->longitude }}]).addTo(map);

            // Menambahkan popup dengan informasi perusahaan
            marker.bindPopup(`
            <div class="text-center">
                <h6 class="mb-2">{{ $profil->nama_perusahaan }}</h6>
                <p class="mb-1"><small>{{ $profil->alamat_perusahaan }}</small></p>
                <p class="mb-0"><small>{{ $profil->no_telp_perusahaan }}</small></p>
            </div>
        `).openPopup();

            // Menambahkan circle untuk area sekitar
            var circle = L.circle([{{ $profil->latitude }}, {{ $profil->longitude }}], {
                color: '#007bff',
                fillColor: '#007bff',
                fillOpacity: 0.1,
                radius: 500
            }).addTo(map);
        @endif
    </script>
@endsection
