@extends('template_web.layout')
@section('style')
@endsection
@section('content')
    <main>
        <article class="service-detail">
            <div class="first-banner">
                <div class="first-banner__image">
                    <img src="{{ asset('web') }}/img/picture/first-banner/banner-service.jpg" width="1920" height="1100"
                        alt="" />
                </div>
                <div class="container container--size-large">
                    <h1 class="first-banner__title heading heading--size-large">Design</h1>
                </div>
            </div>
            <section class="carousel-section service-detail__carousel">
                <div class="container">
                    <header class="carousel-section__header row align-items-end align-items-md-center">
                        <h2 class="carousel-section__title col-12 col-md-10" data-aos="fade-up">WORKS</h2>
                        <div class="carousel-section__nav col-12 col-md-2 order-last order-md-0" data-aos="fade-up">
                            <button class="nav-btn nav-btn--prev __js_navbtn-latest-projects"
                                data-target=".__js_carousel-latest-projects" type="button">
                                <svg width="50" height="16">
                                    <use xlink:href="#long-arrow-left"></use>
                                </svg>
                            </button>
                            <button class="nav-btn nav-btn--next __js_navbtn-latest-projects"
                                data-target=".__js_carousel-latest-projects" type="button">
                                <svg width="50" height="16">
                                    <use xlink:href="#long-arrow-right"></use>
                                </svg>
                            </button>
                        </div>
                    </header>
                </div>
                <div class="container container--size-large">
                    <div class="carousel-section__carousel carousel carousel--slide-auto swiper-container __js_carousel-latest-projects"
                        data-aos="fade-up">
                        <div class="swiper-wrapper">
                            <a class="carousel__item project-preview swiper-slide" href="single-project.html">
                                <span class="project-preview__image">
                                    <img src="{{ asset('web') }}/img/picture/carousel/8.jpg" width="720" height="548"
                                        alt="swiss typography">
                                </span>
                                <span class="project-preview__bottom">
                                    <span class="project-preview__title">Swiss typography</span>
                                    <span class="project-preview__icon">
                                        <svg width="24" height="23">
                                            <use xlink:href="#link-arrow2"></use>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                            <a class="carousel__item project-preview swiper-slide" href="single-project.html">
                                <span class="project-preview__image">
                                    <img src="{{ asset('web') }}/img/picture/carousel/9.jpg" width="334" height="255"
                                        alt="the act">
                                </span>
                                <span class="project-preview__bottom">
                                    <span class="project-preview__title">The act</span>
                                    <span class="project-preview__icon">
                                        <svg width="24" height="23">
                                            <use xlink:href="#link-arrow2"></use>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                            <a class="carousel__item project-preview swiper-slide" href="single-project.html">
                                <span class="project-preview__image">
                                    <img src="{{ asset('web') }}/img/picture/carousel/10.jpg" width="404" height="494"
                                        alt="Copenhagen">
                                </span>
                                <span class="project-preview__bottom">
                                    <span class="project-preview__title">Copenhagen</span>
                                    <span class="project-preview__icon">
                                        <svg width="24" height="23">
                                            <use xlink:href="#link-arrow2"></use>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                            <a class="carousel__item project-preview swiper-slide" href="single-project.html">
                                <span class="project-preview__image">
                                    <img src="{{ asset('web') }}/img/picture/carousel/11.jpg" width="434" height="321"
                                        alt="Mobile app">
                                </span>
                                <span class="project-preview__bottom">
                                    <span class="project-preview__title">Mobile app</span>
                                    <span class="project-preview__icon">
                                        <svg width="24" height="23">
                                            <use xlink:href="#link-arrow2"></use>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <div class="container container--small service-detail__container">
                <div class="service-detail__title" data-aos="fade-up">Process</div>
                <div class="service-detail__accordion accordion accordion--black">
                    <div class="accordion__item" data-aos="fade-up">
                        <button class="accordion__item-header" type="button">
                            <span class="row align-items-md-center">
                                <span class="accordion__item-title col-11 col-md-6">
                                    <span>01.</span> Planing
                                </span>
                            </span>
                        </button>
                        <div class="accordion__item-body">
                            <div class="row">
                                <div class="accordion__item-left col-12 col-md-7">
                                    <div class="accordion__item-text">Alienum phaedrum torquatos nec eu, detr periculis ex,
                                        nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est. Eos ei nisl
                                        graecis, vix aperiri consequat an. Eius lorem tincidunt vix at, vel pertinax
                                        sensibus id, error epicurei mea et. Mea facilisis urbanitas moderatius id. Vis ei
                                        rationibus definiebas.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__item" data-aos="fade-up">
                        <button class="accordion__item-header" type="button">
                            <span class="row align-items-md-center">
                                <span class="accordion__item-title col-11 col-md-6">
                                    <span>02.</span> Design
                                </span>
                            </span>
                        </button>
                        <div class="accordion__item-body">
                            <div class="row">
                                <div class="accordion__item-left col-12 col-md-7">
                                    <div class="accordion__item-text">Alienum phaedrum torquatos nec eu, detr periculis ex,
                                        nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est. Eos ei nisl
                                        graecis, vix aperiri consequat an. Eius lorem tincidunt vix at, vel pertinax
                                        sensibus id, error epicurei mea et. Mea facilisis urbanitas moderatius id. Vis ei
                                        rationibus definiebas.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__item" data-aos="fade-up">
                        <button class="accordion__item-header" type="button">
                            <span class="row align-items-md-center">
                                <span class="accordion__item-title col-11 col-md-6">
                                    <span>03.</span> Concept
                                </span>
                            </span>
                        </button>
                        <div class="accordion__item-body">
                            <div class="row">
                                <div class="accordion__item-left col-12 col-md-7">
                                    <div class="accordion__item-text">Alienum phaedrum torquatos nec eu, detr periculis ex,
                                        nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est. Eos ei nisl
                                        graecis, vix aperiri consequat an. Eius lorem tincidunt vix at, vel pertinax
                                        sensibus id, error epicurei mea et. Mea facilisis urbanitas moderatius id. Vis ei
                                        rationibus definiebas.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__item" data-aos="fade-up">
                        <button class="accordion__item-header" type="button">
                            <span class="row align-items-md-center">
                                <span class="accordion__item-title col-11 col-md-6">
                                    <span>04.</span> Coding
                                </span>
                            </span>
                        </button>
                        <div class="accordion__item-body">
                            <div class="row">
                                <div class="accordion__item-left col-12 col-md-7">
                                    <div class="accordion__item-text">Alienum phaedrum torquatos nec eu, detr periculis ex,
                                        nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est. Eos ei nisl
                                        graecis, vix aperiri consequat an. Eius lorem tincidunt vix at, vel pertinax
                                        sensibus id, error epicurei mea et. Mea facilisis urbanitas moderatius id. Vis ei
                                        rationibus definiebas.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__item" data-aos="fade-up">
                        <button class="accordion__item-header" type="button">
                            <span class="row align-items-md-center">
                                <span class="accordion__item-title col-11 col-md-6">
                                    <span>05.</span> CMS
                                </span>
                            </span>
                        </button>
                        <div class="accordion__item-body">
                            <div class="row">
                                <div class="accordion__item-left col-12 col-md-7">
                                    <div class="accordion__item-text">Alienum phaedrum torquatos nec eu, detr periculis ex,
                                        nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est. Eos ei nisl
                                        graecis, vix aperiri consequat an. Eius lorem tincidunt vix at, vel pertinax
                                        sensibus id, error epicurei mea et. Mea facilisis urbanitas moderatius id. Vis ei
                                        rationibus definiebas.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__item" data-aos="fade-up">
                        <button class="accordion__item-header" type="button">
                            <span class="row align-items-md-center">
                                <span class="accordion__item-title col-11 col-md-6">
                                    <span>06.</span> End
                                </span>
                            </span>
                        </button>
                        <div class="accordion__item-body">
                            <div class="row">
                                <div class="accordion__item-left col-12 col-md-7">
                                    <div class="accordion__item-text">Alienum phaedrum torquatos nec eu, detr periculis ex,
                                        nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est. Eos ei nisl
                                        graecis, vix aperiri consequat an. Eius lorem tincidunt vix at, vel pertinax
                                        sensibus id, error epicurei mea et. Mea facilisis urbanitas moderatius id. Vis ei
                                        rationibus definiebas.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
@endsection

@section('script')
@endsection
