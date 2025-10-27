<header class="header __js_fixed-header">
    <div class="header__container container container--size-large">
        @php
            $profil = \App\Models\Profil::first();
        @endphp
        <a class="header__logo logo">
            @if ($profil && $profil->logo_perusahaan)
                <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}" alt="Logo"
                    style="height: 40px; width: auto;">
            @else
                <img src="{{ asset('env/logo.png') }}" alt="Logo" style="height: 40px; width: auto;">
            @endif
        </a>
        <div class="header__mobile mobile-canvas">
            <nav class="mobile-canvas__nav navigation">
                <ul class="navigation__list">
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/">Home<span
                                class="navigation__link-icon">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/about">About<span
                                class="navigation__link-icon">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/services">Services<span
                                class="navigation__link-icon">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/gallery">Gallery<span
                                class="navigation__link-icon">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/contact">Contact<span
                                class="navigation__link-icon">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>
            @php
                use Illuminate\Support\Str;
            @endphp
            <ul class="header__social social--white social">
                @guest
                    <li class="navigation__item" style="margin-bottom: 8px;">
                        <a class="navigation__link animsition-link" href="{{ route('login') }}">
                            Login
                            <span class="navigation__link-icon">
                                <i class='bx bx-log-in'></i>
                            </span>
                        </a>
                    </li>
                    <li class="navigation__item" style="margin-bottom: 8px;">
                        <a class="navigation__link animsition-link" href="{{ route('register') }}">
                            Register
                            <span class="navigation__link-icon">
                                <i class='bx bx-user-plus'></i>
                            </span>
                        </a>
                    </li>
                @else
                    <li class="navigation__item user-dropdown-wrapper" style="margin-bottom: 8px; position: relative;">
                        @php
                            $user = auth()->user();
                            $fotoProfile = $user->foto_profile ?? null;
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
                        <a class="navigation__link user-dropdown-trigger" href="#"
                            style="display: flex; align-items: center; cursor: pointer;">
                            <img src="{{ $srcFoto }}" alt="Foto Profil" class="user-avatar">
                            <span class="user-name">{{ $user->name }}</span>
                            <span class="navigation__link-icon user-dropdown-arrow">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                        <div class="user-dropdown-menu">
                            <ul class="user-dropdown-list">
                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="{{ route('profil-user') }}">
                                        <span class="user-dropdown-text">Profile</span>
                                        <span class="user-dropdown-icon">
                                            <svg width="12" height="13">
                                                <use xlink:href="#link-arrow"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="{{ route('booking.index') }}">
                                        <span class="user-dropdown-text">My Order</span>
                                        <span class="user-dropdown-icon">
                                            <svg width="12" height="13">
                                                <use xlink:href="#link-arrow"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="user-dropdown-text">Logout</span>
                                        <span class="user-dropdown-icon">
                                            <i class='bx bx-log-out'></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <button class="header__menu-toggle menu-toggle" type="button">
            <span class="menu-toggle__line"></span>
            <span class="visually-hidden">Menu toggle</span>
        </button>
    </div>
</header>

@auth
    <form id="logout-form" action="{{ route('logout.post') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth

