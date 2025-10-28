@extends('template_web.layout')
@section('style')
@endsection
@section('content')
    <main>
        <article class="blog-grid blog-grid--post">
            <div class="blog-grid__first-screen">
                <div class="blog-grid__first-screen-image __js_parallax">
                    @if ($galeri->gambar)
                        <img src="{{ asset('upload/galeri/' . $galeri->gambar) }}" width="1920" height="1099"
                            alt="{{ $galeri->judul_galeri }}">
                    @else
                        <img src="{{ asset('web') }}/img/picture/news/banner-blog-1.jpg" width="1920" height="1099"
                            alt="">
                    @endif
                </div>
            </div>
            <div class="single-post">
                <div class="container container--xsmall">
                    <div class="single-post__date" data-aos="fade-up">
                        {{ $galeri->created_at->format('F d, Y') }}
                    </div>
                    <div class="single-post__title" data-aos="fade-up">
                        {{ $galeri->judul_galeri }}
                    </div>
                    <div class="single-post__text" data-aos="fade-up">
                        {!! $galeri->keterangan !!}
                    </div>
                </div>

                @php
                    $listGallery = $galeri->list_gallery ?? [];
                    if (is_string($listGallery)) {
                        $listGallery = json_decode($listGallery, true) ?? [];
                    }

                    $galleryItems = collect($listGallery)
                        ->filter(function ($item) {
                            if (is_array($item)) {
                                return isset($item['gambar']) && !empty($item['gambar']);
                            }
                            return is_string($item) && !empty($item);
                        })
                        ->values();

                    $layouts = [
                        ['size' => 'small', 'ratio' => 'ratio-3-2'],
                        ['size' => 'small', 'ratio' => 'ratio-4-3'],
                        ['size' => 'medium', 'ratio' => 'ratio-3-2'],
                        ['size' => 'large', 'ratio' => 'ratio-3-2'],
                        ['size' => 'small', 'ratio' => 'ratio-4-3'],
                        ['size' => 'medium', 'ratio' => 'ratio-4-3'],
                        ['size' => 'large', 'ratio' => 'ratio-4-3'],
                        ['size' => 'small', 'ratio' => 'ratio-3-2'],
                        ['size' => 'medium', 'ratio' => 'ratio-3-2'],
                        ['size' => 'small', 'ratio' => 'ratio-4-3'],
                        ['size' => 'large', 'ratio' => 'ratio-3-2'],
                        ['size' => 'small', 'ratio' => 'ratio-4-3'],
                    ];
                @endphp
                @if ($galleryItems->count() > 0)
                    <div class="container container--small">
                        <div class="single-post__gallery">
                            @foreach ($galleryItems as $index => $item)
                                @php
                                    $gambar = is_array($item) ? $item['gambar'] : $item;
                                    $judul = is_array($item)
                                        ? $item['judul_galeri'] ?? $galeri->judul_galeri
                                        : $galeri->judul_galeri;

                                    $seed = $index;
                                    $seed = ($seed * 1103515245 + 12345) % (count($layouts) * 7);
                                    $fib = [0, 1, 1, 2, 3, 5, 8, 13];
                                    $fibIndex = $index % count($fib);
                                    $seed = ($seed + $fib[$fibIndex] * 3) % count($layouts);
                                    $primes = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29];
                                    $primeRotate = $primes[$index % count($primes)];
                                    $seed = ($seed + $primeRotate * ($index % 5)) % count($layouts);
                                    $seed = $seed ^ ($index >> 2) % count($layouts);
                                    $seed = ($seed + $index * 7) % count($layouts);
                                    $finalIndex = abs($seed) % count($layouts);

                                    $layout = $layouts[$finalIndex];
                                    $size = $layout['size'];
                                    $ratio = $layout['ratio'];

                                    $sizeClass = 'gallery-item-' . $size;
                                    $ratioClass = $ratio;
                                @endphp
                                <div class="gallery-img-wrapper {{ $sizeClass }} {{ $ratioClass }}" data-aos="fade-up"
                                    data-aos-delay="{{ $index * 50 }}">
                                    <img src="{{ asset('upload/galeri/' . $gambar) }}" alt="{{ $judul }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </article>
    </main>
@endsection

@section('script')
@endsection
