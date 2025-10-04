<x-layouts.admin title="Gestione Gallery">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gallery</h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuova Immagine
        </a>
    </div>

    @if($galleries->count() > 0)
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
                                <th>Ordine</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($galleries as $gallery)
                                <tr>
                                    <td>
                                        @if($gallery->image)
                                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" 
                                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Nessuna immagine</span>
                                        @endif
                                    </td>
                                    <td>{{ $gallery->title ?? 'Senza titolo' }}</td>
                                    <td>
                                        @if($gallery->category)
                                            <span class="badge bg-info">{{ $gallery->category }}</span>
                                        @else
                                            <span class="text-muted">Nessuna categoria</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($gallery->is_active)
                                            <span class="badge bg-success">Attiva</span>
                                        @else
                                            <span class="badge bg-secondary">Inattiva</span>
                                        @endif
                                    </td>
                                    <td>{{ $gallery->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.gallery.destroy', $gallery) }}" 
                                                  class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa immagine?')">
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
                <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessuna immagine trovata</h5>
                <p class="text-muted">Inizia aggiungendo la prima immagine alla gallery.</p>
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Aggiungi Prima Immagine
                </a>
            </div>
        </div>
    @endif
</x-layouts.admin>
