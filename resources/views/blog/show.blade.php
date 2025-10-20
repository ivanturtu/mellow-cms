@extends('layouts.public')

@section('title', $blog->title . ' - ' . ($settings['general']['hotel_name'] ?? 'Hotel Mellow'))

@section('content')
<!-- Blog Post Header (aligned to archive style) -->
<section class="padding-large">
    <div class="container-fluid padding-side" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('blog.index') }}" class="text-decoration-none">Blog</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">{{ $blog->title }}</span>
                </div>
                <h1 class="display-2 fw-normal mt-3">{{ $blog->title }}</h1>
                @if($blog->excerpt)
                    <p class="lead text-muted">{{ $blog->excerpt }}</p>
                @endif
                <div class="d-flex align-items-center mt-3">
                    @if($blog->category)
                        <span class="badge bg-primary me-3 px-3 py-2">{{ $blog->category }}</span>
                    @endif
                    <div class="d-flex align-items-center text-muted">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span>{{ $blog->published_at->format('d M, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Post Content -->
<section class="padding-medium pt-0">
    <div class="container-fluid padding-side">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Featured Image -->
                @if($blog->image)
                    <div class="mb-5">
                        <img src="{{ $blog->getOptimizedImageUrl('xl') }}" 
                             alt="{{ $blog->title }}" 
                             class="img-fluid rounded-4 w-100"
                             srcset="{{ $blog->getResponsiveSrcset() }}"
                             sizes="(max-width: 768px) 100vw, 800px"
                             style="height: 400px; object-fit: cover;">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="blog-content">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                <!-- Article Footer -->
                <div class="border-top pt-4 mt-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-share-alt text-muted"></i>
                                </div>
                                <span class="text-muted">Condividi questo articolo</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Torna al Blog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
    <section class="padding-medium bg-light">
        <div class="container-fluid padding-side">
            <div class="row">
                <div class="col-12">
                    <h3 class="display-5 mb-5 text-center">Articoli Correlati</h3>
                </div>
            </div>
            <div class="row">
                @foreach($relatedPosts as $relatedPost)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <article class="blog-card h-100">
                            <div class="position-relative overflow-hidden rounded-4 mb-3">
                                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="d-block" aria-label="Leggi: {{ $relatedPost->title }}">
                                    <img src="{{ $relatedPost->getOptimizedImageUrl('lg') }}" 
                                         alt="{{ $relatedPost->title }}" 
                                         class="img-fluid w-100"
                                         srcset="{{ $relatedPost->getResponsiveSrcset() }}"
                                         sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                                         style="height: 200px; object-fit: cover;">
                                </a>
                                @if($relatedPost->category)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-primary px-2 py-1">{{ $relatedPost->category }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="blog-content">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-alt text-muted me-2 small"></i>
                                    <span class="text-muted small">
                                        {{ $relatedPost->published_at->format('d M, Y') }}
                                    </span>
                                </div>
                                
                                <h4 class="h5 mb-3">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h4>
                                
                                @if($relatedPost->excerpt)
                                    <p class="text-muted small mb-3">{{ Str::limit($relatedPost->excerpt, 80) }}</p>
                                @endif
                                
                                <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Leggi di più
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

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
.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.blog-card img {
    transition: transform 0.3s ease;
}

.blog-card:hover img {
    transform: scale(1.05);
}

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
</style>
@endpush
