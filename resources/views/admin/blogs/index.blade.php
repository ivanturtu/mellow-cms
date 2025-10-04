<x-layouts.admin title="Gestione Blog">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Articoli Blog</h2>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuovo Articolo
        </a>
    </div>

    @if($blogs->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Immagine</th>
                                <th>Titolo</th>
                                <th>Categoria</th>
                                <th>Stato</th>
                                <th>Data Pubblicazione</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>
                                        @if($blog->image)
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" 
                                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Nessuna immagine</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $blog->title }}</strong>
                                        @if($blog->excerpt)
                                            <br><small class="text-muted">{{ Str::limit($blog->excerpt, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->category)
                                            <span class="badge bg-info">{{ $blog->category }}</span>
                                        @else
                                            <span class="text-muted">Nessuna categoria</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->is_published)
                                            <span class="badge bg-success">Pubblicato</span>
                                        @else
                                            <span class="badge bg-warning">Bozza</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->published_at)
                                            {{ $blog->published_at->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted">Non pubblicato</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blogs.edit', $blog) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" 
                                                  class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questo articolo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessun articolo trovato</h5>
                <p class="text-muted">Inizia creando il tuo primo articolo del blog.</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crea Primo Articolo
                </a>
            </div>
        </div>
    @endif
</x-layouts.admin>
