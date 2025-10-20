<div>
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
                    <form wire:submit="save">
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
                                    <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" 
                                              id="description" rows="4" required></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Prezzo (€) *</label>
                                            <input type="number" wire:model="price" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" step="0.01" min="0" required>
                                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                    
                <!-- Drag & Drop Zone -->
                <div class="drop-zone {{ $dragOver ? 'drag-over' : '' }}" 
                     wire:drop="drop"
                     wire:dragover="dragOver"
                     wire:dragleave="dragLeave"
                     onclick="document.getElementById('image').click()">
                    
                    <div class="drop-zone-content text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Trascina l'immagine qui</h5>
                        <p class="text-muted small">oppure clicca per selezionare</p>
                        <p class="text-muted small">
                            Formati supportati: JPEG, PNG, JPG, GIF<br>
                            Dimensione massima: 2MB
                        </p>
                    </div>
                </div>
                
                <div class="text-center mt-2">
                    <small class="text-muted">oppure</small>
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

    <script>
    (function initRoomDnd(){
        function preventDefaults(e){ e.preventDefault(); e.stopPropagation(); }
        // Global prevention so browser doesn't open the file
        ['dragenter','dragover','dragleave','drop'].forEach(function(eventName){
            window.addEventListener(eventName, preventDefaults, true);
            document.addEventListener(eventName, preventDefaults, true);
        });

        // Delegated drop handler works across Livewire re-renders
        document.addEventListener('drop', function(e){
            const dropContainer = e.target && (e.target.closest ? e.target.closest('.drop-zone') : null);
            if (!dropContainer) return;
            const dt = e.dataTransfer;
            const files = dt ? dt.files : null;
            if (!files || files.length === 0) return;
            const input = document.getElementById('image');
            if (input) {
                input.files = files;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }, true);

        // Rebind after Livewire DOM morphs
        document.addEventListener('livewire:navigated', initRoomDnd, { once: true });
    })();
    </script>

</div>


