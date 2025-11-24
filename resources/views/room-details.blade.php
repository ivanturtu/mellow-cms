@extends('layouts.public')

@section('content')
<!-- Room Details Section -->
<section id="room-details" class="pt-3">
    <div class="container-fluid padding-side">
        <div class="row">
            <!-- Room Images Gallery -->
            <div class="col-lg-8 mb-5">
                <div class="room-gallery">
                    @if($room->activeImages->count() > 0)
                        <!-- Swiper Main -->
                        <div class="swiper product-large-slider swiper-fade">
                            <div class="swiper-wrapper">
                                @foreach($room->activeImages as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . ltrim($image->image_path, '/')) }}" 
                                             alt="{{ $image->alt_text ?? $room->name }}" 
                                             class="img-fluid rounded-4 w-100" 
                                             style="width: 100%; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"><i class="fas fa-chevron-left"></i></div>
                            <div class="swiper-button-next"><i class="fas fa-chevron-right"></i></div>
                        </div>

                        <!-- Swiper Thumbs (optional) -->
                        @if($room->activeImages->count() > 1)
                        <div class="swiper room-thumbs mt-3">
                            <div class="swiper-wrapper">
                                @foreach($room->activeImages as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . ltrim($image->image_path, '/')) }}" 
                                             alt="{{ $image->alt_text ?? $room->name }}" 
                                             class="img-fluid rounded-3" 
                                             style="height: 100px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @else
                        <!-- Fallback to room image if no gallery images -->
                        <div class="swiper product-large-slider swiper-fade">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . ltrim($room->image, '/')) }}" alt="{{ $room->name }}" class="img-fluid rounded-4 w-100" style="width: 100%; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Swiper assets and init -->
            <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css">
            <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Thumbs slider
                var thumbsEl = document.querySelector('.room-thumbs');
                var thumbsSwiper = null;
                if (thumbsEl) {
                    thumbsSwiper = new Swiper('.room-thumbs', {
                        slidesPerView: 'auto',
                        spaceBetween: 12,
                        centeredSlides: false,
                        freeMode: true,
                        watchSlidesProgress: true,
                        breakpoints: {
                            0: { slidesPerView: 3, centeredSlides: false },
                            768: { slidesPerView: 'auto', centeredSlides: false }
                        }
                    });
                }

                // Main slider
                if (document.querySelector('.product-large-slider')) {
                    new Swiper('.product-large-slider', {
                        effect: 'fade',
                        loop: true,
                        fadeEffect: { crossFade: true },
                        pagination: { el: '.swiper-pagination', clickable: true },
                        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                        autoplay: { delay: 4000, disableOnInteraction: false },
                        thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : undefined,
                        watchSlidesProgress: true
                    });
                }
            });
            </script>
            <style>
            @media (min-width: 992px) {
                .product-large-slider .swiper-slide img {
                    height: 600px !important;
                    object-fit: cover;
                    width: 100%;
                }
            }
            .room-thumbs {
                padding-top: 8px;
                padding-bottom: 8px;
            }
            .room-thumbs .swiper-wrapper { justify-content: flex-start; align-items: center; }
            .room-thumbs .swiper-slide { opacity: 0.6; transition: opacity .2s ease; width: auto !important; }
            .room-thumbs .swiper-slide-thumb-active {
                opacity: 1;
                outline: 2px solid var(--primary-color, #667eea);
                border-radius: .5rem;
            }

            /* Armonizza frecce e dots con la home */
            .product-large-slider .swiper-button-next,
            .product-large-slider .swiper-button-prev {
                color: #fff;
                background: var(--primary-color, #667eea);
                width: 46px; height: 46px; border-radius: 50%;
                box-shadow: 0 6px 20px rgba(0,0,0,.15);
            }
            /* Hide default arrows, show FontAwesome */
            .product-large-slider .swiper-button-next::after,
            .product-large-slider .swiper-button-prev::after { display: none; }
            .product-large-slider .swiper-button-next svg,
            .product-large-slider .swiper-button-prev svg { display: none !important; }
            .product-large-slider .swiper-button-next i,
            .product-large-slider .swiper-button-prev i { font-size: 16px; line-height: 46px; }
            .product-large-slider .swiper-button-next:hover,
            .product-large-slider .swiper-button-prev:hover { filter: brightness(0.95); }

            .product-large-slider .swiper-pagination-bullet { 
                background: rgba(0,0,0,.25); opacity: 1; width: 10px; height: 10px;
            }
            .product-large-slider .swiper-pagination-bullet-active { 
                background: var(--primary-color, #667eea);
            }
            </style>

            <!-- Room Info -->
            <div class="col-lg-4">
                <div class="room-info bg-light p-4 rounded-4">
                    <h2 class="display-4 mb-3">{{ $room->name }}</h2>
                    <div class="price-display mb-4">
                        <span class="h3 text-primary">
                            @if($room->show_price ?? true)
                                €{{ number_format($room->price, 2) }}/notte
                            @else
                                Prezzi su richiesta
                            @endif
                        </span>
                    </div>

                    <!-- Room Overview -->
                    <div class="room-overview mb-4">
                        <h5 class="mb-3">Dettagli Camera</h5>
                        <div class="row">
                            @if($room->size)
                            <div class="col-6 mb-2">
                                <strong>Dimensione:</strong> {{ $room->size }}
                            </div>
                            @endif
                            @if($room->capacity)
                            <div class="col-6 mb-2">
                                <strong>Capacità:</strong> {{ $room->capacity }} {{ $room->capacity == 1 ? 'persona' : 'persone' }}
                            </div>
                            @endif
                            @if($room->bed_type)
                            <div class="col-6 mb-2">
                                <strong>Tipo letto:</strong> {{ $room->bed_type }}
                            </div>
                            @endif
                            @if(!is_null($room->bed_count))
                            <div class="col-6 mb-2">
                                <strong>Numero letti:</strong> {{ $room->bed_count }}
                            </div>
                            @endif
                            @if(!is_null($room->bath_count))
                            <div class="col-6 mb-2">
                                <strong>Bagni:</strong> {{ $room->bath_count }}
                            </div>
                            @endif
                            <div class="col-6 mb-2">
                                <strong>WiFi:</strong> {{ $room->wifi ? 'Sì' : 'No' }}
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Aria condizionata:</strong> {{ $room->air_conditioning ? 'Sì' : 'No' }}
                            </div>
                            <div class="col-6 mb-2">
                                <strong>TV:</strong> {{ $room->tv_cable ? 'Sì' : 'No' }}
                            </div>
                            @if($room->services)
                            <div class="col-12 mb-2">
                                <strong>Servizi:</strong> {{ $room->services }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Price Details -->
                    <div class="price-details mb-4">
                        <h5 class="mb-3">Prezzi</h5>
                        @if($room->show_price ?? true)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Per Notte:</span>
                                <span>€{{ number_format($room->price, 2) }}</span>
                            </div>
                        @else
                            <p class="text-muted">Prezzi su richiesta</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Description -->
        @if($room->description)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="display-5 mb-4">Room Details</h3>
                    <div id="room-description" data-full-text="{{ htmlspecialchars($room->description, ENT_QUOTES, 'UTF-8') }}" class="lead">{!! $room->description !!}</div>
                </div>
            </div>
        @endif

        <!-- Features & Amenities -->
        @if($room->features || $room->amenities)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="display-5 mb-4">Features & Amenities</h3>
                    <div class="row">
                        @if($room->features)
                            <div class="col-md-6">
                                <h5>Features</h5>
                                <ul class="list-unstyled">
                                    @foreach($room->features as $feature)
                                        <li class="mb-2">
                                            <i class="fas fa-check text-primary me-2"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($room->amenities)
                            <div class="col-md-6">
                                <h5>Amenities</h5>
                                <ul class="list-unstyled">
                                    @foreach($room->amenities as $amenity)
                                        <li class="mb-2">
                                            <i class="fas fa-check text-primary me-2"></i>
                                            {{ $amenity }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Location -->
        @if($room->location_address)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="display-5 mb-4">Location</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Address:</strong> {{ $room->location_address }}</p>
                            @if($room->location_city)
                                <p><strong>City:</strong> {{ $room->location_city }}</p>
                            @endif
                            @if($room->location_state)
                                <p><strong>State/County:</strong> {{ $room->location_state }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($room->location_zip)
                                <p><strong>Zip/Postal Code:</strong> {{ $room->location_zip }}</p>
                            @endif
                            @if($room->location_country)
                                <p><strong>Country:</strong> {{ $room->location_country }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Reserve Now Form (dynamic like home) -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="reservation-form bg-secondary p-4 rounded-4">
                    <h3 class="display-5 mb-4">Richiesta disponibilità</h3>
                    <form id="check_available" class="form-group flex-wrap" method="POST" action="{{ route('booking.request') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label text-uppercase small">Check-In</label>
                                <input type="date" class="form-control text-black-50 ps-2" id="checkin-date-room" name="checkin_date" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-uppercase small">Check-Out</label>
                                <input type="date" class="form-control text-black-50 ps-2" id="checkout-date-room" name="checkout_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-uppercase small">Camere</label>
                                <input type="number" value="1" name="rooms" class="form-control text-black-50 ps-2" min="1">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-uppercase small">Ospiti</label>
                                <input type="number" value="1" name="guests" class="form-control text-black-50 ps-2" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase small">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control text-black-50 ps-2" placeholder="La tua email" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase small">Telefono (opzionale)</label>
                                <input type="tel" name="phone" class="form-control text-black-50 ps-2" placeholder="Il tuo telefono">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span>Invia</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Related Rooms -->
        @if($relatedRooms->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="display-5 mb-4">Other Rooms</h3>
                    <div class="row">
                        @foreach($relatedRooms as $relatedRoom)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . ltrim($relatedRoom->image, '/')) }}" class="card-img-top" alt="{{ $relatedRoom->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $relatedRoom->name }}</h5>
                                        <p class="card-text text-primary">
                                            @if($relatedRoom->show_price ?? true)
                                                €{{ number_format($relatedRoom->price, 2) }}/notte
                                            @else
                                                Prezzi su richiesta
                                            @endif
                                        </p>
                                        <a href="{{ route('room.details', $relatedRoom->slug) }}" class="btn btn-outline-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
function changeMainImage(imageSrc, imageAlt) {
    // legacy helper no longer used with Swiper, kept for backward safety
}

// Handle booking form submission
document.addEventListener('DOMContentLoaded', function() {
    // Truncate room description to 60 words with inline "leggi di più"
    const roomDescription = document.getElementById('room-description');
    
    if (roomDescription) {
        // Get the full text from data attribute (HTML encoded)
        const encodedHTML = roomDescription.getAttribute('data-full-text') || '';
        
        // If no content, don't do anything
        if (!encodedHTML || encodedHTML.trim() === '') {
            return;
        }
        
        // Get the current HTML content (already rendered)
        const currentHTML = roomDescription.innerHTML;
        
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
            roomDescription.innerHTML = truncatedHTML + ' ';
            roomDescription.appendChild(readMoreLink);
            
            readMoreLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (!isExpanded) {
                    roomDescription.innerHTML = fullTextHTML;
                    isExpanded = true;
                }
            });
        } else {
            // If less than 60 words, ensure content is displayed
            if (!currentHTML || currentHTML.trim() === '') {
                roomDescription.innerHTML = fullTextHTML;
            }
        }
    }
    
    const bookingForm = document.getElementById('check_available');
    
    // Date validation: update checkout min date when checkin changes
    const checkinInput = document.getElementById('checkin-date-room');
    const checkoutInput = document.getElementById('checkout-date-room');
    
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
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Invio...';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            // Send AJAX request
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
        });
    }
    
    // Function to show modal - use global function if available, otherwise define locally
    function showModal(type, title, message) {
        if (window.showBookingModal) {
            window.showBookingModal(type, title, message);
            return;
        }
        
        const modalElement = document.getElementById('bookingModal');
        if (!modalElement) {
            // Fallback to alert if modal doesn't exist
            alert(`${title}: ${message}`);
            return;
        }
        
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
        
        // Force FontAwesome icons to render
        setTimeout(() => {
            const icons = modalIcon.querySelectorAll('i');
            icons.forEach(icon => {
                icon.style.fontFamily = '"Font Awesome 6 Free"';
                icon.style.fontWeight = '900';
                icon.style.display = 'inline-block';
                icon.style.fontStyle = 'normal';
                icon.style.fontVariant = 'normal';
                icon.style.textRendering = 'auto';
                icon.style.lineHeight = '1';
            });
        }, 100);
    }
});
</script>
@endsection
