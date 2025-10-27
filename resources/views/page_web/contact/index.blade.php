@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection
@section('content')
    <main>
        <article class="contact">
            <section class="contact-section">
                <div class="contact-section__container container container--size-large">
                    <div class="row">
                        <div class="contact-section__main col-12 col-md">
                            <h2 class="contact-section__title" data-aos="fade-up">Contact</h2>
                            <address class="contact-section__address" data-aos="fade-up">
                                {{ $profil->alamat_perusahaan ?? 'Alamat belum tersedia' }}</address>
                            <div class="contact-section__link" data-aos="fade-up">
                                <a "{{ $profil->no_telp_perusahaan ?? '#' }}">{{ $profil->no_telp_perusahaan ?? 'No. Telepon belum tersedia' }}</a>
                            </div>
                            <div class="contact-section__link" data-aos="fade-up">
                                <a "{{ $profil->email_perusahaan ?? '#' }}">{{ $profil->email_perusahaan ?? 'Email belum tersedia' }}</a>
                            </div>
                            <ul class="contact-section__social" data-aos="fade-up">
                                @if ($profil->instagram_perusahaan)
                                    <li>
                                        <a href="https://instagram.com/{{ $profil->instagram_perusahaan }}"
                                            target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                                    </li>
                                @endif
                                @if ($profil->facebook_perusahaan)
                                    <li>
                                        <a href="https://facebook.com/{{ $profil->facebook_perusahaan }}" target="_blank"><i
                                                class="fab fa-facebook-f"></i> Facebook</a>
                                    </li>
                                @endif
                                @if ($profil->tiktok_perusahaan)
                                    <li>
                                        <a href="https://tiktok.com/{{ $profil->tiktok_perusahaan }}" target="_blank"><i
                                                class="fab fa-tiktok"></i> Tiktok</a>
                                    </li>
                                @endif
                                @if ($profil->whatsapp_perusahaan)
                                    <li>
                                        <a href="https://wa.me/{{ $profil->whatsapp_perusahaan }}" target="_blank"><i
                                                class="fab fa-whatsapp"></i> WhatsApp</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-12 col-md">
                            <div class="discuss-project discuss-project--no-padding contact-section__aside">
                                <div class="discuss-project__wrapper" data-aos="fade-up">
                                    <div class="discuss-project__title" data-aos="fade-up">Contact</div>
                                    <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                                        @csrf
                                        <div class="row justify-content-between gx-0">
                                            <div class="discuss-project__field-wrapper col-12 col-md-6" data-aos="fade-up">
                                                <label class="discuss-project__field field">
                                                    <input type="text" name="nama" value="{{ old('nama') }}"
                                                        required>
                                                    <span class="field__hint">Name</span>
                                                </label>
                                                @error('nama')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="discuss-project__field-wrapper col-12 col-md-6" data-aos="fade-up">
                                                <label class="discuss-project__field field">
                                                    <input type="email" name="email" value="{{ old('email') }}"
                                                        required>
                                                    <span class="field__hint">Email</span>
                                                </label>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="discuss-project__field-wrapper col-12" data-aos="fade-up">
                                                <label class="discuss-project__field field">
                                                    <input type="number" name="no_hp" id="no_hp"
                                                        value="{{ old('no_hp') }}" required>
                                                    <span class="field__hint">No. HP (Tanpa +)</span>
                                                </label>
                                                @error('no_hp')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-12" data-aos="fade-up">
                                                <label
                                                    class="discuss-project__field discuss-project__field--textarea field">
                                                    <textarea name="pesan" required>{{ old('pesan') }}</textarea>
                                                    <span class="field__hint">Message</span>
                                                </label>
                                                @error('pesan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-12" data-aos="fade-up">
                                                <div class="h-captcha" data-sitekey="{{ config('hcaptcha.site_key') }}"
                                                    id="hcaptcha"></div>
                                                @error('h-captcha-response')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                <small class="text-danger" id="captchaError" style="display: none;">Captcha
                                                    wajib diisi!</small>
                                            </div>
                                            <div class="discuss-project__bottom col-12">
                                                <button class="discuss-project__send btn--theme-black btn" type="submit"
                                                    data-aos="fade-up">
                                                    <span class="btn__text">Submit</span>
                                                    <span class="btn__icon">
                                                        <svg width="19" height="19">
                                                            <use xlink:href="#link-arrow"></use>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-section__map" data-aos="fade-up">
                    @if ($profil && $profil->latitude && $profil->longitude)
                        <div id="map"></div>
                    @else
                        <div
                            style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5;">
                            <p style="color: #999; font-size: 18px;">Lokasi peta belum tersedia</p>
                        </div>
                    @endif
                </div>
            </section>
        </article>
    </main>
@endsection

@section('script')
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($profil && $profil->latitude && $profil->longitude)
            var map = L.map('map').setView([{{ $profil->latitude }}, {{ $profil->longitude }}], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);

            var customIcon = L.icon({
                iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
                iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var marker = L.marker([{{ $profil->latitude }}, {{ $profil->longitude }}], {
                icon: customIcon
            }).addTo(map);

            marker.bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <h6 style="margin-bottom: 10px; font-weight: bold;">{{ $profil->nama_perusahaan }}</h6>
                    <p style="margin-bottom: 5px; font-size: 13px;">{{ $profil->alamat_perusahaan }}</p>
                    <p style="margin-bottom: 5px; font-size: 13px;">
                        <i class="fas fa-phone"></i> {{ $profil->no_telp_perusahaan }}
                    </p>
                    <p style="margin-bottom: 0; font-size: 13px;">
                        <i class="fas fa-envelope"></i> {{ $profil->email_perusahaan }}
                    </p>
                </div>
            `).openPopup();

            var circle = L.circle([{{ $profil->latitude }}, {{ $profil->longitude }}], {
                color: '#4CAF50',
                fillColor: '#4CAF50',
                fillOpacity: 0.15,
                radius: 500
            }).addTo(map);
        @endif

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const nama = document.querySelector('input[name="nama"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const noHp = document.querySelector('input[name="no_hp"]').value.trim();
            const pesan = document.querySelector('textarea[name="pesan"]').value.trim();
            const captchaResponse = document.querySelector('[name="h-captcha-response"]');
            const captchaError = document.getElementById('captchaError');
            const captchaElement = document.getElementById('hcaptcha');

            if (!nama) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nama wajib diisi!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('input[name="nama"]').focus();
                return false;
            }

            if (!email) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email wajib diisi!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('input[name="email"]').focus();
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Format email tidak valid!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('input[name="email"]').focus();
                return false;
            }

            if (!noHp) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No. HP wajib diisi!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('input[name="no_hp"]').focus();
                return false;
            }

            const numericRegex = /^[0-9]+$/;
            if (!numericRegex.test(noHp)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No. HP harus berupa angka!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('input[name="no_hp"]').focus();
                return false;
            }

            if (noHp.length < 10 || noHp.length > 15) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No. HP harus antara 10-15 digit!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('input[name="no_hp"]').focus();
                return false;
            }

            if (!pesan) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pesan wajib diisi!',
                    confirmButtonColor: '#000'
                });
                document.querySelector('textarea[name="pesan"]').focus();
                return false;
            }

            if (!captchaResponse || !captchaResponse.value) {
                e.preventDefault();
                captchaError.style.display = 'block';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Captcha wajib diisi! Silakan centang "I am human"',
                    confirmButtonColor: '#000'
                });
                captchaElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            }

            captchaError.style.display = 'none';
        });

        window.addEventListener('load', function() {
            if (typeof hcaptcha !== 'undefined') {
                hcaptcha.render('hcaptcha', {
                    callback: function() {
                        document.getElementById('captchaError').style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
