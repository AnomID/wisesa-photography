<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="/dashboard-superadmin" class="b-brand text-primary d-flex align-items-center" style="gap: 10px;">
                @php
                    $profil = \App\Models\Profil::first();
                @endphp
                @if ($profil && $profil->logo_perusahaan)
                    <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}" alt="Logo"
                        style="height: 50px;">
                @else
                    <img src="{{ asset('env/logo.png') }}" alt="Logo" style="height: 50px;">
                @endif
                @if ($profil && $profil->nama_perusahaan)
                    <span class="ms-2 h4 mb-0 brand-title text-dark ">{{ $profil->nama_perusahaan }}</span>
                @else
                    <span class="ms-2 h4 mb-0 brand-title text-dark ">StarterKit-v2</span>
                @endif
            </a>
        </div>
        @if (Auth::check() && Auth::user()->role == 'superadmin')
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="/dashboard-superadmin" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-home"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Data Admin</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('artikel.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-news"></i></span>
                            <span class="pc-mtext">Data Artikel</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('profil.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-user"></i></span>
                            <span class="pc-mtext">Profil</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('beranda.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-home"></i></span>
                            <span class="pc-mtext">Beranda</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('galeri.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-photo"></i></span>
                            <span class="pc-mtext">Galeri</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('kontak.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-phone"></i></span>
                            <span class="pc-mtext">Kontak</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('layanan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
                            <span class="pc-mtext">Layanan (Service)</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('produk.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-package"></i></span>
                            <span class="pc-mtext">Produk</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('tentang.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-info-circle"></i></span>
                            <span class="pc-mtext">Tentang</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('testimoni.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-message-dots"></i></span>
                            <span class="pc-mtext">Testimoni</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('tim.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Tim</span>
                        </a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-settings"></i></span>
                            <span class="pc-mtext">Master</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a href="{{ route('kategoriArtikel.index') }}" class="pc-link">Kategori
                                    Artikel</a></li>
                            <li class="pc-item"><a href="{{ route('kategoriProduk.index') }}" class="pc-link">Kategori
                                    Produk</a></li>
                            <li class="pc-item"><a href="{{ route('kategoriGambar.index') }}"
                                    class="pc-link">Kategori Gambar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
