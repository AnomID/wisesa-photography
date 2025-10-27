@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="{{ asset('css/booking-form.css') }}">
@endsection
@section('content')
    <main>
        <section class="booking-section">
            <div class="booking-container">
                <div class="booking-form-container">
                    <h1 class="form-title">Create Booking</h1>
                    <form class="booking-form" id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="field">
                                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->name) }}"
                                    placeholder=" " required>
                                <label for="nama" class="field__hint">
                                    <ion-icon name="person-outline"></ion-icon>
                                    Nama *
                                </label>
                                @error('nama')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="text" id="telephone" name="telephone"
                                    value="{{ old('telephone', $user->no_wa) }}" placeholder=" " required>
                                <label for="telephone" class="field__hint">
                                    <ion-icon name="call-outline"></ion-icon>
                                    Telephone *
                                </label>
                                @error('telephone')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <input type="text" id="area" name="area" value="{{ old('area', $user->area) }}"
                                    placeholder=" " required>
                                <label for="area" class="field__hint">
                                    <ion-icon name="location-outline"></ion-icon>
                                    Area *
                                </label>
                                @error('area')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="text" id="instagram" name="instagram"
                                    value="{{ old('instagram', $user->instagram) }}" placeholder=" ">
                                <label for="instagram" class="field__hint">
                                    <ion-icon name="logo-instagram"></ion-icon>
                                    Instagram
                                </label>
                                <div class="form-help">Username Instagram tanpa @</div>
                                @error('instagram')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <textarea id="address" name="address" rows="3" placeholder=" " required>{{ old('address') }}</textarea>
                            <label for="address" class="field__hint">
                                <ion-icon name="home-outline"></ion-icon>
                                Address *
                            </label>
                            @error('address')
                                <div class="field__error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <select id="layanan_id" name="layanan_id" required>
                                    <option value="">Pilih Layanan</option>
                                    @foreach ($layanans as $layanan)
                                        <option value="{{ $layanan->id }}"
                                            {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                            {{ $layanan->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="layanan_id" class="field__hint">
                                    <ion-icon name="briefcase-outline"></ion-icon>
                                    Layanan *
                                </label>
                                @error('layanan_id')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <select id="sub_layanan_id" name="sub_layanan_id">
                                    <option value="">Pilih Sub Layanan</option>
                                </select>
                                <label for="sub_layanan_id" class="field__hint">
                                    <ion-icon name="grid-outline"></ion-icon>
                                    Sub Layanan
                                </label>
                                @error('sub_layanan_id')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <input type="date" id="booking_date" name="booking_date"
                                    value="{{ old('booking_date') }}" min="{{ date('Y-m-d') }}" required>
                                <label for="booking_date" class="field__hint">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                    Tanggal Booking *
                                </label>
                                @error('booking_date')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="time" id="booking_time" name="booking_time"
                                    value="{{ old('booking_time') }}" required>
                                <label for="booking_time" class="field__hint">
                                    <ion-icon name="time-outline"></ion-icon>
                                    Waktu Mulai *
                                </label>
                                @error('booking_time')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="time" id="booking_end_time" name="booking_end_time"
                                    value="{{ old('booking_end_time') }}" required>
                                <label for="booking_end_time" class="field__hint">
                                    <ion-icon name="time-outline"></ion-icon>
                                    Waktu Selesai *
                                </label>
                                @error('booking_end_time')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <input type="text" id="universitas" name="universitas"
                                    value="{{ old('universitas') }}" placeholder=" " required>
                                <label for="universitas" class="field__hint">
                                    <ion-icon name="school-outline"></ion-icon>
                                    Universitas *
                                </label>
                                @error('universitas')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="text" id="lokasi_photo" name="lokasi_photo"
                                    value="{{ old('lokasi_photo') }}" placeholder=" " required>
                                <label for="lokasi_photo" class="field__hint">
                                    <ion-icon name="camera-outline"></ion-icon>
                                    Lokasi Photo *
                                </label>
                                @error('lokasi_photo')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <textarea id="catatan" name="catatan" rows="3" placeholder=" ">{{ old('catatan') }}</textarea>
                            <label for="catatan" class="field__hint">
                                <ion-icon name="document-text-outline"></ion-icon>
                                Catatan Tambahan
                            </label>
                            <div class="form-help">Masukkan catatan tambahan jika ada</div>
                            @error('catatan')
                                <div class="field__error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="submit-booking-btn">
                                <ion-icon name="checkmark-circle-outline"></ion-icon>
                                <span>Submit Booking</span>
                            </button>
                            <a href="{{ route('booking.index') }}" class="back-booking-btn">
                                <ion-icon name="arrow-back-outline"></ion-icon>
                                <span>Back</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        // Handle field filled state untuk konsistensi dengan main.css
        document.addEventListener('DOMContentLoaded', function() {
            const fields = document.querySelectorAll('.field input, .field textarea, .field select');

            fields.forEach(function(field) {
                // Khusus untuk select, date, dan time - label langsung ke atas
                if (field.tagName === 'SELECT' || field.type === 'date' || field.type === 'time') {
                    field.closest('.field').classList.add('field--filled');

                    field.addEventListener('change', function() {
                        if (this.value !== '' && this.value !== null) {
                            this.closest('.field').classList.add('field--filled');
                        } else {
                            this.closest('.field').classList.remove('field--filled');
                        }
                    });

                    return; // Skip loop untuk field-field ini
                }

                // Check if field has value on load
                if (field.value && field.value.trim() !== '') {
                    field.closest('.field').classList.add('field--filled');
                }

                // Handle focus and blur events
                field.addEventListener('focus', function() {
                    this.closest('.field').classList.add('field--filled');
                });

                field.addEventListener('blur', function() {
                    if (!this.value || this.value.trim() === '') {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });

                // Handle input/change events
                field.addEventListener('input', function() {
                    if (this.value && this.value.trim() !== '') {
                        this.closest('.field').classList.add('field--filled');
                    } else {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });

                field.addEventListener('change', function() {
                    if (this.value && this.value !== '') {
                        this.closest('.field').classList.add('field--filled');
                    } else {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });
            });

            // Handle layanan dropdown change untuk load sub layanan
            const layananSelect = document.getElementById('layanan_id');
            if (layananSelect) {
                layananSelect.addEventListener('change', function() {
                    const layananId = this.value;
                    const subLayananSelect = document.getElementById('sub_layanan_id');

                    // Reset sub layanan
                    subLayananSelect.innerHTML = '<option value="">Pilih Sub Layanan</option>';

                    if (layananId) {
                        fetch(`/api/sub-layanan/${layananId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                data.forEach(subLayanan => {
                                    const option = document.createElement('option');
                                    option.value = subLayanan.id;
                                    option.textContent = subLayanan.judul;
                                    subLayananSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                subLayananSelect.innerHTML =
                                    '<option value="">Error loading sub layanan</option>';
                            });
                    }
                });
            }
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection
