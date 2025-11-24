<div>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Camere</h2>
            <button wire:click="create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuova Camera
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
                                   class="form-control" placeholder="Cerca camere...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button wire:click="sortBy('name')" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sort-alpha-down"></i> Nome
                            </button>
                            <button wire:click="sortBy('price')" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sort-numeric-down"></i> Prezzo
                            </button>
                            <button wire:click="sortBy('sort_order')" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sort"></i> Ordine
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
                        {{ $editingRoom ? 'Modifica Camera' : 'Nuova Camera' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit="save" onsubmit="syncAndSubmitRoom(); return false;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome Camera *</label>
                                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Descrizione *</label>
                                    <input id="description" type="hidden" value="{{ $description }}">
                                    <trix-editor input="description" 
                                                class="form-control @error('description') is-invalid @enderror"
                                                placeholder="Descrizione della camera..."></trix-editor>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Prezzo (€) *</label>
                                            <input type="number" wire:model="price" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" step="0.01" min="0" required>
                                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" wire:model="show_price" id="show_price">
                                                <label class="form-check-label" for="show_price">
                                                    Mostra prezzo (se deselezionato, mostra "Prezzi su richiesta")
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="capacity" class="form-label">Capacità *</label>
                                            <input type="number" wire:model="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                                                   id="capacity" min="1" required>
                                            @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="size" class="form-label">Dimensioni</label>
                                            <input type="text" wire:model="size" class="form-control @error('size') is-invalid @enderror" 
                                                   id="size" placeholder="es. 25 m²">
                                            @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bed_type" class="form-label">Tipo Letto</label>
                                            <input type="text" wire:model="bed_type" class="form-control @error('bed_type') is-invalid @enderror" 
                                                   id="bed_type" placeholder="es. King Size, Doppio">
                                            @error('bed_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Ordine</label>
                                            <input type="number" wire:model="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" min="0">
                                            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bed_count" class="form-label">Numero letti</label>
                                            <input type="number" wire:model="bed_count" class="form-control @error('bed_count') is-invalid @enderror" id="bed_count" min="0">
                                            @error('bed_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bath_count" class="form-label">Bagni</label>
                                            <input type="number" wire:model="bath_count" class="form-control @error('bath_count') is-invalid @enderror" id="bath_count" min="0">
                                            @error('bath_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <!-- Rimosso person_count: si usa capacity -->
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch mb-3">
                                            <input type="checkbox" wire:model="wifi" class="form-check-input" id="wifi">
                                            <label class="form-check-label" for="wifi">WiFi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch mb-3">
                                            <input type="checkbox" wire:model="air_conditioning" class="form-check-input" id="air_conditioning">
                                            <label class="form-check-label" for="air_conditioning">Aria condizionata</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch mb-3">
                                            <input type="checkbox" wire:model="tv_cable" class="form-check-input" id="tv_cable">
                                            <label class="form-check-label" for="tv_cable">TV</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="services" class="form-label">Servizi</label>
                                    <textarea wire:model="services" class="form-control @error('services') is-invalid @enderror" 
                                              id="services" rows="3" placeholder="Servizi separati da virgola"></textarea>
                                    @error('services') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active">
                                        <label class="form-check-label" for="is_active">
                                            Camera attiva
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Immagine {{ !$editingRoom ? '*' : '' }}
                                    </label>
                                    
                                    <!-- File Input -->
                                    <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" accept="image/*">
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    
                                    <!-- Image Preview -->
                                    @if($image)
                                        <div class="mt-2">
                                            <img src="{{ $image->temporaryUrl() }}" alt="Preview" 
                                                 class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @elseif($editingRoom && $editingRoom->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $editingRoom->image) }}" alt="Current" 
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
                                {{ $editingRoom ? 'Aggiorna' : 'Crea' }}
                            </button>
                            <button type="button" wire:click="cancel" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annulla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if($editingRoom)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Galleria Camera</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Aggiungi immagini</label>
                            <input type="file" wire:model="roomGalleryImages" class="form-control" accept="image/*" multiple>
                            @error('roomGalleryImages') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            @error('roomGalleryImages.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <button class="btn btn-outline-primary mt-2" wire:click="uploadRoomGalleryImages" wire:loading.attr="disabled">
                                <i class="fas fa-upload me-2"></i>Carica selezionate
                            </button>
                            <div class="form-text">Puoi selezionare più file insieme.</div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($roomImages as $img)
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <div class="position-relative border rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="" class="w-100" style="height: 160px; object-fit: cover;">
                                    <div class="p-2 d-flex justify-content-between align-items-center">
                                        <button class="btn btn-sm btn-outline-danger" wire:click="removeRoomImage({{ $img->id }})"><i class="fas fa-trash"></i></button>
                                        <button class="btn btn-sm {{ $img->is_primary ? 'btn-success' : 'btn-outline-secondary' }}" wire:click="makePrimary({{ $img->id }})">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if(count($roomImages) === 0)
                            <div class="text-muted">Nessuna immagine in galleria.</div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Rooms List -->
        @if($rooms->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Immagine</th>
                                    <th>Nome</th>
                                    <th>Prezzo</th>
                                    <th>Capacità</th>
                                    <th>Tipo Letto</th>
                                    <th>Stato</th>
                                    <th>Ordine</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>
                                            @if($room->image)
                                                <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" 
                                                     class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">Nessuna immagine</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $room->name }}</strong>
                                            @if($room->size)
                                                <br><small class="text-muted">{{ $room->size }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>€{{ number_format($room->price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $room->capacity }} {{ $room->capacity == 1 ? 'persona' : 'persone' }}</span>
                                        </td>
                                        <td>{{ $room->bed_type ?: '-' }}</td>
                                        <td>
                                            <button wire:click="toggleActive({{ $room->id }})" 
                                                    class="btn btn-sm {{ $room->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $room->is_active ? 'Attiva' : 'Inattiva' }}
                                            </button>
                                        </td>
                                        <td>{{ $room->sort_order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button wire:click="edit({{ $room->id }})" 
                                                        class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="delete({{ $room->id }})" 
                                                        wire:confirm="Sei sicuro di voler eliminare questa camera?"
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
                    <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nessuna camera trovata</h5>
                    <p class="text-muted">Inizia creando la tua prima camera.</p>
                    <button wire:click="create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Crea Prima Camera
                    </button>
                </div>
            </div>
        @endif

    <!-- Trix Editor JS -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <script>
    document.addEventListener('livewire:init', function () {
        // Listen to Trix changes and update Livewire immediately
        document.addEventListener('trix-change', function(event) {
            if (event.target && event.target.input && event.target.input.id === 'description') {
                const hiddenInput = document.getElementById('description');
                if (hiddenInput) {
                    try {
                        const trixContent = hiddenInput.value || '';
                        @this.set('description', trixContent);
                    } catch (e) {
                        // Component not available, ignore
                    }
                }
            }
        });
        
        // Also listen for Trix input events
        document.addEventListener('trix-input', function(event) {
            if (event.target && event.target.input && event.target.input.id === 'description') {
                const hiddenInput = document.getElementById('description');
                if (hiddenInput) {
                    try {
                        const trixContent = hiddenInput.value || '';
                        @this.set('description', trixContent);
                    } catch (e) {
                        // Component not available, ignore
                    }
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
            
            try {
                const livewireDescription = @this.description || '';
                
                if (!livewireDescription.trim()) {
                    return false;
                }
                
                const currentInputValue = descriptionInput.value || '';
                const currentTrixHTML = trixEditor.editor.getDocument().toString();
                
                if (currentInputValue !== livewireDescription && currentTrixHTML !== livewireDescription) {
                    trixEditor.editor.loadHTML(livewireDescription);
                    descriptionInput.value = livewireDescription;
                    return true;
                }
            } catch (e) {
                // Component not available, ignore
                return false;
            }
            return false;
        }
        
        // Function to sync Trix and submit form
        window.syncAndSubmitRoom = function() {
            // Sync all form fields explicitly
            const nameInput = document.getElementById('name');
            if (nameInput) {
                @this.set('name', nameInput.value || '');
            }
            
            // Sync Trix description - this is critical
            const descriptionInput = document.getElementById('description');
            if (descriptionInput) {
                const trixContent = descriptionInput.value || '';
                // Update Livewire with Trix content
                @this.set('description', trixContent);
            }
            
            // Sync other fields that might not be synced
            const priceInput = document.getElementById('price');
            if (priceInput) {
                @this.set('price', parseFloat(priceInput.value) || 0);
            }
            
            const capacityInput = document.getElementById('capacity');
            if (capacityInput) {
                @this.set('capacity', parseInt(capacityInput.value) || 1);
            }
            
            // Wait a bit longer for Livewire to process all updates, then call save
            setTimeout(() => {
                @this.call('save');
            }, 500);
        };
        
        // Sync Trix when Livewire updates description
        Livewire.hook('morph.updated', ({ component }) => {
            setTimeout(() => {
                syncTrixWithLivewire();
            }, 100);
        });
        
        // Sync when component is loaded
        setTimeout(() => {
            syncTrixWithLivewire();
        }, 500);
    });
    </script>
</div>


