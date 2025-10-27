@extends('template_web.layout')
@section('style')
@endsection
@section('content')
    <main>
        <article class="about-us">
            <div class="first-banner about-us__banner">
                <div class="first-banner__image">
                    <img src="{{ asset('upload/beranda/' . ($beranda->gambar_sekunder ?? 'default.jpg')) }}" width="1920"
                        height="1100" alt="{{ $beranda->judul_utama ?? 'Banner' }}" />
                </div>
                <div class="container container--size-large">
                    <h1 class="first-banner__title heading heading--size-large">{{ $beranda->judul_sekunder ?? 'We create' }}
                        <br>
                        <span>{{ $beranda->keterangan ?? 'digital products' }}</span>
                    </h1>
                </div>
            </div>
            <section class="about-video-section about-video-section--pt-50">
                <div class="about-video-section__container container container--size-large">
                    <div class="row">
                        <div class="about-video-section__main col-12 col-md">
                            <div class="about-video-section__title about-video-section__title--size-large"
                                data-aos="fade-up">
                                {{ $tentang->judul ?? 'Our team consists of practitioners who have 15 years of experience in launching and managing projects' }}
                            </div>
                            <div class="row align-items-end" data-aos="fade-up">
                                <div class="col-4 col-md-5 col-xl-4">
                                    <a class="about-video-section__more arrow-link" href="about-us.html">
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
                                <img src="{{ asset('upload/tentang/' . ($tentang->gambar ?? 'default.jpg')) }}"
                                    width="810" height="539" alt="About us video">
                            </div>
                        </div>
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
                                <a class="our-services__more arrow-link--white arrow-link" href="services.html">
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

    </main>
@endsection

@section('script')
@endsection