<style>
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: border-color 0.3s ease;
    }

    .user-dropdown-trigger:hover .user-avatar {
        border-color: rgba(255, 255, 255, 0.6);
    }

    .user-name {
        vertical-align: middle;
        margin-right: 6px;
    }

    .user-dropdown-arrow {
        transition: transform 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .user-dropdown-trigger.active .user-dropdown-arrow {
        transform: rotate(90deg);
    }

    @media (min-width: 992px) {
        .user-dropdown-wrapper {
            position: relative;
        }

        .user-dropdown-trigger {
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: opacity 0.3s ease;
            position: relative;
        }

        .user-dropdown-trigger:hover {
            opacity: 0.8;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 16px);
            right: 0;
            background: #ffffff !important;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            min-width: 200px;
            width: max-content;
            max-width: 280px;
            overflow: hidden;
        }

        .user-dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            background: #ffffff !important;
        }

        .user-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 24px;
            width: 12px;
            height: 12px;
            background: #ffffff;
            transform: rotate(45deg);
            box-shadow: -2px -2px 4px rgba(0, 0, 0, 0.05);
        }

        .user-dropdown-list {
            list-style: none;
            margin: 0;
            padding: 8px 0;
        }

        .user-dropdown-item {
            margin: 0;
            padding: 0;
        }

        .user-dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 500;
            gap: 12px;
        }

        .user-dropdown-link:hover {
            background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 100%);
            color: #f0a500;
            padding-left: 24px;
        }

        .user-dropdown-text {
            flex: 1;
        }

        .user-dropdown-icon {
            display: inline-flex;
            align-items: center;
            opacity: 0.5;
            transition: all 0.2s ease;
        }

        .user-dropdown-link:hover .user-dropdown-icon {
            opacity: 1;
            transform: translateX(2px);
        }

        .user-dropdown-icon i {
            font-size: 16px;
        }

        .user-dropdown-item:not(:last-child) {
            border-bottom: 1px solid #f0f0f0;
        }

        .user-dropdown-item {
            transition: background-color 0.2s ease;
        }

        /* Memastikan background putih di semua kondisi desktop */
        .user-dropdown-menu,
        .user-dropdown-menu:hover,
        .user-dropdown-menu:focus,
        .user-dropdown-menu:active {
            background: #ffffff !important;
        }

        .user-dropdown-list {
            background: #ffffff !important;
        }
    }

    @media (max-width: 991px) {
        .user-dropdown-menu {
            position: static !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin-top: 12px !important;
            display: none;
        }

        .user-dropdown-menu.active {
            display: block;
        }

        .user-dropdown-menu::before {
            display: none !important;
        }

        .user-dropdown-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .user-dropdown-item {
            margin: 0;
            padding: 0;
            border: none !important;
        }

        .user-dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0 !important;
            color: inherit !important;
            text-decoration: none;
            font-size: 14px;
        }

        .user-dropdown-link:hover {
            background: transparent !important;
            padding-left: 0 !important;
        }

        .user-dropdown-icon {
            margin-left: 8px;
            opacity: 0.7;
        }

        .user-avatar {
            border-color: rgba(255, 255, 255, 0.5);
        }
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .user-dropdown-menu.active {
        animation: dropdownFadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.header');
        const currentPath = window.location.pathname;
        const whiteTextUrls = ['/', '/about'];

        if (whiteTextUrls.includes(currentPath)) {
            header.classList.add('header--white-text');
        }

        const dropdownTrigger = document.querySelector('.user-dropdown-trigger');
        const dropdownMenu = document.querySelector('.user-dropdown-menu');
        const dropdownWrapper = document.querySelector('.user-dropdown-wrapper');

        if (dropdownTrigger && dropdownMenu) {
            dropdownTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isActive = dropdownMenu.classList.contains('active');

                document.querySelectorAll('.user-dropdown-menu.active').forEach(menu => {
                    menu.classList.remove('active');
                });
                document.querySelectorAll('.user-dropdown-trigger.active').forEach(trigger => {
                    trigger.classList.remove('active');
                });

                if (!isActive) {
                    dropdownMenu.classList.add('active');
                    dropdownTrigger.classList.add('active');
                } else {
                    dropdownMenu.classList.remove('active');
                    dropdownTrigger.classList.remove('active');
                }
            });

            document.addEventListener('click', function(e) {
                if (dropdownWrapper && !dropdownWrapper.contains(e.target)) {
                    dropdownMenu.classList.remove('active');
                    dropdownTrigger.classList.remove('active');
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    dropdownMenu.classList.remove('active');
                    dropdownTrigger.classList.remove('active');
                }
            });

            const dropdownLinks = dropdownMenu.querySelectorAll('.user-dropdown-link');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.getAttribute('onclick')) {
                        dropdownMenu.classList.remove('active');
                        dropdownTrigger.classList.remove('active');
                    }
                });
            });

            dropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });

        }
    });
</script>
