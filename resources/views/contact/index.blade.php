@extends('layouts.public')

@section('title', 'Contatti - ' . ($settings['general']['hotel_name'] ?? 'Hotel Mellow'))

@section('content')
<!-- Contact Header Section -->
<section class="padding-large">
    <div class="container-fluid padding-side" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Contatti</span>
                </div>
                <h1 class="display-2 fw-normal mt-3">Contatti</h1>
                <p class="lead text-muted">Siamo qui per aiutarti. Contattaci per qualsiasi domanda o richiesta</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form and Info Section -->
<section class="padding-medium pt-0">
    <div class="container-fluid padding-side">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="display-6 fw-normal mb-4">Hai domande?</h3>
                        <p class="text-muted mb-4">Utilizza il modulo qui sotto per metterti in contatto con noi.</p>
                        
                        <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Il tuo Nome *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">La tua Email *</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Numero di Telefono</label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="subject" class="form-label fw-semibold">Oggetto *</label>
                                    <input type="text" 
                                           class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" 
                                           name="subject" 
                                           value="{{ old('subject') }}" 
                                           required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold">Il tuo Messaggio *</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="6" 
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" id="submitSpinner"></span>
                                        <span id="submitText">Invia Messaggio</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <h3 class="display-6 fw-normal mb-4">Informazioni di Contatto</h3>
                        <p class="text-muted mb-4">Tortor dignissim convallis aenean et tortor at risus viverra adipiscing.</p>
                        
                        <!-- Head Office -->
                        <div class="mb-5">
                            <h5 class="fw-bold mb-3">Sede Principale</h5>
                            @if($settings['general']['contact_address'] ?? null)
                                <div class="d-flex align-items-start mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                    <div>
                                        <p class="mb-1 fw-semibold">Indirizzo</p>
                                        <p class="text-muted mb-0">
                                            {{ $settings['general']['contact_address'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($settings['general']['contact_phone'] ?? null)
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-phone text-primary me-3"></i>
                                    <div>
                                        <p class="mb-1 fw-semibold">Telefono</p>
                                        <p class="text-muted mb-0">
                                            <a href="tel:{{ $settings['general']['contact_phone'] }}" 
                                               class="text-decoration-none">
                                                {{ $settings['general']['contact_phone'] }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($settings['general']['contact_email'] ?? null)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope text-primary me-3"></i>
                                    <div>
                                        <p class="mb-1 fw-semibold">Email</p>
                                        <p class="text-muted mb-0">
                                            <a href="mailto:{{ $settings['general']['contact_email'] }}" 
                                               class="text-decoration-none">
                                                {{ $settings['general']['contact_email'] }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Social Media -->
                        <div class="border-top pt-4">
                            <h5 class="fw-bold mb-3">Seguici sui Social</h5>
                            @php
                                // Prefer settings passed from controller; fallback to DB
                                $social = $settings['social'] ?? \App\Models\Setting::where('group', 'social')->get()->pluck('value', 'key');
                                $facebookUrl = $social['facebook_url'] ?? null;
                                $instagramUrl = $social['instagram_url'] ?? null;
                                $tiktokUrl = $social['tiktok_url'] ?? null;
                                $whatsappUrl = $social['whatsapp_url'] ?? null;
                                $linkedinUrl = $social['linkedin_url'] ?? null;
                            @endphp

                            <div class="d-flex flex-wrap gap-2">
                                @if(!empty($facebookUrl))
                                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm" title="Facebook">
                                        <i class="fab fa-facebook-f me-1" style="color: #3b5998;"></i>
                                        Facebook
                                    </a>
                                @endif

                                @if(!empty($instagramUrl))
                                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm" title="Instagram">
                                        <i class="fab fa-instagram me-1" style="color: #e4405f;"></i>
                                        Instagram
                                    </a>
                                @endif

                                @if(!empty($tiktokUrl))
                                    <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm" title="TikTok">
                                        <i class="fab fa-tiktok me-1" style="color: #000000;"></i>
                                        TikTok
                                    </a>
                                @endif

                                @if(!empty($whatsappUrl))
                                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm" title="WhatsApp">
                                        <i class="fab fa-whatsapp me-1" style="color: #25d366;"></i>
                                        WhatsApp
                                    </a>
                                @endif

                                @if(!empty($linkedinUrl))
                                    <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm" title="LinkedIn">
                                        <i class="fab fa-linkedin me-1" style="color: #0077b5;"></i>
                                        LinkedIn
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="padding-medium bg-light">
    <div class="container-fluid padding-side">
        <div class="row">
            <div class="col-12">
                <h3 class="display-5 text-center mb-5">Dove Siamo</h3>
                <div class="map-container rounded-4 overflow-hidden shadow">
                    @php
                        $address = $settings['general']['contact_address'] ?? 'Via Roma 123, Roma, Italia';
                        $apiKey = env('GOOGLE_MAPS_API_KEY');
                        
                        if ($apiKey) {
                            // Use Google Maps Embed API with API key for better control
                            $zoom = $settings['general']['map_zoom'] ?? '15';
                            $mapUrl = "https://www.google.com/maps/embed/v1/place?key={$apiKey}&q=" . urlencode($address) . "&zoom={$zoom}";
                        } else {
                            // Use standard Google Maps embed without API key - center on address
                            $mapUrl = "https://www.google.com/maps/embed/v1/place?q=" . urlencode($address) . "&zoom=15";
                        }
                    @endphp
                    <iframe 
                        src="{{ $mapUrl }}" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="padding-medium">
    <div class="container-fluid padding-side">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h3 class="display-5 mb-3">Rimani Aggiornato</h3>
                <p class="lead text-muted mb-4">
                    Iscriviti alla nostra newsletter per ricevere le ultime notizie e offerte speciali
                </p>
                <form class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <input type="email" class="form-control form-control-lg" placeholder="La tua email">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Iscriviti
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.breadcrumb {
    font-size: 0.9rem;
}

.breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.map-container {
    height: 400px;
}

.contact-info-item {
    transition: transform 0.3s ease;
}

.contact-info-item:hover {
    transform: translateX(5px);
}

#contactForm .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--primary-color-dark);
    border-color: var(--primary-color-dark);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitButton = contactForm.querySelector('button[type="submit"]');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitText = document.getElementById('submitText');

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitButton.disabled = true;
        submitSpinner.classList.remove('d-none');
        submitText.textContent = 'Invio in corso...';
        
        // Get form data
        const formData = new FormData(contactForm);
        
        // Send AJAX request
        fetch(contactForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', 'Messaggio inviato!', data.message);
                contactForm.reset();
            } else {
                // Show error message
                showAlert('error', 'Errore', data.message || 'Errore durante l\'invio del messaggio');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Errore', 'Errore durante l\'invio del messaggio. Riprova più tardi.');
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitSpinner.classList.add('d-none');
            submitText.textContent = 'Invia Messaggio';
        });
    });
    
    function showAlert(type, title, message) {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <strong>${title}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert at the top of the form
        contactForm.insertBefore(alertDiv, contactForm.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endpush
