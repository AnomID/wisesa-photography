@extends('template_web.layout')
@section('style')
@endsection
@section('content')
    <main>
        <article class="blog-grid blog-grid--masonry">
            <div class="blog-grid__container container container--size-large">
                <h1 class="heading heading--size-large blog-grid__title">Galeri</h1>
                <!-- Filter news-->
                <div class="filter blog-grid__filter">
                    <button class="filter__item filter__item--active __js_filter-btn" type="button"
                        data-filter="*">Semua</button>
                    @foreach ($layanans as $layanan)
                        <button class="filter__item __js_filter-btn" type="button"
                            data-filter=".__js_layanan_{{ $layanan->id }}">
                            {{ $layanan->judul }}
                        </button>
                    @endforeach
                </div>
                <ul class="blog-grid__row row g-0 __js_blog-grid">
                    @php
                        $cardLayouts = [
                            'col-12 col-md-6 col-lg-4',
                            'col-12 col-md-6 col-lg-4',
                            'col-12 col-md-6 col-lg-4 news-card--vertical',
                            'col-12 col-md-6 col-lg-4 news-card--vertical',
                            'col-12 col-md-6 col-lg-4',
                            'col-12 col-md-6 col-lg-8',
                        ];
                        $layoutIndex = 0;
                    @endphp

                    @forelse($galeris as $galeri)
                        @php
                            $currentLayout = $cardLayouts[$layoutIndex % count($cardLayouts)];
                            $layoutIndex++;
                            $isVertical = strpos($currentLayout, 'vertical') !== false;
                        @endphp
                        <li
                            class="blog-grid__card news-card {{ $currentLayout }} __js_masonry-item __js_layanan_{{ $galeri->layanan_id }}">
                            <div class="news-card__wrapper">
                                <div class="news-card__pic">
                                    @if ($galeri->gambar)
                                        <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}"
                                            @if (!$isVertical) width="533" height="510" @endif
                                            alt="{{ $galeri->judul_galeri ?? $galeri->keterangan }}" />
                                    @else
                                        <img src="{{ asset('web') }}/img/picture/news/blog-1.jpg"
                                            @if (!$isVertical) width="533" height="510" @endif
                                            alt="No Image" />
                                    @endif
                                </div>
                                <div class="news-card__content">
                                    <div class="news-card__top">
                                        <div class="news-card__date">
                                            <span>{{ $galeri->created_at->format('d') }}</span>
                                            <span>&nbsp;</span>
                                            <span>{{ $galeri->created_at->format('M') }}</span>
                                            <span>,&nbsp;</span>
                                            <span>{{ $galeri->created_at->format('Y') }}</span>
                                            <span>&nbsp;/&nbsp;</span>
                                            <span>{{ $galeri->layanan->judul ?? 'Tidak ada layanan' }}</span>
                                        </div>
                                        <div class="news-card__title">
                                            {{ $galeri->judul_galeri ?? 'Galeri' }}
                                        </div>
                                    </div>
                                    <div class="news-card__bottom">
                                        <div class="news-card__text">
                                            {{ Str::limit($galeri->keterangan, 120) }}
                                        </div>
                                        <a class="arrow-link--no-scale arrow-link"
                                            href="{{ route('gallery.detail', $galeri->slug) }}">
                                            <span class="arrow-link__icon">
                                                <svg width="75" height="75">
                                                    <use xlink:href="#link-arrow"></use>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada galeri yang tersedia</p>
                        </li>
                    @endforelse
                </ul>
                <a class="blog-grid__more circle-link" href="#">
                    <svg width="30" height="32" style="transform: rotate(180deg);">
                        <use xlink:href="#arrow-down"></use>
                    </svg>
                </a>
            </div>
        </article>
    </main>
@endsection

@section('script')
@endsection
