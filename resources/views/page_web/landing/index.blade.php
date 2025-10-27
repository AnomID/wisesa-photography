@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .testimonial-container {
            text-align: center;
            padding: 40px 20px;
            position: relative;
        }

        .testimonial-icon {
            font-size: 30px;
            color: purple;
            margin-bottom: 10px;
        }

        .testimonial-quote {
            font-style: italic;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .testimonial-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .testimonial-rating {
            color: purple;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .testimonial-name {
            font-weight: bold;
            margin: 5px 0 0;
        }

        .testimonial-location {
            font-size: 14px;
            color: #666;
        }

        autoplay: {
            delay: 4000,
                disableOnInteraction: false,
        }
    </style>
@endsection
@section('content')
    <main>
        <section class="main-screen">
            <div class="main-screen__image __js_parallax">
                <img src="{{ asset('upload/beranda/' . $beranda->gambar_utama) }}" width="1920" height="1080" alt="">
            </div>
            <div class="main-screen__container container container--size-large">
                <h1 class="main-screen__title">
                    <span>{{ $beranda->judul_utama }}</span>{{ $beranda->slogan }}
                </h1>
                <a class="main-screen__btn btn" href="">
                    <span class="btn__text">Book Now</span>
                    <span class="btn__icon">
                        <svg width="19" height="19">
                            <use xlink:href="#link-arrow"></use>
                        </svg>
                    </span>
                </a>
            </div>
        </section>
        {{-- Section About Us --}}
        <section class="about-video-section about-video-section--pt-50">
            <div class="about-video-section__container container container--size-large">
                <div class="row">
                    <div class="about-video-section__main col-12 col-md">
                        <div class="about-video-section__title about-video-section__title--size-large" data-aos="fade-up">
                            {{ $tentang->judul ?? 'Our team consists of practitioners who have 15 years of experience in launching and managing projects' }}
                        </div>
                        <div class="row align-items-end" data-aos="fade-up">
                            <div class="col-4 col-md-5 col-xl-4">
                                <a class="about-video-section__more arrow-link" href="{{ route('about') }}">
                                    <span class="arrow-link__text">About us</span>
                                    <span class="arrow-link__icon">
                                        <svg width="75" height="75">
                                            <use xlink:href="#link-arrow"></use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="col-8 col-md-7 col-xl-8">
                                <div class="about-video-section__text" data-aos="fade-up">
                                    {{ $tentang->deskripsi ?? 'We make our customers products valuable in the eyes of customers. To do this, we analyze and study people, build long-term strategies for interacting with them, develop creative ideas and create a bright design. We use all opportunities to solve business problems.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="about-video-section__aside col-12 col-md order-first order-md-0" data-aos="fade-up">
                        <div class="about-video-section__video video-block">
                            @if ($tentang && $tentang->gambar)
                                <img src="{{ asset('upload/tentang/' . $tentang->gambar) }}" width="810" height="539"
                                    alt="About us video">
                            @else
                                <img src="{{ asset('web') }}/img/picture/common/video-poster.jpg" width="810"
                                    height="539" alt="About us video">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="about-video-section__statistics statistics">
                    <div class="statistics__container container">
                        <div class="row justify-content-between">
                            @if ($tentang && $tentang->hitungan && $tentang->keterangan_hitungan)
                                @php
                                    $hitungan = is_array($tentang->hitungan)
                                        ? $tentang->hitungan
                                        : json_decode($tentang->hitungan, true);
                                    $keterangan = is_array($tentang->keterangan_hitungan)
                                        ? $tentang->keterangan_hitungan
                                        : json_decode($tentang->keterangan_hitungan, true);
                                @endphp
                                @foreach ($hitungan as $index => $value)
                                    <div class="statistics__item col-6 col-md-auto" data-aos="fade-up">
                                        <div class="statistics__item-value">
                                            <span class="__js_number" data-end-value="{{ $value }}">0</span>
                                        </div>
                                        <div class="statistics__item-text">{!! nl2br(e($keterangan[$index] ?? '')) !!}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="statistics__item col-6 col-md-auto" data-aos="fade-up">
                                    <div class="statistics__item-value">
                                        <span class="__js_number" data-end-value="25">0</span>
                                    </div>
                                    <div class="statistics__item-text">managers</div>
                                </div>
                                <div class="statistics__item col-6 col-md-auto" data-aos="fade-up">
                                    <div class="statistics__item-value">
                                        <span class="__js_number" data-end-value="200">0</span>
                                    </div>
                                    <div class="statistics__item-text">the person<br>in the team</div>
                                </div>
                                <div class="statistics__item col-6 col-md-auto" data-aos="fade-up">
                                    <div class="statistics__item-value">
                                        <span class="__js_number" data-end-value="15">0</span>
                                    </div>
                                    <div class="statistics__item-text">Years<br>experience</div>
                                </div>
                                <div class="statistics__item col-6 col-md-auto" data-aos="fade-up">
                                    <div class="statistics__item-value">
                                        <span class="__js_number" data-end-value="7">0</span>
                                    </div>
                                    <div class="statistics__item-text">awards and<br>accolades</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </section>
        {{-- Corousel Project --}}
        <section class="carousel-section carousel-section--separator">
            <div class="carousel-section__container container container--size-large">
                <header class="carousel-section__header row align-items-center">
                    <h2 class="carousel-section__title col-12 col-md-6" data-aos="fade-up">Our latest projects
                    </h2>
                    <div class="carousel-section__nav col-12 col-md-3 order-last order-md-0" data-aos="fade-up">
                        <button class="nav-btn nav-btn--prev" data-target=".__js_carousel-latest-projects" type="button">
                            <svg width="50" height="16">
                                <use xlink:href="#long-arrow-left"></use>
                            </svg>
                        </button>
                        <button class="nav-btn nav-btn--next" data-target=".__js_carousel-latest-projects" type="button">
                            <svg width="50" height="16">
                                <use xlink:href="#long-arrow-right"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="col-12 col-md-3 text-md-right ml-auto" data-aos="fade-up">
                        <a class="carousel-section__more arrow-link" href="{{ route('gallery') }}">
                            <span class="arrow-link__text">Lihat semua</span>
                            <span class="arrow-link__icon">
                                <svg width="75" height="75">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
                </header>
                <div class="carousel-section__carousel carousel carousel--slide-auto swiper-container __js_carousel-latest-projects"
                    data-aos="fade-up">
                    <div class="swiper-wrapper">
                        @forelse($galeris as $index => $galeri)
                            @php
                                $sizes = [
                                    ['width' => 720, 'height' => 548],
                                    ['width' => 404, 'height' => 491],
                                    ['width' => 334, 'height' => 255],
                                    ['width' => 433, 'height' => 321],
                                ];
                                $size = $sizes[$index % count($sizes)];
                            @endphp
                            <a class="carousel__item project-preview swiper-slide"
                                href="{{ route('gallery.detail', $galeri->slug) }}">
                                <span class="project-preview__image">
                                    <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}"
                                        width="{{ $size['width'] }}" height="{{ $size['height'] }}"
                                        alt="{{ $galeri->judul_galeri }}">
                                </span>
                                <span class="project-preview__bottom">
                                    <span class="project-preview__title">{{ $galeri->judul_galeri }}</span>
                                    <span class="project-preview__icon">
                                        <svg width="24" height="23">
                                            <use xlink:href="#link-arrow2"></use>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        @empty
                            <div class="carousel__item project-preview swiper-slide">
                                <span class="project-preview__image">
                                    <img src="{{ asset('web') }}/img/picture/carousel/4.jpg" width="720"
                                        height="548" alt="No projects available">
                                </span>
                                <span class="project-preview__bottom">
                                    <span class="project-preview__title">Belum ada proyek tersedia</span>
                                    <span class="project-preview__icon">
                                        <svg width="24" height="23">
                                            <use xlink:href="#link-arrow2"></use>
                                        </svg>
                                    </span>
                                </span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial Section -->
        <section class="about-video-section about-video-section--pt-50">
            <div class="about-video-section__container container container--size-large">

                <!-- Swiper -->
                <div class="swiper testimonial-swiper">
                    <div class="swiper-wrapper">

                        @forelse($testimonis as $testimoni)
                            <!-- Testimonial {{ $loop->iteration }} -->
                            <div class="swiper-slide">
                                <div class="testimonial-container">
                                    <div class="testimonial-icon"><i class="bx bx-heart"></i></div>
                                    <p class="testimonial-quote">"{{ $testimoni->testimoni }}"</p>
                                    <div class="testimonial-user">
                                        <img src="{{ asset('upload/testimoni/' . $testimoni->gambar) }}"
                                            alt="{{ $testimoni->nama }}" class="testimonial-avatar">
                                        <div class="testimonial-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $testimoni->rating)
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </div>
                                        <h4 class="testimonial-name">{{ $testimoni->nama }}</h4>
                                        <p class="testimonial-location">{{ $testimoni->jabatan }}</p>
                                        <p class="testimonial-date">{{ $testimoni->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Default testimonial jika tidak ada data -->
                            <div class="swiper-slide">
                                <div class="testimonial-container">
                                    <div class="testimonial-icon"><i class="bx bx-heart"></i></div>
                                    <p class="testimonial-quote">"Belum ada testimonial yang tersedia."</p>
                                    <div class="testimonial-user">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User"
                                            class="testimonial-avatar">
                                        <div class="testimonial-rating">★★★★★</div>
                                        <h4 class="testimonial-name">Admin</h4>
                                        <p class="testimonial-location">Administrator</p>
                                        <p class="testimonial-date">{{ now()->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>

                    <!-- Arrows -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

            </div>
        </section>
        <section class="our-services">
            <div class="our-services__container container container--size-large">
                <header class="our-services__header">
                    <div class="row align-items-baseline">
                        <div class="col-12 col-md-6 col-lg-5" data-aos="fade-up">
                            <h2 class="our-services__title">Our services</h2>
                        </div>
                        <div class="col-12 col-md-auto col-xl-2 ml-auto text-md-right" data-aos="fade-up">
                            <a class="our-services__more arrow-link--white arrow-link" href="{{ route('services') }}">
                                <span class="arrow-link__text">View all</span>
                                <span class="arrow-link__icon">
                                    <svg width="75" height="75">
                                        <use xlink:href="#link-arrow"></use>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </header>
                <div class="our-services__accordion accordion">
                    @forelse ($layanans as $layanan)
                        <div class="accordion__item" data-aos="fade-up">
                            <button class="accordion__item-header" type="button">
                                <span class="row align-items-md-center">
                                    <span class="accordion__item-title col-11 col-md-6">{{ $layanan->judul }}</span>
                                    <span
                                        class="accordion__item-short col-11 col-md-5">{{ \Illuminate\Support\Str::limit(strip_tags($layanan->deskripsi), 150) }}</span>
                                </span>
                            </button>
                            <div class="accordion__item-body">
                                <div class="row">
                                    <div class="accordion__item-left col-12 col-md-6">
                                        @if ($layanan->gambar)
                                            <img src="{{ asset('storage/layanan/' . $layanan->gambar) }}" width="810"
                                                height="530" alt="{{ $layanan->judul }}"
                                                onerror="this.src='{{ asset('web') }}/img/picture/mono/accordion-large.jpg'">
                                        @else
                                            <img src="{{ asset('web') }}/img/picture/mono/accordion-large.jpg"
                                                width="810" height="530" alt="{{ $layanan->judul }}">
                                        @endif
                                    </div>
                                    <div class="accordion__item-right col-12 col-md-6">
                                        @php
                                            $galeriTerbaru = $layanan->galeris->sortByDesc('created_at')->first();
                                        @endphp
                                        @if ($galeriTerbaru && $galeriTerbaru->gambar)
                                            <img src="{{ asset('upload/galeri/' . $galeriTerbaru->gambar) }}"
                                                width="348" height="287"
                                                alt="{{ $galeriTerbaru->judul_galeri ?? 'Galeri' }}"
                                                onerror="this.src='{{ asset('web') }}/img/picture/mono/accordion-small.jpg'">
                                        @else
                                            <img src="{{ asset('web') }}/img/picture/mono/accordion-small.jpg"
                                                width="348" height="287" alt="Default">
                                        @endif
                                        <div class="accordion__item-text">
                                            @if ($galeriTerbaru && $galeriTerbaru->keterangan)
                                                {{ $galeriTerbaru->keterangan }}
                                            @else
                                                {{ \Illuminate\Support\Str::limit($layanan->deskripsi, 200) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <p>Belum ada layanan yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="main-screen">
            <div class="main-screen__image __js_parallax">
                <img src="{{ asset('upload/beranda/' . $beranda->gambar_sekunder) }}" width="1920" height="1080"
                    alt="">
            </div>
            <div class="main-screen__container container container--size-large">
                <h1 class="main-screen__title">
                    <span>{{ $beranda->judul_sekunder }}</span>{{ $beranda->keterangan }}
                </h1>
                <a class="main-screen__btn btn" href="">
                    <span class="btn__text">CTA</span>
                    <span class="btn__icon">
                        <svg width="19" height="19">
                            <use xlink:href="#link-arrow"></use>
                        </svg>
                    </span>
                </a>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".testimonial-swiper", {
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            slidesPerView: 1,
            spaceBetween: 30,
        });
    </script>
@endsection
