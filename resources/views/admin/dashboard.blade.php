<x-layouts.admin title="Dashboard">
    <div class="row">
        <!-- Stats Cards -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['sliders'] }}</h4>
                            <p class="card-text">Slider</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-images fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['rooms'] }}</h4>
                            <p class="card-text">Camere</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-bed fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['gallery'] }}</h4>
                            <p class="card-text">Immagini Gallery</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-camera fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['services'] }}</h4>
                            <p class="card-text">Servizi</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-concierge-bell fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['blogs'] }}</h4>
                            <p class="card-text">Articoli Blog</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-blog fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['published_blogs'] }}</h4>
                            <p class="card-text">Articoli Pubblicati</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Blogs -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Articoli Blog Recenti</h5>
                </div>
                <div class="card-body">
                    @if($recent_blogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Titolo</th>
                                        <th>Categoria</th>
                                        <th>Stato</th>
                                        <th>Data Creazione</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->title }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $blog->category ?? 'Nessuna' }}</span>
                                            </td>
                                            <td>
                                                @if($blog->is_published)
                                                    <span class="badge bg-success">Pubblicato</span>
                                                @else
                                                    <span class="badge bg-warning">Bozza</span>
                                                @endif
                                            </td>
                                            <td>{{ $blog->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Nessun articolo blog trovato.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Azioni Rapide</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Nuovo Slider
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.rooms.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Nuova Camera
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-info w-100">
                                <i class="fas fa-plus me-2"></i>Nuovo Articolo
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-warning w-100">
                                <i class="fas fa-cog me-2"></i>Impostazioni
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

