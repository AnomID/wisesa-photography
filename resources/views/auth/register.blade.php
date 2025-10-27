<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | StarterKit-v2</title>
    <link rel="icon" href="{{ asset('admin') }}/assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/feather.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/material.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style-preset.css">
    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: block;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        body {
            background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        }

        .auth-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .auth-header img {
            height: 42px;
        }

        .brand-title {
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .card.rounded-4 {
            border-radius: 1rem !important;
        }

        .btn[data-password-toggle] {
            border-left: 0;
        }
    </style>
    @include('sweetalert::alert')
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons/5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="auth-header">
                    <a href="#" class="d-inline-flex align-items-center text-decoration-none">
                        <img src="{{ asset('env') }}/logo_text.png" alt="StarterKit-v2">
                        <span class="ms-2 h5 mb-0 brand-title text-dark">StarterKit-v2</span>
                    </a>
                </div>
                <div class="card my-5 shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4">
                            <h3 class="mb-0 text-center"><b>Buat Akun</b></h3>
                        </div>
                        <div class="text-center mb-4">
                            <a href="{{ route('login') }}" class="link-primary">Sudah punya akun?</a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('google.login') }}" class="btn btn-light-primary bg-light text-muted">
                                <img src="{{ asset('admin') }}/assets/images/authentication/google.svg" alt="img">
                                <span class="d-none d-sm-inline-block"> Daftar dengan Google</span>
                            </a>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                    class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Buat username unik" required>
                                <div class="form-text">Username dipakai untuk login dan URL profil</div>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan alamat email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                                <input type="tel" id="no_wa" name="no_wa" value="{{ old('no_wa') }}"
                                    class="form-control @error('no_wa') is-invalid @enderror"
                                    placeholder="Contoh: 08123456789" required>
                                <div class="form-text">Dipakai untuk verifikasi/notifikasi</div>
                                @error('no_wa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" id="instagram" name="instagram"
                                    value="{{ old('instagram') }}"
                                    class="form-control @error('instagram') is-invalid @enderror"
                                    placeholder="Contoh: @username atau username" required>
                                <div class="form-text">Username Instagram Anda</div>
                                @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" id="area" name="area" value="{{ old('area') }}"
                                    class="form-control @error('area') is-invalid @enderror"
                                    placeholder="Contoh: Jakarta, Bandung, Surabaya" required>
                                <div class="form-text">Kota atau daerah tempat tinggal Anda</div>
                                @error('area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control border-end-0 @error('password') is-invalid @enderror"
                                        placeholder="Buat password yang kuat" required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0"
                                        data-password-toggle aria-label="Tampilkan password" aria-pressed="false">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Minimal 6 karakter</div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control border-end-0 @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Ulangi password" required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0"
                                        data-password-toggle aria-label="Tampilkan password" aria-pressed="false">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" id="agree-terms" name="agree-terms" class="form-check-input"
                                    required>
                                <label for="agree-terms" class="form-check-label">Saya setuju dengan <a
                                        href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan
                                        Privasi</a></label>
                                @error('agree-terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="auth-footer row align-items-center">
                    <div class="col my-1">
                        <p class="m-0">&copy; {{ date('Y') }} <span class="fw-semibold">StarterKit-v2</span>
                        </p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script src="{{ asset('admin') }}/assets/js/plugins/popper.min.js"></script>
    <script src="{{ asset('admin') }}/assets/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('admin') }}/assets/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('admin') }}/assets/js/fonts/custom-font.js"></script>
    <script src="{{ asset('admin') }}/assets/js/pcoded.js"></script>
    <script src="{{ asset('admin') }}/assets/js/plugins/feather.min.js"></script>
    <script>
        layout_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-1");
    </script>
    <script>
        font_change("Public-Sans");
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-password-toggle]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const group = btn.closest('.input-group');
                    if (!group) return;
                    const input = group.querySelector('input[type="password"], input[type="text"]');
                    if (!input) return;
                    const isHidden = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isHidden ? 'text' : 'password');
                    const icon = btn.querySelector('ion-icon');
                    if (icon) {
                        icon.setAttribute('name', isHidden ? 'eye-off-outline' : 'eye-outline');
                    }
                    btn.setAttribute('aria-pressed', String(isHidden));
                    btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' :
                        'Tampilkan password');
                });
            });
        });
    </script>
</body>

</html>
