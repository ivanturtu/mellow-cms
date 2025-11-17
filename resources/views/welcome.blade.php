@extends('layouts.public')

@section('content')
    <!-- Slider Section -->
    @if($sliders->count() > 0)
        <section id="slider" data-aos="fade-up">
                    <div class="container-fluid padding-side">
                        <div class="swiper slider rounded-5">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)
                            <div class="swiper-slide">
                                <div class="d-flex slider-slide"
                                    style="background-image: url({{ $slider->getOptimizedImageUrl('lg') }}); background-size: cover; background-repeat: no-repeat; height: 85vh; background-position: center;"
                                    data-srcset="{{ $slider->getResponsiveSrcset() }}">
                                    <!-- Overlay for better text readability -->
                                    <div class="slider-overlay"></div>
                                            <div class="row align-items-center pt-5 ps-5">
                                                <div class="text-start col-md-6 col-lg-5 col-xl-6">
                                            <h2 class="display-1 fw-normal">{{ $slider->title }}</h2>
                                            @if($slider->description)
                                                <p class="lead text-white mt-3">{{ $slider->description }}</p>
                                            @endif
                                            @if($slider->cta_text)
                                                <a href="{{ $slider->cta_link ?? '#rooms' }}" 
                                                   class="btn btn-arrow btn-primary mt-3"
                                                   @if(str_starts_with($slider->cta_link ?? '', '#')) 
                                                       data-bs-toggle="smooth-scroll"
                                                   @endif>
                                                    <span>{{ $slider->cta_text }} <svg width="18" height="18">
                                                            <use xlink:href="#arrow-right"></use>
                                                        </svg></span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                
                <!-- Fixed Booking Form -->
                <div class="fixed-booking-form d-none d-lg-block">
                    <form id="check_available" class="form-group flex-wrap bg-white p-3 rounded-4 shadow-lg">
                        <h3 class="h4 mb-3">Check availability</h3>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label text-uppercase small">Check-In</label>
                            <input type="date" class="form-control form-control-sm text-black-50 ps-2" id="checkin-date" name="checkin_date" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label text-uppercase small">Check-Out</label>
                            <input type="date" class="form-control form-control-sm text-black-50 ps-2" id="checkout-date" name="checkout_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label text-uppercase small">Rooms</label>
                            <input type="number" value="1" name="rooms" class="form-control form-control-sm text-black-50 ps-2" min="1">
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label text-uppercase small">Guests</label>
                            <input type="number" value="1" name="guests" class="form-control form-control-sm text-black-50 ps-2" min="1">
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label text-uppercase small">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-sm text-black-50 ps-2" placeholder="La tua email" required>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label text-uppercase small">Telefono (opzionale)</label>
                            <input type="tel" name="phone" class="form-control form-control-sm text-black-50 ps-2" placeholder="Il tuo telefono">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-arrow btn-primary mt-2">
                                <span>Send<svg width="18" height="18">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    @endif

    <!-- Mobile Booking Button - Fixed position -->
    <div class="mobile-booking-trigger d-lg-none">
        <button class="btn btn-primary rounded-circle shadow-lg" id="mobileBookingBtn" title="Check Availability">
            <i class="fas fa-calendar-check"></i>
        </button>
    </div>

    <!-- Mobile Booking Form - Hidden slide-in panel -->
    <div class="mobile-booking-panel d-lg-none" id="mobileBookingPanel">
        <div class="mobile-booking-overlay" id="mobileBookingOverlay"></div>
        <div class="mobile-booking-content">
            <div class="mobile-booking-header">
                <h4 class="h5 mb-0">Check Availability</h4>
                <button class="btn-close" id="mobileBookingClose"></button>
            </div>
            <form id="check_available_mobile" class="mobile-booking-form">
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label text-uppercase small mb-1">Check-In</label>
                        <input type="date" class="form-control form-control-sm" id="checkin-date-mobile" name="checkin_date" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-uppercase small mb-1">Check-Out</label>
                        <input type="date" class="form-control form-control-sm" id="checkout-date-mobile" name="checkout_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-uppercase small mb-1">Rooms</label>
                        <input type="number" value="1" name="rooms" class="form-control form-control-sm" min="1">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-uppercase small mb-1">Guests</label>
                        <input type="number" value="1" name="guests" class="form-control form-control-sm" min="1">
                    </div>
                    <div class="col-12">
                        <label class="form-label text-uppercase small mb-1">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="La tua email" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            Send
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- About Section -->
    @if($aboutSection)
        <section id="about-us" class="padding-large">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">
                    {{ $aboutSection->title }}
                    @if($aboutSection->subtitle)
                        <br><small class="text-muted">{{ $aboutSection->subtitle }}</small>
                    @endif
                </h3>
                <div class="row align-items-start mt-3 mt-lg-5">
                    <div class="col-lg-6">
                        <div class="p-5">
                            @if($aboutSection->description)
                                <div id="about-description" data-full-text="{{ htmlspecialchars($aboutSection->description, ENT_QUOTES, 'UTF-8') }}">{!! $aboutSection->description !!}</div>
                            @else
                                <div id="about-description" data-full-text=""></div>
                            @endif
                            @if($aboutSection->cta_text)
                                <a href="{{ $aboutSection->cta_link ?? '#rooms' }}" class="btn btn-arrow btn-primary mt-3"
                                   @if(str_starts_with($aboutSection->cta_link ?? '', '#'))
                                       data-bs-toggle="smooth-scroll"
                                   @endif>
                                    <span>{{ $aboutSection->cta_text }} <svg width="18" height="18">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg></span>
                                </a>
                            @endif
                        </div>
                        @if($aboutSection->image_1)
                            <img src="{{ $aboutSection->getOptimizedImageUrl('image_1', 'lg') }}" 
                                 alt="{{ $aboutSection->title }}" 
                                 class="img-fluid rounded-4 mt-4"
                                 srcset="{{ $aboutSection->getResponsiveSrcset('image_1') }}"
                                 sizes="(max-width: 768px) 100vw, 50vw">
                        @else
                            <img src="{{ asset('mellow/images/about-img1.jpg') }}" alt="img" class="img-fluid rounded-4 mt-4">
                        @endif
                    </div>
                    <div class="col-lg-6 mt-5 mt-lg-0">
                        @if($aboutSection->image_2)
                            <img src="{{ $aboutSection->getOptimizedImageUrl('image_2', 'lg') }}" 
                                 alt="{{ $aboutSection->title }}" 
                                 class="img-fluid rounded-4"
                                 srcset="{{ $aboutSection->getResponsiveSrcset('image_2') }}"
                                 sizes="(max-width: 768px) 100vw, 50vw">
                        @else
                            <img src="{{ asset('mellow/images/about-img2.jpg') }}" alt="img" class="img-fluid rounded-4">
                        @endif
                        @if($aboutSection->image_3)
                            <img src="{{ $aboutSection->getOptimizedImageUrl('image_3', 'lg') }}" 
                                 alt="{{ $aboutSection->title }}" 
                                 class="img-fluid rounded-4 mt-4"
                                 srcset="{{ $aboutSection->getResponsiveSrcset('image_3') }}"
                                 sizes="(max-width: 768px) 100vw, 50vw">
                        @else
                            <img src="{{ asset('mellow/images/about-img3.jpg') }}" alt="img" class="img-fluid rounded-4 mt-4">
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Fallback About Section -->
        <section id="about-us" class="padding-large">
            <div class="container-fluid padding-side" data-aos="fade-up">
                @php
                    $siteName = \App\Models\Setting::where('group', 'general')->where('key', 'hotel_name')->first();
                    $siteNameValue = $siteName ? $siteName->value : 'Hotel Mellow';
                @endphp
                <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">{{ $siteNameValue }}: {{ $settings['general']['hotel_description'] ?? 'Your Gateway to Serenity' }}</h3>
                <div class="row align-items-start mt-3 mt-lg-5">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <p>Benvenuti a {{ $siteNameValue }}, dove il comfort incontra la tranquillità. Situato nel cuore della città, il nostro hotel offre un rifugio pacifico per viaggiatori d'affari e di piacere.</p>
                            <p>Con {{ $rooms->count() }} camere eleganti, servizi di lusso e un team dedicato, garantiamo un'esperienza indimenticabile per ogni nostro ospite.</p>
                            <a href="#rooms" class="btn btn-arrow btn-primary mt-3">
                                <span>Scopri di più <svg width="18" height="18">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></span>
                            </a>
                            <a href="{{ route('room.details', 'grand-deluxe-room') }}" class="btn btn-arrow btn-outline-primary mt-3 ms-3">
                                <span>Dettagli Stanza <svg width="18" height="18">
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
    @endif

    <!-- Statistics Section -->
    @if($statistics->count() > 0)
        <section id="statistics" class="bg-secondary pt-3">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <h2 class="display-4 mb-2">I Nostri Numeri</h2>
                        <p class="lead text-muted">Scopri cosa ci rende speciali</p>
                    </div>
                </div>
                <div class="row">
                    @foreach($statistics as $statistic)
                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                            <div class="statistic-item text-center">
                                <div class="statistic-value">
                                    @if($statistic->icon)
                                        <i class="{{ $statistic->icon }} statistic-icon"></i>
                                    @endif
                                    <span class="statistic-number">{{ $statistic->value }}</span>
                                </div>
                                <h5 class="statistic-title">{{ $statistic->title }}</h5>
                                @if($statistic->description)
                                    <p class="statistic-description">{{ $statistic->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Rooms Section -->
    @if($rooms->count() > 0)
        <section id="rooms" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <h3 class="display-3 fw-normal text-center">Esplora le nostre camere</h3>

                <div class="swiper room-swiper mt-5">
                    <div class="swiper-wrapper">
                        @foreach($rooms as $room)
                            <div class="swiper-slide">
                                <div class="room-item position-relative rounded-4 overflow-hidden" 
                                     style="background-image: url('{{ $room->getOptimizedImageUrl('lg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 650px;">
                                    <div class="room-overlay position-absolute top-0 start-0 w-100 h-100 d-none d-lg-block"></div>
                                    <div class="product-description position-relative p-5 text-start h-100 d-flex flex-column justify-content-end d-none d-lg-flex">
                                        <h4 class="display-6 fw-normal text-white mb-3">
                                            <a href="{{ route('room.details', $room->slug) }}" class="text-white text-decoration-none">
                                                {{ $room->name }}
                                            </a>
                                        </h4>
                                        <table class="mb-3">
                                            <tbody>
                                                <tr class="text-white">
                                                    <td class="pe-2">Prezzo:</td>
                                                    <td class="price">
                                                        @if($room->show_price ?? true)
                                                            €{{ $room->price }} /Notte
                                                        @else
                                                            Prezzi su richiesta
                                                        @endif
                                                    </td>
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
                                        <a href="{{ route('room.details', $room->slug) }}">
                                            <p class="text-decoration-underline text-white m-0">Sfoglia Ora</p>
                                        </a>
                                    </div>
                                    <!-- Mobile content -->
                                    <div class="room-mobile-content d-lg-none position-absolute bottom-0 start-0 w-100 p-4 bg-white">
                                        <h4 class="h3 fw-normal mb-2">
                                            <a href="{{ route('room.details', $room->slug) }}" class="text-dark text-decoration-none">
                                                {{ $room->name }}
                                            </a>
                                        </h4>
                                        <p class="mb-2 text-muted">
                                            @if($room->show_price ?? true)
                                                €{{ $room->price }} /Notte
                                            @else
                                                Prezzi su richiesta
                                            @endif
                                        </p>
                                        <a href="{{ route('room.details', $room->slug) }}" class="text-primary text-decoration-none">
                                            Scopri di più →
                                        </a>
                                    </div>
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
                <h3 class="display-3 fw-normal text-center">Gallery</h3>
                <p class="text-center col-lg-4 offset-lg-4 mb-5">Esplora le immagini delle nostre sistemazioni ben arredate, con servizi moderni e arredamento elegante progettato per rendere il vostro soggiorno indimenticabile.</p>
                <div class="container position-relative">
                    <div class="row">
                        <div class="swiper gallery-swiper offset-1 col-10">
                            <div class="swiper-wrapper">
                                @foreach($gallery as $item)
                                    <div class="swiper-slide">
                                        <div class="position-relative">
                                            <img src="{{ $item->getOptimizedImageUrl('lg') }}" 
                                                 alt="{{ $item->title }}" 
                                                 class="img-fluid rounded-4"
                                                 srcset="{{ $item->getResponsiveSrcset() }}"
                                                 sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw">
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
                <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">Servizi e strutture convenzionate</h3>
                <div class="row mt-5">
                    @foreach($services as $service)
                        <div class="col-md-6 col-xl-4 col-12">
                            <div class="service mb-4 text-center rounded-4 p-5">
                                <div class="position-relative">
                                    @if($service->icon)
                                        <i class="{{ $service->icon }} text-primary" style="font-size: 70px;"></i>
                                    @endif
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
                            <h3 class="display-3 fw-normal text-center">Blog ed eventi</h3>
                        </div>
                        <a href="{{ route('blog.index') }}" class="btn btn-arrow btn-primary mt-3">
                            <span>Archivio Blog<svg width="18" height="18">
                                    <use xlink:href="#arrow-right"></use>
                                </svg></span>
                        </a>
                    </div>
                    <div class="row mt-5">
                        @foreach($blogs as $index => $blog)
                            @if($index < 3)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="blog-post position-relative overflow-hidden rounded-4">
                                        <a href="{{ route('blog.show', $blog->slug) }}" class="d-block" aria-label="Leggi: {{ $blog->title }}">
                                            <img src="{{ $blog->getOptimizedImageUrl('lg') }}" 
                                                 class="blog-img img-fluid rounded-4" 
                                                 alt="{{ $blog->title }}"
                                                 srcset="{{ $blog->getResponsiveSrcset() }}"
                                                 sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw">
                                        </a>
                                        <div class="position-absolute bottom-0 start-0 end-0 p-5 blog-content-overlay">
                                            <a href="#"><span class="bg-secondary text-body m-0 px-2 py-1 rounded-2 fs-6">{{ $blog->category ?? 'Blog' }}</span></a>
                                            <h4 class="display-6 fw-normal mt-2 text-white"><a href="{{ route('blog.show', $blog->slug) }}" class="text-white">{{ $blog->title }}</a></h4>
                                            @if($blog->excerpt)
                                                <p class="text-white small mt-2">{{ Str::limit($blog->excerpt, 80) }}</p>
                                            @endif
                                            <p class="m-0 align-items-center text-white"><svg width="19" height="19" class="text-white">
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

    <style>
        /* Mobile Booking Trigger Button */
        .mobile-booking-trigger {
            position: fixed;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            z-index: 1000;
        }
        
        .mobile-booking-trigger .btn {
            width: 60px;
            height: 60px;
            font-size: 20px;
            padding: 0;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-booking-trigger .btn:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        
        /* Mobile Booking Panel - Hidden by default */
        .mobile-booking-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            z-index: 9999;
            transition: left 0.3s ease-in-out;
        }
        
        .mobile-booking-panel.show {
            left: 0;
        }
        
        .mobile-booking-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
        }
        
        .mobile-booking-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 85%;
            max-width: 400px;
            height: 100%;
            background-color: white;
            box-shadow: 2px 0 15px rgba(0,0,0,0.3);
            overflow-y: auto;
        }
        
        .mobile-booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
        }
        
        .mobile-booking-form {
            padding: 20px;
        }
        
        .mobile-booking-form .form-control {
            font-size: 14px;
        }
        
        .mobile-booking-form .form-label {
            font-size: 12px;
        }
        
        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #666;
            cursor: pointer;
            padding: 5px;
        }
        
        .btn-close:hover {
            color: #000;
        }
        
        /* Reduce spacing between slider and about section on mobile */
        @media (max-width: 991px) {
            #about-us {
                padding-top: 2rem !important;
            }
            
            #about-us .padding-large {
                padding-top: 2rem !important;
            }
        }
        
        /* Increase gallery image sizes on mobile */
        @media (max-width: 768px) {
            .gallery-swiper .swiper-slide img {
                height: 320px !important;
                object-fit: cover;
                width: 100%;
                display: block;
            }
        }

        /* Desktop gallery image height */
        @media (min-width: 992px) {
            .gallery-swiper .swiper-slide img {
                height: 600px !important;
                object-fit: cover;
                width: 100%;
                display: block;
            }
        }

        /* Blog images height - vertical format */
        .blog-post img.blog-img {
            height: 400px;
            object-fit: cover;
            width: 100%;
            display: block;
        }

        /* Mobile blog images */
        @media (max-width: 768px) {
            .blog-post img.blog-img {
                height: 350px;
                object-fit: cover;
                width: 100%;
                display: block;
            }
        }

        /* Blog content overlay for better text readability */
        .blog-content-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0) 100%);
            border-radius: 0 0 1.5rem 1.5rem;
            z-index: 2;
        }

        .blog-content-overlay h4 a,
        .blog-content-overlay h4 {
            color: #ffffff !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .blog-content-overlay p {
            color: #ffffff !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .blog-content-overlay svg {
            fill: #ffffff;
        }

        /* Vertical room boxes with background image */
        .room-swiper .swiper-slide {
            height: auto;
        }

        .room-item {
            width: 100%;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .room-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.1) 100%);
            z-index: 1;
        }

        .room-item .product-description {
            z-index: 2;
        }

        @media (max-width: 768px) {
            .room-item {
                min-height: 300px; /* Reduced height for mobile */
            }
            .room-mobile-content {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
            }
        }
        
        /* Hide mobile elements on larger screens */
        @media (min-width: 992px) {
            .mobile-booking-trigger,
            .mobile-booking-panel {
                display: none !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Truncate about description to 60 words with inline "leggi di più"
            const aboutDescription = document.getElementById('about-description');
            
            if (aboutDescription) {
                // Get the full text from data attribute (HTML encoded)
                const encodedHTML = aboutDescription.getAttribute('data-full-text') || '';
                
                // If no content, don't do anything
                if (!encodedHTML || encodedHTML.trim() === '') {
                    return;
                }
                
                // Get the current HTML content (already rendered)
                const currentHTML = aboutDescription.innerHTML;
                
                // Decode HTML entities properly
                const tempDecode = document.createElement('textarea');
                tempDecode.innerHTML = encodedHTML;
                const fullTextHTML = tempDecode.value;
                
                // Extract text content to count words
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = fullTextHTML;
                const textContent = tempDiv.textContent || tempDiv.innerText || '';
                const words = textContent.trim().split(/\s+/).filter(w => w.length > 0);
                let isExpanded = false;
                
                if (words.length > 60) {
                    // Create a function to truncate HTML at word boundary
                    function truncateHTML(html, maxWords) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const body = doc.body;
                        
                        if (!body || !body.hasChildNodes()) {
                            // Fallback: simple text truncation
                            const textOnly = textContent.trim().split(/\s+/).slice(0, maxWords).join(' ');
                            return textOnly;
                        }
                        
                        let wordCount = 0;
                        const walker = document.createTreeWalker(
                            body,
                            NodeFilter.SHOW_TEXT,
                            null,
                            false
                        );
                        
                        let node;
                        while ((node = walker.nextNode()) && wordCount < maxWords) {
                            const nodeText = node.textContent || '';
                            const nodeWords = nodeText.trim().split(/\s+/).filter(w => w.length > 0);
                            
                            if (wordCount + nodeWords.length <= maxWords) {
                                wordCount += nodeWords.length;
                            } else {
                                // Truncate this node
                                const remainingWords = maxWords - wordCount;
                                const wordsToKeep = nodeWords.slice(0, remainingWords);
                                const lastWord = wordsToKeep[remainingWords - 1];
                                const lastWordIndex = nodeText.indexOf(lastWord);
                                const textToKeep = nodeText.substring(0, lastWordIndex + lastWord.length);
                                node.textContent = textToKeep;
                                wordCount = maxWords;
                                
                                // Remove remaining text nodes
                                let nextNode;
                                while ((nextNode = walker.nextNode())) {
                                    nextNode.textContent = '';
                                }
                                break;
                            }
                        }
                        
                        return body.innerHTML;
                    }
                    
                    const truncatedHTML = truncateHTML(fullTextHTML, 60);
                    
                    const readMoreLink = document.createElement('a');
                    readMoreLink.href = '#';
                    readMoreLink.className = 'text-primary text-decoration-none ms-1';
                    readMoreLink.style.cursor = 'pointer';
                    readMoreLink.textContent = 'leggi di più';
                    
                    // Set truncated content
                    aboutDescription.innerHTML = truncatedHTML + ' ';
                    aboutDescription.appendChild(readMoreLink);
                    
                    readMoreLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (!isExpanded) {
                            aboutDescription.innerHTML = fullTextHTML;
                            isExpanded = true;
                        }
                    });
                } else {
                    // If less than 60 words, ensure content is displayed
                    if (!currentHTML || currentHTML.trim() === '') {
                        aboutDescription.innerHTML = fullTextHTML;
                    }
                }
            }
            
            // Handle both desktop and mobile forms
            const desktopForm = document.getElementById('check_available');
            const mobileForm = document.getElementById('check_available_mobile');
            const mobileBookingBtn = document.getElementById('mobileBookingBtn');
            const mobileBookingPanel = document.getElementById('mobileBookingPanel');
            const mobileBookingClose = document.getElementById('mobileBookingClose');
            const mobileBookingOverlay = document.getElementById('mobileBookingOverlay');
            
            // Date validation: update checkout min date when checkin changes
            function updateCheckoutMin(checkinInput, checkoutInput) {
                if (checkinInput && checkoutInput) {
                    checkinInput.addEventListener('change', function() {
                        const checkinDate = new Date(this.value);
                        if (checkinDate && !isNaN(checkinDate.getTime())) {
                            // Set checkout min to checkin date + 1 day
                            const minCheckoutDate = new Date(checkinDate);
                            minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
                            const minDateString = minCheckoutDate.toISOString().split('T')[0];
                            checkoutInput.setAttribute('min', minDateString);
                            
                            // If current checkout value is before the new min, clear it
                            if (checkoutInput.value && checkoutInput.value <= this.value) {
                                checkoutInput.value = '';
                            }
                        }
                    });
                }
            }
            
            // Initialize date validation for desktop form
            const desktopCheckin = document.getElementById('checkin-date');
            const desktopCheckout = document.getElementById('checkout-date');
            updateCheckoutMin(desktopCheckin, desktopCheckout);
            
            // Initialize date validation for mobile form
            const mobileCheckin = document.getElementById('checkin-date-mobile');
            const mobileCheckout = document.getElementById('checkout-date-mobile');
            updateCheckoutMin(mobileCheckin, mobileCheckout);
            
            // Mobile booking panel controls
            if (mobileBookingBtn && mobileBookingPanel) {
                mobileBookingBtn.addEventListener('click', function() {
                    mobileBookingPanel.classList.add('show');
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling
                });
            }
            
            function closeMobilePanel() {
                mobileBookingPanel.classList.remove('show');
                document.body.style.overflow = ''; // Restore scrolling
            }
            
            if (mobileBookingClose) {
                mobileBookingClose.addEventListener('click', closeMobilePanel);
            }
            
            if (mobileBookingOverlay) {
                mobileBookingOverlay.addEventListener('click', closeMobilePanel);
            }
            
            // Handle form submissions
            if (desktopForm) {
                desktopForm.addEventListener('submit', handleFormSubmit);
            }
            
            if (mobileForm) {
                mobileForm.addEventListener('submit', handleFormSubmit);
            }
            
            function handleFormSubmit(e) {
                e.preventDefault();
                
                const form = e.target;
                const formData = new FormData(form);
                
                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Invio...';
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                
                fetch('{{ route("booking.request") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close mobile panel if open
                        if (mobileBookingPanel && mobileBookingPanel.classList.contains('show')) {
                            closeMobilePanel();
                        }
                        showModal('success', 'Successo', 'Richiesta inviata con successo! Ti contatteremo presto.');
                        form.reset();
                    } else {
                        showModal('error', 'Errore', data.message || 'Errore durante l\'invio della richiesta.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModal('error', 'Errore', 'Errore durante l\'invio della richiesta. Riprova più tardi.');
                })
                .finally(() => {
                    // Reset button
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
            }
            
            // Function to show modal - use global function if available, otherwise define locally
            function showModal(type, title, message) {
                if (window.showBookingModal) {
                    window.showBookingModal(type, title, message);
                    return;
                }
                
                const modalElement = document.getElementById('bookingModal');
                if (!modalElement) return;
                
                const modal = new bootstrap.Modal(modalElement);
                const modalIcon = document.getElementById('modalIcon');
                const modalTitle = document.getElementById('modalTitle');
                const modalMessage = document.getElementById('modalMessage');
                
                if (type === 'success') {
                    modalIcon.innerHTML = '<i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>';
                    modalTitle.textContent = title;
                    modalTitle.className = 'mb-3 text-success';
                } else {
                    modalIcon.innerHTML = '<i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>';
                    modalTitle.textContent = title;
                    modalTitle.className = 'mb-3 text-danger';
                }
                
                modalMessage.textContent = message;
                modal.show();
                
                // Clean up overlay when modal is hidden
                modalElement.addEventListener('hidden.bs.modal', function() {
                    // Remove any lingering backdrop
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    // Remove modal-open class from body
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                }, { once: true });
            }
        });
    </script>
    @endsection
