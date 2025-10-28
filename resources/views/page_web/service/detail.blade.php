@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@section('content')
    <main>
        <article class="service-detail">
            <div class="first-banner">
                <div class="first-banner__image">
                    <img src="{{ asset('upload/layanan/' . $layanan->gambar) }}" width="1920" height="1100"
                        alt="{{ $layanan->judul }}" />
                </div>
            </div>

            {{-- Service Detail Section --}}
            <div class="container container--small">
                <div class="single-post__title" data-aos="fade-up" style="margin-top: 60px;">
                    {{ $layanan->judul }}
                </div>
                <div class="single-post__text" data-aos="fade-up" style="margin-top: 30px;">
                    {!! $layanan->deskripsi !!}
                </div>
            </div>
            {{-- Galleries Section --}}
            @if ($galeris->count() > 0)
                <section class="carousel-section service-detail__carousel">
                    <div class="container">
                        <header class="carousel-section__header row align-items-end align-items-md-center">
                            <h2 class="carousel-section__title col-12 col-md-10" data-aos="fade-up">Galeries</h2>
                            <div class="carousel-section__nav col-12 col-md-2 order-last order-md-0" data-aos="fade-up">
                                <button class="nav-btn nav-btn--prev __js_navbtn-gallery"
                                    data-target=".__js_carousel-gallery" type="button">
                                    <svg width="50" height="16">
                                        <use xlink:href="#long-arrow-left"></use>
                                    </svg>
                                </button>
                                <button class="nav-btn nav-btn--next __js_navbtn-gallery"
                                    data-target=".__js_carousel-gallery" type="button">
                                    <svg width="50" height="16">
                                        <use xlink:href="#long-arrow-right"></use>
                                    </svg>
                                </button>
                            </div>
                        </header>
                    </div>
                    <div class="container container--size-large">
                        <div class="carousel-section__carousel carousel carousel--slide-auto swiper-container __js_carousel-gallery"
                            data-aos="fade-up">
                            <div class="swiper-wrapper">
                                @php
                                    $globalIndex = 0;
                                @endphp
                                @foreach ($galeris as $galeri)
                                    @php
                                        // Get list_gallery dari galeri
                                        $listGallery = $galeri->list_gallery ?? [];
                                        if (is_string($listGallery)) {
                                            $listGallery = json_decode($listGallery, true) ?? [];
                                        }

                                        // Filter dan collect gambar dari list_gallery
                                        $galleryItems = collect($listGallery)
                                            ->filter(function ($item) {
                                                if (is_array($item)) {
                                                    return isset($item['gambar']) && !empty($item['gambar']);
                                                }
                                                return is_string($item) && !empty($item);
                                            })
                                            ->values();

                                        // Tambahkan juga gambar utama galeri jika ada
                                        if ($galeri->gambar) {
                                            $galleryItems->prepend($galeri->gambar);
                                        }
                                    @endphp

                                    @foreach ($galleryItems as $index => $item)
                                        @php
                                            $gambar = is_array($item) ? $item['gambar'] : $item;
                                            $judul = is_array($item)
                                                ? $item['judul_galeri'] ?? $galeri->judul_galeri
                                                : $galeri->judul_galeri;

                                            // Tentukan rasio untuk setiap gambar
                                            $ratios = ['ratio-3-2', 'ratio-4-3', 'ratio-1-1', 'ratio-portrait'];
                                            $ratioIndex = ($globalIndex + $galeri->id) % count($ratios);
                                            $selectedRatio = $ratios[$ratioIndex];

                                            // Mapping rasio ke ukuran width dan height (diperkecil agar lebih proporsional)
                                            $ratioSizes = [
                                                'ratio-3-2' => ['width' => 400, 'height' => 267],
                                                'ratio-4-3' => ['width' => 400, 'height' => 300],
                                                'ratio-1-1' => ['width' => 350, 'height' => 350],
                                                'ratio-portrait' => ['width' => 280, 'height' => 420],
                                            ];

                                            $size = $ratioSizes[$selectedRatio] ?? $ratioSizes['ratio-3-2'];
                                            $globalIndex++;
                                        @endphp
                                        <a class="carousel__item project-preview swiper-slide"
                                            href="{{ route('gallery.detail', $galeri->slug) }}">
                                            <span class="project-preview__image {{ $selectedRatio }}">
                                                <img src="{{ asset('upload/galeri/' . $gambar) }}"
                                                    width="{{ $size['width'] }}" height="{{ $size['height'] }}"
                                                    alt="{{ $judul }}" style="object-fit: cover;">
                                            </span>
                                            <span class="project-preview__bottom">
                                                <span class="project-preview__title">{{ $judul }}</span>
                                                <span class="project-preview__icon">
                                                    <svg width="24" height="23">
                                                        <use xlink:href="#link-arrow2"></use>
                                                    </svg>
                                                </span>
                                            </span>
                                        </a>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </article>
    </main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize carousel untuk gallery
            const carouselGallery = new Swiper('.__js_carousel-gallery', {
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
            document.querySelectorAll('.nav-btn--prev[data-target=".__js_carousel-gallery"]').forEach(btn => {
                btn.addEventListener('click', () => carouselGallery.slidePrev());
            });

            document.querySelectorAll('.nav-btn--next[data-target=".__js_carousel-gallery"]').forEach(btn => {
                btn.addEventListener('click', () => carouselGallery.slideNext());
            });

            // Pause autoplay on hover
            const carouselContainer = document.querySelector('.__js_carousel-gallery');
            if (carouselContainer) {
                carouselContainer.addEventListener('mouseenter', () => {
                    carouselGallery.autoplay.stop();
                });
                carouselContainer.addEventListener('mouseleave', () => {
                    carouselGallery.autoplay.start();
                });
            }
        });
    </script>
@endsection
