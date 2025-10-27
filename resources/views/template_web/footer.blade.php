<footer class="footer __js_fixed-footer">
    <div class="footer__container container container--size-large">
        <div class="footer__grid">
            <a class="footer__logo" href="{{ route('landing') }}">
                @if (isset($profil) && $profil->logo_perusahaan)
                    <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}"
                        alt="{{ $profil->nama_perusahaan ?? 'Wisesa Photography' }}" style="max-height: 60px;">
                @else
                    <svg width="59" height="242">
                        <use xlink:href="#vertical-logo"></use>
                    </svg>
                @endif
            </a>
            <div class="footer__phone">
                <a
                    href="tel:{{ $profil->no_telp_perusahaan ?? '+62521 6021 2131' }}">{{ $profil->no_telp_perusahaan ?? '+62521 6021 2131' }}</a>
            </div>
            <div class="footer__menu">
                <div class="footer__title">Quick Links</div>
                <ul class="footer__menu-list">
                    <li class="footer__menu-item">
                        <a class="footer__menu-link" href="{{ route('landing') }}">Home</a>
                    </li>
                    <li class="footer__menu-item">
                        <a class="footer__menu-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="footer__menu-item">
                        <a class="footer__menu-link" href="{{ route('services') }}">Service</a>
                    </li>
                    <li class="footer__menu-item">
                        <a class="footer__menu-link" href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="footer__menu-item">
                        <a class="footer__menu-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="footer__menu">
                <div class="footer__title">Follow</div>
                <ul class="footer__menu-list">
                    @if (isset($profil) && $profil->instagram_perusahaan)
                        <li class="footer__menu-item">
                            <a class="footer__menu-link" href="{{ $profil->instagram_perusahaan }}"
                                target="_blank">Instagram</a>
                        </li>
                    @endif
                    @if (isset($profil) && $profil->facebook_perusahaan)
                        <li class="footer__menu-item">
                            <a class="footer__menu-link" href="{{ $profil->facebook_perusahaan }}"
                                target="_blank">Facebook</a>
                        </li>
                    @endif
                    @if (isset($profil) && $profil->tiktok_perusahaan)
                        <li class="footer__menu-item">
                            <a class="footer__menu-link" href="{{ $profil->tiktok_perusahaan }}"
                                target="_blank">Tiktok</a>
                        </li>
                    @endif
                    @if (isset($profil) && $profil->whatsapp_perusahaan)
                        <li class="footer__menu-item">
                            <a class="footer__menu-link"
                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->whatsapp_perusahaan) }}"
                                target="_blank">Whatsapp</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="footer__feedback">
                <div class="footer__title">Sign up to book us</div>
                <form class="footer__feedback-form" action="#" method="post">
                    <label class="footer__feedback-field field">
                        <a class="footer__menu-link" href="#">BOOK NOW</a>
                    </label>
                    <button class="footer__feedback-send arrow-btn arrow-btn--size-large" type="button">
                        <svg width="75" height="75">
                            <use xlink:href="#link-arrow"></use>
                        </svg>
                    </button>
                </form>
                <div class="footer__feedback-notice">This site is protected by reCAPTHCHA and the <a href="#"
                        target="_blank">Google Privacy Policy</a> and <a href="#" target="_blank">Terms of Service
                        apply</a>.</div>
            </div>
            <div class="footer__bottom">
                <div class="footer__copyright">© {{ $profil->nama_perusahaan ?? 'Wisesa Photography' }}
                    {{ date('Y') }}. All Rights Reserved</div>
                <a class="footer__privacy" href="#">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>
