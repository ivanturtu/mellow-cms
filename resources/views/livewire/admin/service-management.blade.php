<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Servizi</h2>
        <button wire:click="create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuovo Servizio
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
                               class="form-control" placeholder="Cerca servizi...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <button wire:click="sortBy('name')" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sort-alpha-down"></i> Nome
                        </button>
                        <button wire:click="sortBy('sort_order')" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sort-numeric-down"></i> Ordine
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
                    {{ $editingService ? 'Modifica Servizio' : 'Nuovo Servizio' }}
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit="save">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Servizio *</label>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icona FontAwesome</label>
                                        <input type="text" wire:model="icon" class="form-control @error('icon') is-invalid @enderror" 
                                               id="icon" placeholder="es. fas fa-wifi, fas fa-car">
                                        @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="text-muted">Usa le classi FontAwesome (es. fas fa-wifi)</small>
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

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active">
                                    <label class="form-check-label" for="is_active">
                                        Servizio attivo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Immagine</label>
                                
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
                                @elseif($editingService && $editingService->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $editingService->image) }}" alt="Current" 
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
                            {{ $editingService ? 'Aggiorna' : 'Crea' }}
                        </button>
                        <button type="button" wire:click="cancel" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Annulla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Services List -->
    @if($services->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Icona</th>
                                <th>Nome</th>
                                <th>Descrizione</th>
                                <th>Stato</th>
                                <th>Ordine</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        @if($service->icon)
                                            <i class="{{ $service->icon }} fa-2x text-primary"></i>
                                        @elseif($service->image)
                                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" 
                                                 class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-concierge-bell fa-2x text-muted"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $service->name }}</strong>
                                    </td>
                                    <td>
                                        {{ Str::limit($service->description, 100) }}
                                    </td>
                                    <td>
                                        <button wire:click="toggleActive({{ $service->id }})" 
                                                class="btn btn-sm {{ $service->is_active ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $service->is_active ? 'Attivo' : 'Inattivo' }}
                                        </button>
                                    </td>
                                    <td>{{ $service->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $service->id }})" 
                                                    class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="delete({{ $service->id }})" 
                                                    wire:confirm="Sei sicuro di voler eliminare questo servizio?"
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
                <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessun servizio trovato</h5>
                <p class="text-muted">Inizia creando il tuo primo servizio.</p>
                <button wire:click="create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crea Primo Servizio
                </button>
            </div>
        </div>
    @endif

</div>