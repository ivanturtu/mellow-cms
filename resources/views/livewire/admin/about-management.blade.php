<!-- Trix Editor CSS -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<style>
    trix-editor {
        min-height: 200px;
    }
    trix-toolbar {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-radius: 0.375rem 0.375rem 0 0;
    }
    trix-editor.form-control {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<div class="about-management-component">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestione Sezione About</h2>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- About Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Modifica Sezione About</h5>
                </div>
                <div class="card-body">
                    <form onsubmit="syncAndSubmit(); return false;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Titolo *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" wire:model.live="title" placeholder="es. Civico 41: Il Vostro Gateway">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subtitle" class="form-label">Sottotitolo</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                       id="subtitle" wire:model.live="subtitle" placeholder="es. Alla Valle Peligna">
                                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione *</label>
                            <input id="description" type="hidden" value="{{ $description }}">
                            <trix-editor input="description" 
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Descrizione della sezione About..."></trix-editor>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cta_text" class="form-label">Testo CTA</label>
                                <input type="text" class="form-control @error('cta_text') is-invalid @enderror" 
                                       id="cta_text" wire:model="cta_text" placeholder="es. Scopri Di Più">
                                @error('cta_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cta_link" class="form-label">Link CTA</label>
                                <input type="text" class="form-control @error('cta_link') is-invalid @enderror" 
                                       id="cta_link" wire:model="cta_link" placeholder="es. #rooms o https://...">
                                @error('cta_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Upload Immagini -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="image_1" class="form-label">Immagine 1</label>
                                <input type="file" class="form-control @error('image_1') is-invalid @enderror" 
                                       id="image_1" wire:model="image_1" accept="image/*">
                                @error('image_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                
                                <!-- Preview Immagine 1 -->
                                @if($image_1)
                                    <div class="mt-2">
                                        <img src="{{ $image_1->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                @elseif($aboutSection && $aboutSection->image_1)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $aboutSection->image_1) }}" alt="Current" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                        <small class="text-muted d-block">Immagine attuale</small>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="image_2" class="form-label">Immagine 2</label>
                                <input type="file" class="form-control @error('image_2') is-invalid @enderror" 
                                       id="image_2" wire:model="image_2" accept="image/*">
                                @error('image_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                
                                <!-- Preview Immagine 2 -->
                                @if($image_2)
                                    <div class="mt-2">
                                        <img src="{{ $image_2->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                @elseif($aboutSection && $aboutSection->image_2)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $aboutSection->image_2) }}" alt="Current" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                        <small class="text-muted d-block">Immagine attuale</small>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="image_3" class="form-label">Immagine 3</label>
                                <input type="file" class="form-control @error('image_3') is-invalid @enderror" 
                                       id="image_3" wire:model="image_3" accept="image/*">
                                @error('image_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                
                                <!-- Preview Immagine 3 -->
                                @if($image_3)
                                    <div class="mt-2">
                                        <img src="{{ $image_3->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                @elseif($aboutSection && $aboutSection->image_3)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $aboutSection->image_3) }}" alt="Current" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                        <small class="text-muted d-block">Immagine attuale</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Ordinamento *</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" wire:model="sort_order" min="0">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                                    <label class="form-check-label" for="is_active">
                                        Sezione attiva
                                    </label>
                                </div>
                            </div>
                        </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="saveAboutBtn">
                                        <i class="fas fa-save me-2"></i>Salva Modifiche
                                    </button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trix Editor JS -->
<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

<script>
document.addEventListener('livewire:init', function () {
    // Listen to Trix changes and update Livewire immediately
    document.addEventListener('trix-change', function(event) {
        if (event.target && event.target.input && event.target.input.id === 'description') {
            const hiddenInput = document.getElementById('description');
            if (hiddenInput) {
                // Update Livewire with the HTML content from Trix immediately
                const trixContent = hiddenInput.value || '';
                @this.set('description', trixContent);
            }
        }
    });
    
    // Also listen for Trix input events
    document.addEventListener('trix-input', function(event) {
        if (event.target && event.target.input && event.target.input.id === 'description') {
            const hiddenInput = document.getElementById('description');
            if (hiddenInput) {
                const trixContent = hiddenInput.value || '';
                @this.set('description', trixContent);
            }
        }
    });
    
    // Listen for Trix initialization
    document.addEventListener('trix-initialize', function(event) {
        if (event.target && event.target.input && event.target.input.id === 'description') {
            const hiddenInput = document.getElementById('description');
            if (hiddenInput && hiddenInput.value) {
                @this.set('description', hiddenInput.value);
            }
        }
    });
    
    // Function to sync Trix with Livewire description
    function syncTrixWithLivewire() {
        const trixEditor = document.querySelector('trix-editor[input="description"]');
        const descriptionInput = document.getElementById('description');
        
        if (!trixEditor || !trixEditor.editor || !descriptionInput) {
            return false;
        }
        
        // Get Livewire description value
        const livewireDescription = @this.description || '';
        
        if (!livewireDescription.trim()) {
            return false;
        }
        
        const currentInputValue = descriptionInput.value || '';
        const currentTrixHTML = trixEditor.editor.getDocument().toString();
        
        // Only update if content is different to avoid infinite loops
        if (currentInputValue !== livewireDescription && currentTrixHTML !== livewireDescription) {
            try {
                // Load the content into Trix
                trixEditor.editor.loadHTML(livewireDescription);
                // Also update the hidden input
                descriptionInput.value = livewireDescription;
                return true;
            } catch (e) {
                console.error('Error syncing Trix:', e);
                return false;
            }
        }
        return false;
    }
    
    // Function to sync Trix and submit form
    window.syncAndSubmit = function() {
        // Sync title and subtitle explicitly (wire:model might not update in time)
        const titleInput = document.getElementById('title');
        const subtitleInput = document.getElementById('subtitle');
        if (titleInput) {
            @this.set('title', titleInput.value || '');
        }
        if (subtitleInput) {
            @this.set('subtitle', subtitleInput.value || '');
        }
        
        // Sync Trix description
        const descriptionInput = document.getElementById('description');
        if (descriptionInput) {
            const trixContent = descriptionInput.value || '';
            // Update Livewire with Trix content
            @this.set('description', trixContent);
        }
        
        // Wait a bit for Livewire to process all updates, then call save
        setTimeout(() => {
            @this.call('save');
        }, 300);
    };
    
    // Sync Trix when Livewire updates description
    Livewire.hook('morph.updated', ({ component }) => {
        setTimeout(() => {
            syncTrixWithLivewire();
        }, 100);
    });
    
    // Listen for about-section-saved event
    Livewire.on('about-section-saved', () => {
        setTimeout(() => {
            syncTrixWithLivewire();
            // Force update title and subtitle inputs
            const titleInput = document.getElementById('title');
            const subtitleInput = document.getElementById('subtitle');
            if (titleInput) {
                const newTitle = @this.title || '';
                if (titleInput.value !== newTitle) {
                    titleInput.value = newTitle;
                }
            }
            if (subtitleInput) {
                const newSubtitle = @this.subtitle || '';
                if (subtitleInput.value !== newSubtitle) {
                    subtitleInput.value = newSubtitle;
                }
            }
        }, 300);
    });
    
    // Update inputs when Livewire updates properties
    Livewire.hook('morph.updated', ({ component }) => {
        setTimeout(() => {
            const titleInput = document.getElementById('title');
            const subtitleInput = document.getElementById('subtitle');
            if (titleInput && @this.title !== undefined) {
                const newTitle = @this.title || '';
                if (titleInput.value !== newTitle) {
                    titleInput.value = newTitle;
                }
            }
            if (subtitleInput && @this.subtitle !== undefined) {
                const newSubtitle = @this.subtitle || '';
                if (subtitleInput.value !== newSubtitle) {
                    subtitleInput.value = newSubtitle;
                }
            }
        }, 200);
    });
    
    // Initialize inputs on component mount
    setTimeout(() => {
        const titleInput = document.getElementById('title');
        const subtitleInput = document.getElementById('subtitle');
        if (titleInput && @this.title) {
            titleInput.value = @this.title;
        }
        if (subtitleInput && @this.subtitle) {
            subtitleInput.value = @this.subtitle;
        }
    }, 500);
    
    // Sync when component is loaded
    setTimeout(() => {
        syncTrixWithLivewire();
    }, 500);
    
    // Also sync after Livewire finishes loading
    Livewire.hook('morph', ({ el, component }) => {
        setTimeout(() => {
            syncTrixWithLivewire();
        }, 200);
    });
});
</script>
