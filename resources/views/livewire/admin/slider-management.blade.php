<div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Slider</h2>
            <button wire:click="create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuovo Slider
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
                                   class="form-control" placeholder="Cerca slider...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button wire:click="sortBy('title')" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sort-alpha-down"></i> Titolo
                            </button>
                            <button wire:click="sortBy('sort_order')" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sort-numeric-down"></i> Ordine
                            </button>
                            <button wire:click="sortBy('created_at')" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sort"></i> Data
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
                        {{ $editingSlider ? 'Modifica Slider' : 'Nuovo Slider' }}
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
                                    <label for="description" class="form-label">Descrizione</label>
                                    <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" 
                                              id="description" rows="3"></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cta_text" class="form-label">Testo CTA</label>
                                            <input type="text" wire:model="cta_text" class="form-control @error('cta_text') is-invalid @enderror" 
                                                   id="cta_text">
                                            @error('cta_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cta_link" class="form-label">Link CTA</label>
                                            <input type="text" wire:model="cta_link" class="form-control @error('cta_link') is-invalid @enderror" 
                                                   id="cta_link" placeholder="es. #rooms, #gallery, https://example.com, /pagina">
                                            <small class="form-text text-muted">
                                                Supporta link interni (#rooms, #gallery), URL esterni (https://example.com) e percorsi relativi (/pagina)
                                            </small>
                                            @error('cta_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Ordine</label>
                                            <input type="number" wire:model="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" min="0">
                                            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch mt-4">
                                                <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active">
                                                <label class="form-check-label" for="is_active">
                                                    Slider attivo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Immagine {{ !$editingSlider ? '*' : '' }}
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
                                    @elseif($uploadedImage)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $uploadedImage) }}" alt="Uploaded" 
                                                 class="img-thumbnail" style="max-width: 200px;">
                                            <small class="text-success d-block">Immagine caricata</small>
                                        </div>
                                    @elseif($editingSlider && $editingSlider->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $editingSlider->image) }}" alt="Current" 
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
                                {{ $editingSlider ? 'Aggiorna' : 'Crea' }}
                            </button>
                            <button type="button" wire:click="cancel" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annulla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Sliders List -->
        @if($sliders->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Immagine</th>
                                    <th>Titolo</th>
                                    <th>CTA</th>
                                    <th>Stato</th>
                                    <th>Ordine</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td>
                                            @if($slider->image)
                                                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" 
                                                     class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">Nessuna immagine</span>
                                            @endif
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>
                                            @if($slider->cta_text)
                                                <span class="badge bg-info">{{ $slider->cta_text }}</span>
                                            @else
                                                <span class="text-muted">Nessun CTA</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="toggleActive({{ $slider->id }})" 
                                                    class="btn btn-sm {{ $slider->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $slider->is_active ? 'Attivo' : 'Inattivo' }}
                                            </button>
                                        </td>
                                        <td>{{ $slider->sort_order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button wire:click="edit({{ $slider->id }})" 
                                                        class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="delete({{ $slider->id }})" 
                                                        wire:confirm="Sei sicuro di voler eliminare questo slider?"
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
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nessuno slider trovato</h5>
                    <p class="text-muted">Inizia creando il tuo primo slider per la homepage.</p>
                    <button wire:click="create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Crea Primo Slider
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
                            @livewire('admin.image-upload', ['folder' => 'sliders', 'maxFiles' => 1], key('image-upload-' . $id))
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
    Livewire.on('imagesUploaded', (images) => {
        if (images && images.length > 0) {
            @this.setUploadedImage(images[0].path);
        }
    });
});
</script>