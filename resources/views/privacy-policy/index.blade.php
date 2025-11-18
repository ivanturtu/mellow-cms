@extends('layouts.public')

@section('title', 'Privacy Policy - ' . ($settings['general']['hotel_name'] ?? 'Hotel Mellow'))

@section('content')
<!-- Privacy Policy Header Section -->
<section class="padding-large">
    <div class="container-fluid padding-side" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Privacy Policy</span>
                </div>
                <h1 class="display-2 fw-normal mt-3">Privacy Policy</h1>
                <p class="lead text-muted">Informativa sulla privacy e trattamento dei dati personali</p>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Policy Content Section -->
<section class="padding-medium pt-0">
    <div class="container-fluid padding-side">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        @if($privacyContent)
                            <div class="privacy-content">
                                {!! nl2br(e($privacyContent)) !!}
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p class="mb-0">La privacy policy è in fase di aggiornamento. Contattaci per maggiori informazioni.</p>
                            </div>
                        @endif
                    </div>
                </div>
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

.privacy-content {
    line-height: 1.8;
    color: #333;
}

.privacy-content h2 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
    font-size: 1.75rem;
}

.privacy-content h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #555;
    font-size: 1.5rem;
}

.privacy-content p {
    margin-bottom: 1rem;
}

.privacy-content ul,
.privacy-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.privacy-content li {
    margin-bottom: 0.5rem;
}
</style>
@endpush





