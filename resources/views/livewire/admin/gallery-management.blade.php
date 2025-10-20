<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestione Gallery</h2>
        <div>
            <button wire:click="create" class="btn btn-primary me-2">
                <i class="fas fa-plus me-2"></i>Nuova Immagine
            </button>
            <button wire:click="showBulkUploadModal" class="btn btn-success">
                <i class="fas fa-upload me-2"></i>Carica Multiple
            </button>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Cerca immagini...">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <select wire:model.live="sortBy" class="form-select">
                            <option value="sort_order">Ordine</option>
                            <option value="title">Titolo</option>
                            <option value="category">Categoria</option>
                            <option value="created_at">Data Creazione</option>
                        </select>
                        <button wire:click="sortBy('{{ $sortBy }}')" class="btn btn-outline-secondary">
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    @if($galleries->count() > 0)
        <div class="row">
            @foreach($galleries as $gallery)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            @if($gallery->image)
                                <img src="{{ asset('storage/' . $gallery->image) }}" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover;" 
                                     alt="{{ $gallery->title }}">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($gallery->is_active)
                                    <span class="badge bg-success">Attiva</span>
                                @else
                                    <span class="badge bg-secondary">Inattiva</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $gallery->title ?: 'Senza titolo' }}</h5>
                            
                            @if($gallery->description)
                                <p class="card-text text-muted small">{{ Str::limit($gallery->description, 100) }}</p>
                            @endif
                            
                            @if($gallery->category)
                                <span class="badge bg-info mb-2">{{ $gallery->category }}</span>
                            @endif
                            
                            <div class="mt-auto">
                                <div class="btn-group w-100" role="group">
                                    <button wire:click="edit({{ $gallery->id }})" 
                                            class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $gallery->id }})" 
                                            class="btn btn-sm btn-outline-{{ $gallery->is_active ? 'warning' : 'success' }}">
                                        <i class="fas fa-{{ $gallery->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                    <button wire:click="delete({{ $gallery->id }})" 
                                            wire:confirm="Sei sicuro di voler eliminare questa immagine?"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessuna immagine trovata</h5>
                <p class="text-muted">Inizia caricando la tua prima immagine nella gallery.</p>
                <button wire:click="create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Carica Prima Immagine
                </button>
            </div>
        </div>
    @endif

    <!-- Form Modal -->
    @if($showModal && $modalType === 'form')
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $editingGallery ? 'Modifica Immagine' : 'Nuova Immagine' }}
                        </h5>
                        <button type="button" wire:click="closeModal" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Titolo *</label>
                                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" required>
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descrizione</label>
                                        <textarea wire:model="description" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Categoria</label>
                                                <input type="text" wire:model="category" class="form-control" placeholder="es. Viste, Servizi">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">Ordine</label>
                                                <input type="number" wire:model="sort_order" class="form-control" min="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                            <label class="form-check-label" for="is_active">
                                                Attiva
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Immagine {{ $editingGallery ? '(opzionale)' : '*' }}</label>
                                        
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
                                               accept="image/*" {{ !$editingGallery ? 'required' : '' }}>
                                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <div class="form-text">Formati supportati: JPEG, PNG, JPG, GIF. Max 2MB.</div>
                                    </div>

                                    @if($image)
                                        <div class="mb-3">
                                            <label class="form-label">Anteprima</label>
                                            <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded" alt="Preview">
                                        </div>
                                    @endif

                                    @if($editingGallery && $editingGallery->image)
                                        <div class="mb-3">
                                            <label class="form-label">Immagine Attuale</label>
                                            <img src="{{ asset('storage/' . $editingGallery->image) }}" 
                                                 class="img-fluid rounded" alt="Current">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModal" class="btn btn-secondary">Annulla</button>
                        <button type="button" wire:click="save" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salva
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bulk Upload Modal -->
    @if($showModal && $modalType === 'bulk')
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);" wire:click.self="closeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carica Immagini Multiple</h5>
                        <button type="button" wire:click="closeModal" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Seleziona più immagini da caricare contemporaneamente. Tutte le immagini avranno le stesse impostazioni.
                        </div>
                        
                        <div class="mb-3">
                            <label for="bulkImages" class="form-label">Immagini *</label>
                            <input type="file" wire:model="uploadedImages" class="form-control" 
                                   accept="image/*" multiple required>
                            <div class="form-text">Puoi selezionare più immagini contemporaneamente.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bulkCategory" class="form-label">Categoria</label>
                                    <input type="text" wire:model="category" class="form-control" placeholder="es. Viste, Servizi">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bulkSortOrder" class="form-label">Ordine Iniziale</label>
                                    <input type="number" wire:model="sort_order" class="form-control" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="is_active" id="bulkIsActive">
                                <label class="form-check-label" for="bulkIsActive">
                                    Attiva tutte le immagini
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModal" class="btn btn-secondary">Annulla</button>
                        <button type="button" wire:click="processBulkUpload" class="btn btn-success">
                            <i class="fas fa-upload me-2"></i>Carica Tutte
                        </button>
                    </div>
                </div>
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
                        @livewire('admin.image-upload', ['folder' => 'gallery', 'maxFiles' => 1], key('image-upload-' . $id))
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