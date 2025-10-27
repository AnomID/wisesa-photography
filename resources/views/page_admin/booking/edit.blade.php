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
                                <li class="breadcrumb-item"><a href="{{ route('admin.booking.index') }}">Booking</a></li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.booking.show', $booking->id) }}">Detail Booking
                                        #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Edit Booking
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">
                                    <i class="fas fa-exclamation-circle me-2"></i>Update Informasi Booking
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Pemesan</label>
                                            <input type="text" name="nama"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama', $booking->nama) }}" placeholder="Nama Pemesan">
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2"
                                                placeholder="Alamat">{{ old('address', $booking->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Booking</label>
                                            <input type="date" name="booking_date"
                                                class="form-control @error('booking_date') is-invalid @enderror"
                                                value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}">
                                            @error('booking_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Paket</label>
                                            <select name="layanan_id" id="layanan_id"
                                                class="form-control @error('layanan_id') is-invalid @enderror">
                                                <option value="">Pilih Paket</option>
                                                @foreach (\App\Models\Layanan::all() as $layanan)
                                                    <option value="{{ $layanan->id }}"
                                                        {{ old('layanan_id', $booking->layanan_id) == $layanan->id ? 'selected' : '' }}>
                                                        {{ $layanan->judul }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('layanan_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Sub Paket</label>
                                            <select name="sub_layanan_id" id="sub_layanan_id"
                                                class="form-control @error('sub_layanan_id') is-invalid @enderror">
                                                <option value="">Pilih Sub Paket</option>
                                                @if ($booking->subLayanan)
                                                    <option value="{{ $booking->subLayanan->id }}" selected>
                                                        {{ $booking->subLayanan->judul }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('sub_layanan_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Area</label>
                                            <input type="text" name="area"
                                                class="form-control @error('area') is-invalid @enderror"
                                                value="{{ old('area', $booking->area) }}" placeholder="Area">
                                            @error('area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Fotografer</label>
                                            <input type="text" name="fotografer"
                                                class="form-control @error('fotografer') is-invalid @enderror"
                                                value="{{ old('fotografer', $booking->fotografer) }}"
                                                placeholder="Nama Fotografer">
                                            @error('fotografer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" name="telephone"
                                                class="form-control @error('telephone') is-invalid @enderror"
                                                value="{{ old('telephone', $booking->telephone) }}" placeholder="Telepon">
                                            @error('telephone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" name="instagram"
                                                class="form-control @error('instagram') is-invalid @enderror"
                                                value="{{ old('instagram', $booking->instagram) }}"
                                                placeholder="Instagram">
                                            @error('instagram')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Waktu Booking</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="time" name="booking_time"
                                                        class="form-control @error('booking_time') is-invalid @enderror"
                                                        value="{{ old('booking_time', $booking->booking_time) }}"
                                                        placeholder="Dari">
                                                    @error('booking_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="time" name="booking_end_time"
                                                        class="form-control @error('booking_end_time') is-invalid @enderror"
                                                        value="{{ old('booking_end_time', $booking->booking_end_time) }}"
                                                        placeholder="Sampai">
                                                    @error('booking_end_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Biaya</label>
                                            <input type="text" name="biaya"
                                                class="form-control @error('biaya') is-invalid @enderror"
                                                value="{{ old('biaya', $booking->biaya) }}" placeholder="Contoh: 500000">
                                            @error('biaya')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" name="lokasi_photo"
                                                class="form-control @error('lokasi_photo') is-invalid @enderror"
                                                value="{{ old('lokasi_photo', $booking->lokasi_photo) }}"
                                                placeholder="Lokasi">
                                            @error('lokasi_photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Universitas</label>
                                            <input type="text" name="universitas"
                                                class="form-control @error('universitas') is-invalid @enderror"
                                                value="{{ old('universitas', $booking->universitas) }}"
                                                placeholder="Universitas">
                                            @error('universitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Baris Tambahan untuk Status dan Catatan -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status"
                                                class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="Pending"
                                                    {{ $booking->status == 'Pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="Ditolak"
                                                    {{ $booking->status == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak
                                                </option>
                                                <option value="Diterima"
                                                    {{ $booking->status == 'Diterima' ? 'selected' : '' }}>
                                                    Diterima
                                                </option>
                                                <option value="Diproses"
                                                    {{ $booking->status == 'Diproses' ? 'selected' : '' }}>
                                                    Diproses
                                                </option>
                                                <option value="Selesai"
                                                    {{ $booking->status == 'Selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Riwayat Catatan</label>
                                            <div class="card bg-light border">
                                                <div class="card-body p-3" style="max-height: 150px; overflow-y: auto;">
                                                    @if (is_array($booking->catatan) && count($booking->catatan) > 0)
                                                        @foreach (array_reverse($booking->catatan) as $index => $item)
                                                            <div class="border-start border-primary border-3 ps-2 mb-2">
                                                                <small class="text-muted d-block">
                                                                    <i
                                                                        class="fas fa-calendar me-1"></i>{{ $item['tanggal'] ?? '' }}
                                                                    <i
                                                                        class="fas fa-clock ms-2 me-1"></i>{{ $item['waktu'] ?? '' }}
                                                                    <span
                                                                        class="badge bg-info ms-2">{{ $item['status'] ?? '' }}</span>
                                                                </small>
                                                                <p class="mb-0 small">{{ $item['isi'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    @elseif (is_string($booking->catatan) && $booking->catatan)
                                                        <p class="mb-0 small">{{ $booking->catatan }}</p>
                                                    @else
                                                        <p class="text-muted mb-0"><em>Belum ada catatan</em></p>
                                                    @endif
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Catatan dikelola melalui tombol
                                                "Update Status" di halaman detail
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="text-end mt-4">
                                    <a href="{{ route('admin.booking.show', $booking->id) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const layananSelect = document.getElementById('layanan_id');
            const subLayananSelect = document.getElementById('sub_layanan_id');

            // Function to load sub layanans
            function loadSubLayanans(layananId) {
                // Clear current options except the first one
                const firstOption = subLayananSelect.querySelector('option[value=""]');
                subLayananSelect.innerHTML = '';
                if (firstOption) {
                    subLayananSelect.appendChild(firstOption);
                }

                if (layananId) {
                    // Fetch sub layanans
                    fetch(`/api/sub-layanan/${layananId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(function(subLayanan) {
                                const option = document.createElement('option');
                                option.value = subLayanan.id;
                                option.textContent = subLayanan.judul;

                                // Check if this is the currently selected sub layanan
                                @if ($booking->subLayanan)
                                    if (subLayanan.id == {{ $booking->sub_layanan_id }}) {
                                        option.selected = true;
                                    }
                                @endif

                                subLayananSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }

            // Load sub layanans on page load if layanan is already selected
            const currentLayananId = layananSelect.value;
            if (currentLayananId) {
                loadSubLayanans(currentLayananId);
            }

            // Load sub layanans when layanan changes
            layananSelect.addEventListener('change', function() {
                loadSubLayanans(this.value);
            });
        });
    </script>
@endsection
