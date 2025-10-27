@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@section('content')
    <main>
        <article class="article services">
            <div class="article__container container container--size-large">
                <div class="row">
                    <header class="article__header col-12 col-lg-7 col-xl-6">
                        <h1 class="article__title">Our
                            <br>services
                        </h1>
                        <div class="article__text">In the design process, they create both functional and beautiful
                            things.
                            The team possesses unique</div>
                    </header>

                    @foreach ($layanans->take(4) as $index => $layanan)
                        @php
                            $layouts = [
                                [
                                    'class' => 'services__item services__item--first col-12 col-sm-6 col-lg-5 col-xl-6',
                                    'width' => 810,
                                    'height' => 783,
                                ],
                                [
                                    'class' =>
                                        'services__item services__item--second services__item--margin-negative col-12 col-sm-6 col-lg-4',
                                    'width' => 410,
                                    'height' => 490,
                                ],
                                [
                                    'class' =>
                                        'services__item services__item--third services__item--left-shift col-12 col-sm-6 col-lg-8',
                                    'width' => 616,
                                    'height' => 496,
                                ],
                                [
                                    'class' =>
                                        'services__item services__item--last col-12 col-sm-6 col-lg-10 offset-lg-1 mb-5',
                                    'width' => 1238,
                                    'height' => 527,
                                ],
                            ];
                            $layout = $layouts[$index];
                        @endphp
                        <div class="{{ $layout['class'] }}" data-aos="{{ $index == 0 ? '' : 'fade-up' }}"
                            data-aos-delay="{{ $index * 100 }}">
                            <a class="service-preview" href="{{ route('services-detail', $layanan->slug) }}">
                                <span class="service-preview__image">
                                    <img src="{{ asset('storage/layanan/' . $layanan->gambar) }}"
                                        width="{{ $layout['width'] }}" height="{{ $layout['height'] }}"
                                        alt="{{ $layanan->judul }}">
                                </span>
                                <span class="service-preview__caption">{{ $layanan->judul }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Carousel Layanan Section --}}
                @if ($layanans->count() > 0)
                    <section class="carousel-section carousel-section--separator mt-5">
                        <div class="carousel-section__container">
                            <header class="carousel-section__header row align-items-center">
                                <h2 class="carousel-section__title col-12 col-md-6" data-aos="fade-up">
                                    Semua Layanan Kami
                                </h2>
                                <div class="carousel-section__nav col-12 col-md-3 order-last order-md-0" data-aos="fade-up">
                                    <button class="nav-btn nav-btn--prev" data-target=".__js_carousel-layanan"
                                        type="button">
                                        <svg width="50" height="16">
                                            <use xlink:href="#long-arrow-left"></use>
                                        </svg>
                                    </button>
                                    <button class="nav-btn nav-btn--next" data-target=".__js_carousel-layanan"
                                        type="button">
                                        <svg width="50" height="16">
                                            <use xlink:href="#long-arrow-right"></use>
                                        </svg>
                                    </button>
                                </div>
                                <div class="col-12 col-md-3 text-md-right ml-auto" data-aos="fade-up">
                                    <a class="carousel-section__more arrow-link" href="{{ route('services') }}">
                                        <span class="arrow-link__text">Lihat Semua</span>
                                        <span class="arrow-link__icon">
                                            <svg width="75" height="75">
                                                <use xlink:href="#link-arrow"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </header>
                            <div class="carousel-section__carousel carousel carousel--slide-auto swiper-container __js_carousel-layanan"
                                data-aos="fade-up">
                                <div class="swiper-wrapper">
                                    @foreach ($layanans as $layanan)
                                        <a class="carousel__item project-preview swiper-slide"
                                            href="{{ route('services-detail', $layanan->slug) }}">
                                            <span class="project-preview__image">
                                                <img src="{{ asset('storage/layanan/' . $layanan->gambar) }}"
                                                    width="334" height="255" alt="{{ $layanan->judul }}"
                                                    loading="lazy">
                                            </span>
                                            <span class="project-preview__bottom">
                                                <span class="project-preview__title">{{ $layanan->judul }}</span>
                                                <span class="project-preview__icon">
                                                    <svg width="24" height="23">
                                                        <use xlink:href="#link-arrow2"></use>
                                                    </svg>
                                                </span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

            </div>
        </article>
    </main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize carousel untuk layanan dengan style landing page
            const carouselLayanan = new Swiper('.__js_carousel-layanan', {
                slidesPerView: 'auto',
                spaceBetween: 30,
                loop: true,
                speed: 800,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                grabCursor: true,
                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1280: {
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                    }
                }
            });

            // Custom navigation buttons
            document.querySelectorAll('.nav-btn--prev[data-target=".__js_carousel-layanan"]').forEach(btn => {
                btn.addEventListener('click', () => carouselLayanan.slidePrev());
            });

            document.querySelectorAll('.nav-btn--next[data-target=".__js_carousel-layanan"]').forEach(btn => {
                btn.addEventListener('click', () => carouselLayanan.slideNext());
            });

            // Pause autoplay on hover
            const carouselContainer = document.querySelector('.__js_carousel-layanan');
            if (carouselContainer) {
                carouselContainer.addEventListener('mouseenter', () => {
                    carouselLayanan.autoplay.stop();
                });
                carouselContainer.addEventListener('mouseleave', () => {
                    carouselLayanan.autoplay.start();
                });
            }
        });
    </script>
@endsection
