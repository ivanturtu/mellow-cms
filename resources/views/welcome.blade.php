@extends('layouts.public')

@section('content')
    <!-- Slider Section -->
    @if($sliders->count() > 0)
        <section id="slider" data-aos="fade-up">
            <div class="container-fluid padding-side">
                <div class="swiper main-swiper">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)
                            <div class="swiper-slide">
                                <div class="d-flex rounded-5"
                                    style="background-image: url({{ asset($slider->image) }}); background-size: cover; background-repeat: no-repeat; height: 85vh; background-position: center;">
                                    <div class="row align-items-center m-auto pt-5 px-4 px-lg-0">
                                        <div class="text-start col-md-6 col-lg-5 col-xl-6 offset-lg-1">
                                            <h2 class="display-1 fw-normal">{{ $slider->title }}</h2>
                                            @if($slider->description)
                                                <p class="lead text-white mt-3">{{ $slider->description }}</p>
                                            @endif
                                            @if($slider->cta_text)
                                                <a href="{{ $slider->cta_link ?? '#rooms' }}" class="btn btn-arrow btn-primary mt-3">
                                                    <span>{{ $slider->cta_text }} <svg width="18" height="18">
                                                            <use xlink:href="#arrow-right"></use>
                                                        </svg></span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-lg-5 col-xl-4 mt-5 mt-md-0">
                                            <form id="form" class="form-group flex-wrap bg-white p-5 rounded-4 ms-md-5">
                                                <h3 class="display-5">Check availability</h3>
                                                <div class="col-lg-12 my-4">
                                                    <label class="form-label text-uppercase">Check-In</label>
                                                    <div class="date position-relative bg-transparent" id="select-arrival-date">
                                                        <a href="#" class="position-absolute top-50 end-0 translate-middle-y pe-2 ">
                                                            <svg class="text-body" width="25" height="25">
                                                                <use xlink:href="#calendar"></use>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 my-4">
                                                    <label class="form-label text-uppercase">Check-Out</label>
                                                    <div class="date position-relative bg-transparent" id="select-departure-date">
                                                        <a href="#" class="position-absolute top-50 end-0 translate-middle-y pe-2 ">
                                                            <svg class="text-body" width="25" height="25">
                                                                <use xlink:href="#calendar"></use>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 my-4">
                                                    <label class="form-label text-uppercase">Rooms</label>
                                                    <input type="number" value="1" name="quantity" class="form-control text-black-50 ps-3">
                                                </div>
                                                <div class="col-lg-12 my-4">
                                                    <label class="form-label text-uppercase">Guests</label>
                                                    <input type="number" value="1" name="quantity" class="form-control text-black-50 ps-3">
                                                </div>
                                                <div class="d-grid">
                                                    <button href="#" class="btn btn-arrow btn-primary mt-3">
                                                        <span>Check availability<svg width="18" height="18">
                                                                <use xlink:href="#arrow-right"></use>
                                                            </svg></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination main-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    <!-- About Section -->
    <section id="about-us" class="padding-large">
        <div class="container-fluid padding-side" data-aos="fade-up">
            <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">{{ $settings['general']['hotel_name'] ?? 'Hotel Mellow' }}: {{ $settings['general']['hotel_description'] ?? 'Your Gateway to Serenity' }}</h3>
            <div class="row align-items-start mt-3 mt-lg-5">
                <div class="col-lg-6">
                    <div class="p-5">
                        <p>Benvenuti a {{ $settings['general']['hotel_name'] ?? 'Hotel Mellow' }}, dove il comfort incontra la tranquillità. Situato nel cuore della città, il nostro hotel offre un rifugio pacifico per viaggiatori d'affari e di piacere.</p>
                        <p>Con {{ $rooms->count() }} camere eleganti, servizi di lusso e un team dedicato, garantiamo un'esperienza indimenticabile per ogni nostro ospite.</p>
                        <a href="#rooms" class="btn btn-arrow btn-primary mt-3">
                            <span>Scopri di più <svg width="18" height="18">
                                    <use xlink:href="#arrow-right"></use>
                                </svg></span>
                        </a>
                    </div>
                    <img src="{{ asset('mellow/images/about-img1.jpg') }}" alt="img" class="img-fluid rounded-4 mt-4">
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="{{ asset('mellow/images/about-img2.jpg') }}" alt="img" class="img-fluid rounded-4">
                    <img src="{{ asset('mellow/images/about-img3.jpg') }}" alt="img" class="img-fluid rounded-4 mt-4">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="info">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-3 text-center mb-4 mb-lg-0">
                    <h3 class="display-1 fw-normal text-primary position-relative">25K <span
                            class="position-absolute top-50 end-50 translate-middle z-n1 ps-lg-4 pt-lg-4"><img
                                src="{{ asset('mellow/images/pattern1.png') }}" alt="pattern" class="img-fluid"></span></h3>
                    <p class="text-capitalize">Clienti Soddisfatti</p>
                </div>
                <div class="col-md-3 text-center mb-4 mb-lg-0">
                    <h3 class="display-1 fw-normal text-primary position-relative">{{ $rooms->count() }} <span
                            class="position-absolute top-50 translate-middle z-n1"><img src="{{ asset('mellow/images/pattern1.png') }}" alt="pattern"
                                class="img-fluid"></span></h3>
                    <p class="text-capitalize">Camere Totali</p>
                </div>
                <div class="col-md-3 text-center mb-4 mb-lg-0">
                    <h3 class="display-1 fw-normal text-primary position-relative">25 <span
                            class="position-absolute top-100 pb-5 translate-middle z-n1"><img src="{{ asset('mellow/images/pattern1.png') }}" alt="pattern"
                                class="img-fluid"></span></h3>
                    <p class="text-capitalize">Premi vinti</p>
                </div>
                <div class="col-md-3 text-center mb-4 mb-lg-0">
                    <h3 class="display-1 fw-normal text-primary position-relative">200 <span
                            class="position-absolute top-50 end-50 pb-lg-4 pe-lg-2 translate-middle z-n1"><img
                                src="{{ asset('mellow/images/pattern1.png') }}" alt="pattern" class="img-fluid"></span></h3>
                    <p class="text-capitalize">Membri Totali</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    @if($rooms->count() > 0)
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Esplora le nostre camere</h3>
                    </div>
                    <a href="#rooms" class="btn btn-arrow btn-primary mt-3">
                        <span>Esplora camere<svg width="18" height="18">
                                <use xlink:href="#arrow-right"></use>
                            </svg></span>
                    </a>
                </div>

                <div class="swiper room-swiper mt-5">
                    <div class="swiper-wrapper">
                        @foreach($rooms as $room)
                            <div class="swiper-slide">
                                <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                                    <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="post-image img-fluid rounded-4">
                                    <div class="product-description position-absolute p-5 text-start">
                                        <h4 class="display-6 fw-normal text-white">{{ $room->name }}</h4>
                                        <p class="product-paragraph text-white">{{ $room->description }}</p>
                                        <table>
                                            <tbody>
                                                <tr class="text-white">
                                                    <td class="pe-2">Prezzo:</td>
                                                    <td class="price">€{{ $room->price }} /Notte</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Dimensione:</td>
                                                    <td>{{ $room->size }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Capacità:</td>
                                                    <td>Max {{ $room->capacity }} persone</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Letto:</td>
                                                    <td>{{ $room->bed_type }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Servizi:</td>
                                                    <td>{{ $room->services }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a href="#rooms">
                                            <p class="text-decoration-underline text-white m-0 mt-2">Sfoglia Ora</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="room-content text-center mt-3">
                                    <h4 class="display-6 fw-normal"><a href="#rooms">{{ $room->name }}</a></h4>
                                    <p><span class="text-primary fs-4">€{{ $room->price }}</span>/notte</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination room-pagination position-relative mt-5"></div>
                </div>
            </div>
        </section>
    @endif

        <!-- Gallery Section -->
        @if($gallery->count() > 0)
            <section id="gallery" data-aos="fade-up">
                <h3 class="display-3 fw-normal text-center">la nostra gallery</h3>
                <p class="text-center col-lg-4 offset-lg-4 mb-5">Esplora le immagini delle nostre sistemazioni ben arredate, con servizi moderni e arredamento elegante progettato per rendere il vostro soggiorno indimenticabile.</p>
                <div class="container position-relative">
                    <div class="row">
                        <div class="swiper gallery-swiper offset-1 col-10">
                            <div class="swiper-wrapper">
                                @foreach($gallery as $item)
                                    <div class="swiper-slide">
                                        <div class="position-relative">
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="img-fluid rounded-4">
                                            @if($item->title)
                                                <div class="position-absolute bottom-0 start-0 p-3">
                                                    <h5 class="text-white mb-1">{{ $item->title }}</h5>
                                                    @if($item->description)
                                                        <p class="text-white-50 small mb-0">{{ $item->description }}</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-50 start-0 translate-middle-y gallery-button-prev d-none d-md-block">
                        <svg class="bg-secondary rounded-circle p-3" width="70" height="70">
                            <use xlink:href="#arrow-left"></use>
                        </svg>
                    </div>
                    <div class="position-absolute top-50 end-0 translate-middle-y gallery-button-next d-none d-md-block">
                        <svg class="bg-secondary rounded-circle p-3" width="70" height="70">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </div>
                    <div class="position-absolute top-100 end-50 translate-middle gallery-button-prev mt-5 d-md-none d-block">
                        <svg class="bg-secondary rounded-circle p-2" width="50" height="50">
                            <use xlink:href="#arrow-left"></use>
                        </svg>
                    </div>
                    <div class="position-absolute top-100 start-50 translate-middle gallery-button-next mt-5 ms-4 d-md-none d-block">
                        <svg class="bg-secondary rounded-circle p-2" width="50" height="50">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </div>
                </div>
            </section>
        @endif

    <!-- Services Section -->
    @if($services->count() > 0)
        <section id="services" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">I nostri servizi e strutture</h3>
                <div class="row mt-5">
                    @foreach($services as $service)
                        <div class="col-md-6 col-xl-4">
                            <div class="service mb-4 text-center rounded-4 p-5">
                                <div class="position-relative">
                                    @if($service->icon)
                                        <svg class="color" width="70" height="70">
                                            <use xlink:href="#{{ $service->icon }}"></use>
                                        </svg>
                                    @endif
                                    <img src="{{ asset('mellow/images/pattern2.png') }}" alt="img"
                                        class="position-absolute top-100 start-50 translate-middle z-n1 pe-5">
                                </div>
                                <h4 class="display-6 fw-normal my-3">{{ $service->name }}</h4>
                                <p>{{ $service->description }}</p>
                                <a href="#services" class="btn btn-arrow">
                                    <span class="text-decoration-underline">Leggi di più<svg width="18" height="18">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg></span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

        <!-- Blog Section -->
        @if($blogs->count() > 0)
            <section id="blog" class="padding-medium pt-0">
                <div class="container-fluid padding-side" data-aos="fade-up">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <h3 class="display-3 fw-normal text-center">I nostri blog ed eventi</h3>
                        </div>
                        <a href="#blog" class="btn btn-arrow btn-primary mt-3">
                            <span>Altri Blog<svg width="18" height="18">
                                    <use xlink:href="#arrow-right"></use>
                                </svg></span>
                        </a>
                    </div>
                    <div class="row mt-5">
                        @foreach($blogs as $index => $blog)
                            @if($index < 3)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="blog-post position-relative overflow-hidden rounded-4">
                                        <img src="{{ asset($blog->image) }}" class="blog-img img-fluid rounded-4" alt="{{ $blog->title }}">
                                        <div class="position-absolute bottom-0 p-5">
                                            <a href="#"><span class="bg-secondary text-body m-0 px-2 py-1 rounded-2 fs-6">{{ $blog->category ?? 'Blog' }}</span></a>
                                            <h4 class="display-6 fw-normal mt-2"><a href="#blog">{{ $blog->title }}</a></h4>
                                            @if($blog->excerpt)
                                                <p class="text-white-50 small mt-2">{{ Str::limit($blog->excerpt, 80) }}</p>
                                            @endif
                                            <p class="m-0 align-items-center text-white-50"><svg width="19" height="19">
                                                    <use xlink:href="#clock"></use>
                                                </svg> {{ $blog->published_at->format('d M, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endsection
