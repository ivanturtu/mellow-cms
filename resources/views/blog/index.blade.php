@extends('layouts.public')

@section('title', 'Blog - ' . ($settings['general']['hotel_name'] ?? 'Hotel Mellow'))

@section('content')
<!-- Blog Header Section -->
<section class="padding-large">
    <div class="container-fluid padding-side" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Blog</span>
                </div>
                <h1 class="display-2 fw-normal mt-3">Blog</h1>
                <p class="lead text-muted">Scopri le ultime notizie, eventi e consigli dal nostro hotel</p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Filter Section -->
<section class="padding-medium pt-0">
    <div class="container-fluid padding-side">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="GET" action="{{ route('blog.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="search" class="form-label fw-semibold">Cerca articoli</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cerca per titolo, contenuto...">
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label fw-semibold">Categoria</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Tutte le categorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" 
                                                {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Filtra
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times me-2"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts Section -->
<section class="padding-medium pt-0">
    <div class="container-fluid padding-side">
        @if($blogs->count() > 0)
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <article class="blog-card h-100">
                            <div class="position-relative overflow-hidden rounded-4 mb-4">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="d-block" aria-label="Leggi: {{ $blog->title }}">
                                    <img src="{{ $blog->getOptimizedImageUrl('lg') }}" 
                                         alt="{{ $blog->title }}" 
                                         class="img-fluid w-100"
                                         srcset="{{ $blog->getResponsiveSrcset() }}"
                                         sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                                         style="height: 250px; object-fit: cover;">
                                </a>
                                <div class="position-absolute top-0 start-0 m-3">
                                    @if($blog->category)
                                        <span class="badge bg-primary px-3 py-2">{{ $blog->category }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="blog-content">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                                    <span class="text-muted small">
                                        {{ $blog->published_at->format('d M, Y') }}
                                    </span>
                                </div>
                                
                                <h3 class="h4 mb-3">
                                    <a href="{{ route('blog.show', $blog->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                
                                @if($blog->excerpt)
                                    <p class="text-muted mb-4">{{ Str::limit($blog->excerpt, 120) }}</p>
                                @endif
                                
                                <a href="{{ route('blog.show', $blog->slug) }}" 
                                   class="btn btn-outline-primary">
                                    Leggi di più
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Blog pagination">
                        {{ $blogs->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        @else
            <!-- No Results -->
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="h4 mb-3">Nessun articolo trovato</h3>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'category']))
                            Prova a modificare i filtri di ricerca o 
                            <a href="{{ route('blog.index') }}" class="text-decoration-none">visualizza tutti gli articoli</a>.
                        @else
                            Non ci sono ancora articoli pubblicati.
                        @endif
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Torna alla Home
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="bg-light padding-medium">
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
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
