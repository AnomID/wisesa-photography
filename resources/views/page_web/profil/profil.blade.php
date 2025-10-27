@extends('template_web.layout')

@section('style')
    <style>
        /* Profile Page Styles - Sesuai dengan main.css */
        .profile-section {
            padding: 80px 0;
            background-color: #f7f7f7;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 19px;
        }

        @media (min-width: 1400px) {
            .profile-container {
                max-width: 1920px;
                padding: 0 80px;
            }
        }

        .profile-form-container {
            background: #ffffff;
            padding: 60px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .profile-form-container {
                padding: 40px 30px;
            }
        }

        .profile-form {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Profile Photo Styles */
        .profile-photo-input-container {
            text-align: center;
            margin-bottom: 60px;
        }

        @media (max-width: 768px) {
            .profile-photo-input-container {
                margin-bottom: 40px;
            }
        }

        @media (max-width: 480px) {
            .profile-photo-input-container {
                margin-bottom: 30px;
            }
        }

        .profile-photo-preview {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            border: 3px solid #FFC60A;
            transition: all 0.3s ease;
            background: #f7f7f7;
            display: inline-block;
            margin: 0 auto;
        }

        .profile-photo-preview:hover {
            border-color: #000000;
            transform: scale(1.05);
        }

        .profile-photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .photo-upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            border-radius: 50%;
        }

        .profile-photo-preview:hover .photo-upload-overlay {
            opacity: 1;
        }

        .photo-upload-overlay ion-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .photo-upload-overlay span {
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .form-help {
            color: rgba(0, 0, 0, 0.5);
            font-size: 15px;
            margin-top: 20px;
            text-align: center;
        }

        /* Form Group Styles - Menggunakan field class dari main.css */

        /* Menggunakan field class dari main.css untuk konsistensi */
        .field {
            position: relative;
            display: block;
            width: 100%;
            cursor: text;
            margin-bottom: 60px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .field input,
        .field textarea {
            display: block;
            width: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding: 0 0 14px;
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 16px;
            line-height: 1;
            color: #000000;
            background: transparent;
            border: none;
            border-bottom: 1px solid #000000;
            transition: all 0.3s ease;
        }

        .field input:focus,
        .field textarea:focus {
            outline: none;
            border-bottom-color: #FFC60A;
        }

        .field__hint {
            position: absolute;
            top: 3px;
            left: 0;
            font-size: 15px;
            line-height: 1;
            color: rgba(0, 0, 0, 0.5);
            text-transform: uppercase;
            transition: 0.2s ease;
            pointer-events: none;
        }

        .field--filled .field__hint {
            font-size: 12px;
            color: #000000;
            transform: translateY(-24px);
        }

        .field__hint ion-icon {
            font-size: 1.2rem;
            color: #FFC60A;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* Form Actions */
        .form-actions {
            text-align: center;
            margin-top: 60px;
        }

        .save-profile-btn {
            display: inline-flex;
            align-items: center;
            min-width: 207px;
            padding: 20px 40px;
            font-family: "Neue Montreal", "Arial", sans-serif;
            font-size: 15px;
            font-weight: 500;
            line-height: 1;
            text-align: center;
            text-transform: uppercase;
            color: #ffffff;
            background-color: #FFC60A;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .save-profile-btn:focus {
            outline: none;
        }

        @media (min-width: 992px) {

            .save-profile-btn:hover,
            .save-profile-btn:focus {
                background-color: #000000;
            }
        }

        .save-profile-btn ion-icon {
            font-size: 1.3rem;
            margin-right: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                padding: 0 19px;
            }

            .profile-photo-preview {
                width: 120px;
                height: 120px;
            }

            .field {
                margin-bottom: 40px;
            }

            .form-actions {
                margin-top: 40px;
            }

            .save-profile-btn {
                padding: 15px 30px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .profile-photo-preview {
                width: 100px;
                height: 100px;
            }

            .field {
                margin-bottom: 30px;
            }

            .form-actions {
                margin-top: 30px;
            }

            .save-profile-btn {
                padding: 12px 25px;
                min-width: 150px;
            }
        }
    </style>
@endsection

@section('content')
    <main>
        <section class="profile-section">
            <div class="profile-container">

                <div class="profile-form-container">
                    <form class="profile-form" id="profileForm" action="{{ route('profil-user.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="profile-photo-input-container">
                            <div class="profile-photo-preview" id="profile-photo-preview"
                                onclick="document.getElementById('profile-photo').click()">
                                @php
                                    use Illuminate\Support\Str;
                                    $fotoProfile = $data->foto_profile ?? (auth()->user()->foto_profile ?? null);
                                    if ($fotoProfile) {
                                        if (Str::startsWith($fotoProfile, ['http://', 'https://'])) {
                                            $srcFoto = $fotoProfile;
                                        } else {
                                            $srcFoto = asset('uploads/foto_profile/' . $fotoProfile);
                                        }
                                    } else {
                                        $srcFoto = asset('env/logo.jpg');
                                    }
                                @endphp
                                <img src="{{ $srcFoto }}" alt="Foto Profil" class="profile-photo-img"
                                    id="profile-photo-img">
                                <div class="photo-upload-overlay">
                                    <ion-icon name="camera-outline"></ion-icon>
                                    <span>Klik untuk ganti foto</span>
                                </div>
                            </div>

                            <input type="file" id="profile-photo" name="foto_profile" accept="image/*"
                                style="display: none !important;" onchange="handlePhotoChange(this)">

                            <div class="form-help">
                                Klik foto untuk mengganti. Format: JPG, PNG, GIF (Max: 2MB)
                            </div>
                        </div>

                        <div class="field">
                            <input type="text" id="fullname" name="name"
                                value="{{ $data->name ?? (auth()->user()->name ?? '') }}" placeholder=" " required>
                            <label for="fullname" class="field__hint">
                                <ion-icon name="person-outline"></ion-icon>
                                Nama Lengkap
                            </label>
                        </div>

                        <div class="field">
                            <input type="text" id="username" name="username"
                                value="{{ $data->username ?? (auth()->user()->username ?? '') }}" placeholder=" " required>
                            <label for="username" class="field__hint">
                                <ion-icon name="at-outline"></ion-icon>
                                Username
                            </label>
                            <div class="form-help">Username akan digunakan untuk login dan URL profil Anda</div>
                        </div>

                        <div class="field">
                            <input type="email" id="email" name="email"
                                value="{{ $data->email ?? (auth()->user()->email ?? '') }}" placeholder=" " required>
                            <label for="email" class="field__hint">
                                <ion-icon name="mail-outline"></ion-icon>
                                Email
                            </label>
                        </div>

                        <div class="field">
                            <input type="tel" id="phone" name="no_wa"
                                value="{{ $data->no_wa ?? (auth()->user()->no_wa ?? '') }}" placeholder=" " required>
                            <label for="phone" class="field__hint">
                                <ion-icon name="logo-whatsapp"></ion-icon>
                                No Whatsapp
                            </label>
                        </div>

                        <div class="field">
                            <input type="text" id="instagram" name="instagram"
                                value="{{ $data->instagram ?? (auth()->user()->instagram ?? '') }}" placeholder=" ">
                            <label for="instagram" class="field__hint">
                                <ion-icon name="logo-instagram"></ion-icon>
                                Instagram
                            </label>
                            <div class="form-help">Username Instagram tanpa @ </div>
                        </div>

                        <div class="field">
                            <input type="text" id="area" name="area"
                                value="{{ $data->area ?? (auth()->user()->area ?? '') }}" placeholder=" ">
                            <label for="area" class="field__hint">
                                <ion-icon name="location-outline"></ion-icon>
                                Area/Daerah
                            </label>
                            <div class="form-help">Kota atau daerah tempat tinggal </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="save-profile-btn">
                                <ion-icon name="save-outline"></ion-icon>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    @include('sweetalert::alert')
@endsection

@section('script')
    <script>
        function handlePhotoChange(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    input.value = '';
                    return;
                }
                if (!file.type.startsWith('image/')) {
                    alert('Pilih file gambar yang valid! Format: JPG, PNG, GIF');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-photo-img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Handle field filled state untuk konsistensi dengan main.css
        document.addEventListener('DOMContentLoaded', function() {
            const fields = document.querySelectorAll('.field input');

            fields.forEach(function(field) {
                // Check if field has value on load
                if (field.value.trim() !== '') {
                    field.closest('.field').classList.add('field--filled');
                }

                // Handle focus and blur events
                field.addEventListener('focus', function() {
                    this.closest('.field').classList.add('field--filled');
                });

                field.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });

                // Handle input events
                field.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.closest('.field').classList.add('field--filled');
                    } else {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });
            });

            // Validasi khusus untuk field Instagram
            const instagramField = document.getElementById('instagram');
            if (instagramField) {
                instagramField.addEventListener('input', function() {
                    let value = this.value.trim();
                    // Hapus @ jika user mengetiknya
                    if (value.startsWith('@')) {
                        value = value.substring(1);
                        this.value = value;
                    }
                    // Update filled state
                    if (value !== '') {
                        this.closest('.field').classList.add('field--filled');
                    } else {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });
            }
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection
