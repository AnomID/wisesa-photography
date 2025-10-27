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
                                <li class="breadcrumb-item" aria-current="page">Form Edit Data Profil</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Form Edit Data Profil</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ form-element ] start -->
                <div class="col-lg-12">
                    <!-- Basic Inputs -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Edit Data Profil</h5>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('profil.update', $profil->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Perusahaan</label>
                                            <input type="text" name="nama_perusahaan"
                                                class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                                value="{{ old('nama_perusahaan', $profil->nama_perusahaan) }}" required>
                                            @error('nama_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">No. Telepon</label>
                                            <input type="text" name="no_telp_perusahaan"
                                                class="form-control @error('no_telp_perusahaan') is-invalid @enderror"
                                                value="{{ old('no_telp_perusahaan', $profil->no_telp_perusahaan) }}"
                                                required>
                                            @error('no_telp_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Alamat Perusahaan</label>
                                            <textarea name="alamat_perusahaan" class="form-control @error('alamat_perusahaan') is-invalid @enderror"
                                                placeholder="Masukkan alamat perusahaan" required>{{ old('alamat_perusahaan', $profil->alamat_perusahaan) }}</textarea>
                                            @error('alamat_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email_perusahaan"
                                                class="form-control @error('email_perusahaan') is-invalid @enderror"
                                                value="{{ old('email_perusahaan', $profil->email_perusahaan) }}" required>
                                            @error('email_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" name="instagram_perusahaan"
                                                class="form-control @error('instagram_perusahaan') is-invalid @enderror"
                                                value="{{ old('instagram_perusahaan', $profil->instagram_perusahaan) }}"
                                                placeholder="Masukkan username Instagram">
                                            <small class="text-muted">Contoh: "namauser" (akan menjadi
                                                https://www.instagram.com/namauser)</small>
                                            @error('instagram_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Facebook</label>
                                            <input type="text" name="facebook_perusahaan"
                                                class="form-control @error('facebook_perusahaan') is-invalid @enderror"
                                                value="{{ old('facebook_perusahaan', $profil->facebook_perusahaan) }}"
                                                placeholder="Masukkan username Facebook">
                                            <small class="text-muted">Contoh: "nama.user" (akan menjadi
                                                https://www.facebook.com/nama.user)</small>
                                            @error('facebook_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">TikTok</label>
                                            <input type="text" name="tiktok_perusahaan"
                                                class="form-control @error('tiktok_perusahaan') is-invalid @enderror"
                                                value="{{ old('tiktok_perusahaan', $profil->tiktok_perusahaan) }}"
                                                placeholder="Masukkan username TikTok (Pakai @)">
                                            <small class="text-muted">Contoh: "@namauser" (akan menjadi
                                                https://tiktok.com/@namauser)</small>
                                            @error('tiktok_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">WhatsApp</label>
                                            <input type="text" name="whatsapp_perusahaan"
                                                class="form-control @error('whatsapp_perusahaan') is-invalid @enderror"
                                                value="{{ old('whatsapp_perusahaan', $profil->whatsapp_perusahaan) }}"
                                                placeholder="Masukkan nomor WhatsApp (dengan kode negara)">
                                            <small class="text-muted">Contoh: 081234567890 (tanpa + atau spasi)</small>
                                            @error('whatsapp_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Logo Perusahaan</label>
                                            @if ($profil->logo_perusahaan)
                                                <div class="mb-2">
                                                    <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}"
                                                        alt="Logo Perusahaan Saat Ini" class="img-fluid rounded"
                                                        style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                                    <br>
                                                    <small class="text-muted">Logo saat ini</small>
                                                </div>
                                            @endif
                                            <input type="file" name="logo_perusahaan"
                                                class="form-control @error('logo_perusahaan') is-invalid @enderror"
                                                accept="image/*">
                                            <small class="text-muted">Format: JPG, JPEG, PNG, GIF, SVG. Maksimal
                                                7MB</small>
                                            @error('logo_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Latitude</label>
                                            <input type="text" name="latitude" id="latitude"
                                                class="form-control @error('latitude') is-invalid @enderror"
                                                value="{{ old('latitude', $profil->latitude) }}"
                                                placeholder="Masukkan latitude" readonly>
                                            @error('latitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longitude</label>
                                            <input type="text" name="longitude" id="longitude"
                                                class="form-control @error('longitude') is-invalid @enderror"
                                                value="{{ old('longitude', $profil->longitude) }}"
                                                placeholder="Masukkan longitude" readonly>
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Pilih Lokasi di Peta</label>
                                            <div class="mb-2">
                                                <input type="text" id="search-location" class="form-control"
                                                    placeholder="Cari lokasi...">
                                                <div id="search-results" class="list-group"
                                                    style="display: none; max-height: 200px; overflow-y: auto; position: absolute; z-index: 1000; width: 100%;">
                                                </div>
                                            </div>
                                            <div id="map"
                                                style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 5px;">
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">Klik pada peta, gunakan pencarian, atau geser
                                                    marker untuk memilih lokasi</small>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <strong>Latitude:</strong> <span id="current-lat">-</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>Longitude:</strong> <span id="current-lng">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button type="reset" class="btn btn-light">Reset</button>
                                </div>
                            </form>
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
        // Inisialisasi Leaflet
        var map = L.map('map').setView([-6.1751, 106.8650], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker untuk lokasi yang dipilih
        let marker = null;
        let searchTimeout = null;

        // Fungsi untuk menambahkan marker
        function addMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // Event ketika marker di-drag
            marker.on('dragend', function(e) {
                const position = e.target.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });

            // Event ketika marker sedang di-drag
            marker.on('drag', function(e) {
                const position = e.target.getLatLng();
                updateDisplay(position.lat, position.lng);
            });
        }

        // Fungsi untuk mengupdate koordinat di form
        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            updateDisplay(lat, lng);
        }

        // Fungsi untuk mengupdate display koordinat
        function updateDisplay(lat, lng) {
            document.getElementById('current-lat').textContent = lat.toFixed(6);
            document.getElementById('current-lng').textContent = lng.toFixed(6);
        }

        // Event ketika peta diklik
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            addMarker(lat, lng);
            updateCoordinates(lat, lng);
        });

        // Pencarian lokasi dengan debounce
        document.getElementById('search-location').addEventListener('input', function(e) {
            const query = e.target.value;

            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            if (query.length < 3) {
                hideSearchResults();
                return;
            }

            searchTimeout = setTimeout(() => {
                searchLocation(query);
            }, 500);
        });

        // Fungsi pencarian lokasi
        async function searchLocation(query) {
            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&countrycodes=id`
                );
                const results = await response.json();
                showSearchResults(results);
            } catch (error) {
                console.error('Error searching location:', error);
            }
        }

        // Menampilkan hasil pencarian
        function showSearchResults(results) {
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';

            if (results.length === 0) {
                resultsContainer.innerHTML = '<div class="list-group-item">Tidak ada hasil ditemukan</div>';
            } else {
                results.forEach(result => {
                    const item = document.createElement('div');
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${result.display_name}</h6>
                        </div>
                        <small>Lat: ${parseFloat(result.lat).toFixed(6)}, Lng: ${parseFloat(result.lon).toFixed(6)}</small>
                    `;

                    item.addEventListener('click', () => {
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);
                        addMarker(lat, lng);
                        updateCoordinates(lat, lng);
                        map.setView([lat, lng], 15);
                        hideSearchResults();
                        document.getElementById('search-location').value = result.display_name;
                    });

                    resultsContainer.appendChild(item);
                });
            }

            resultsContainer.style.display = 'block';
        }

        // Menyembunyikan hasil pencarian
        function hideSearchResults() {
            document.getElementById('search-results').style.display = 'none';
        }

        // Menyembunyikan hasil pencarian saat klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#search-location') && !e.target.closest('#search-results')) {
                hideSearchResults();
            }
        });

        // Inisialisasi koordinat dari data yang ada
        const existingLat = document.getElementById('latitude').value;
        const existingLng = document.getElementById('longitude').value;
        if (existingLat && existingLng) {
            addMarker(parseFloat(existingLat), parseFloat(existingLng));
            map.setView([parseFloat(existingLat), parseFloat(existingLng)], 15);
            updateDisplay(parseFloat(existingLat), parseFloat(existingLng));
        } else {
            // Set koordinat default Jakarta
            updateDisplay(-6.1751, 106.8650);
        }
    </script>
@endsection
