<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Blog</h2>
        <button wire:click="create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuovo Articolo
        </button>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search" 
                               class="form-control" placeholder="Cerca articoli...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <button wire:click="sortBy('title')" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sort-alpha-down"></i> Titolo
                        </button>
                        <button wire:click="sortBy('published_at')" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sort"></i> Data
                        </button>
                        <button wire:click="sortBy('created_at')" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sort"></i> Creazione
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form Modal -->
    @if($showForm)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    {{ $editingBlog ? 'Modifica Articolo' : 'Nuovo Articolo' }}
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit="save">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titolo *</label>
                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Riassunto</label>
                                <textarea wire:model="excerpt" class="form-control @error('excerpt') is-invalid @enderror" 
                                          id="excerpt" rows="3" placeholder="Breve descrizione dell'articolo"></textarea>
                                @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenuto *</label>
                                <textarea wire:model="content" class="form-control @error('content') is-invalid @enderror" 
                                          id="content" rows="10" required></textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Categoria</label>
                                        <input type="text" wire:model="category" class="form-control @error('category') is-invalid @enderror" 
                                               id="category" placeholder="es. Notizie, Eventi, Offerte">
                                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="published_at" class="form-label">Data Pubblicazione</label>
                                        <input type="datetime-local" wire:model="published_at" class="form-control @error('published_at') is-invalid @enderror" 
                                               id="published_at">
                                        @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" wire:model="is_published" class="form-check-input" id="is_published">
                                    <label class="form-check-label" for="is_published">
                                        Articolo pubblicato
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">
                                    Immagine {{ !$editingBlog ? '*' : '' }}
                                </label>
                                
                                <!-- Image Upload Options -->
                                <div class="d-grid gap-2 mb-3">
                                    <button type="button" wire:click="showImageUploadModal" class="btn btn-outline-primary">
                                        <i class="fas fa-upload me-2"></i>Carica con Drag & Drop
                                    </button>
                                    <div class="text-center">
                                        <small class="text-muted">oppure</small>
                                    </div>
                                </div>
                                
                                <!-- Traditional File Input -->
                                <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" accept="image/*">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                
                                <!-- Image Preview -->
                                @if($image)
                                    <div class="mt-2">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" 
                                             class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @elseif($editingBlog && $editingBlog->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $editingBlog->image) }}" alt="Current" 
                                             class="img-thumbnail" style="max-width: 200px;">
                                        <small class="text-muted d-block">Immagine attuale</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            {{ $editingBlog ? 'Aggiorna' : 'Crea' }}
                        </button>
                        <button type="button" wire:click="cancel" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Annulla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Blogs List -->
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
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="togglePublished({{ $blog->id }})" 
                                                class="btn btn-sm {{ $blog->is_published ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $blog->is_published ? 'Pubblicato' : 'Bozza' }}
                                        </button>
                                    </td>
                                    <td>
                                        @if($blog->published_at)
                                            {{ $blog->published_at->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $blog->id }})" 
                                                    class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="delete({{ $blog->id }})" 
                                                    wire:confirm="Sei sicuro di voler eliminare questo articolo?"
                                                    class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                <button wire:click="create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crea Primo Articolo
                </button>
            </div>
        </div>
    @endif

    <!-- Image Upload Modal -->
    @if($showImageUpload)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carica Immagine con Drag & Drop</h5>
                        <button type="button" wire:click="hideImageUploadModal" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        @livewire('admin.image-upload', ['folder' => 'blogs', 'maxFiles' => 1], key('image-upload-' . $id))
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="hideImageUploadModal" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Chiudi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

<script>
document.addEventListener('livewire:init', function () {
    Livewire.on('imageUploaded', (imagePath) => {
        @this.setUploadedImage(imagePath);
    });
});
</script>