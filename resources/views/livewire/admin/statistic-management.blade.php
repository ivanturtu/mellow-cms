<div class="statistic-management-component">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestione Statistiche</h2>
                <button type="button" class="btn btn-primary" wire:click="create" data-bs-toggle="modal" data-bs-target="#statisticModal">
                    <i class="fas fa-plus"></i> Aggiungi Statistica
                </button>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search -->
            <div class="mb-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cerca statistiche...">
            </div>

            <!-- Statistics Table -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Titolo</th>
                            <th>Valore</th>
                            <th>Icona</th>
                            <th>Ordinamento</th>
                            <th>Stato</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics as $statistic)
                            <tr>
                                <td>{{ $statistic->title }}</td>
                                <td><strong>{{ $statistic->value }}</strong></td>
                                <td>
                                    @if($statistic->icon)
                                        <i class="{{ $statistic->icon }}"></i>
                                    @else
                                        <span class="text-muted">Nessuna</span>
                                    @endif
                                </td>
                                <td>{{ $statistic->sort_order }}</td>
                                <td>
                                    <span class="badge {{ $statistic->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $statistic->is_active ? 'Attivo' : 'Inattivo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                wire:click="edit({{ $statistic->id }})" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#statisticModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm {{ $statistic->is_active ? 'btn-warning' : 'btn-success' }}" 
                                                wire:click="toggleActive({{ $statistic->id }})">
                                            <i class="fas fa-{{ $statistic->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                wire:click="delete({{ $statistic->id }})"
                                                wire:confirm="Sei sicuro di voler eliminare questa statistica?">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nessuna statistica trovata</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $statistics->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="statisticModal" tabindex="-1" aria-labelledby="statisticModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statisticModalLabel">
                        {{ $editing ? 'Modifica Statistica' : 'Aggiungi Statistica' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Titolo *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" wire:model="title" placeholder="es. Clienti Soddisfatti">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">Valore *</label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror" 
                                       id="value" wire:model="value" placeholder="es. 25K">
                                @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="icon" class="form-label">Icona</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" wire:model="icon" placeholder="es. fas fa-users">
                                <small class="form-text text-muted">Classe CSS dell'icona (FontAwesome)</small>
                                @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Ordinamento *</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" wire:model="sort_order" min="0">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" wire:model="description" rows="3" 
                                      placeholder="Descrizione opzionale della statistica"></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                                <label class="form-check-label" for="is_active">
                                    Statistica attiva
                                </label>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            <button type="submit" class="btn btn-primary">
                                {{ $editing ? 'Aggiorna' : 'Crea' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:init', function () {
    Livewire.on('openModal', () => {
        const modal = new bootstrap.Modal(document.getElementById('statisticModal'));
        modal.show();
    });
    
    Livewire.on('closeModal', () => {
        const modalElement = document.getElementById('statisticModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        } else {
            // Se non c'è un'istanza, crea una nuova e nascondila
            const newModal = new bootstrap.Modal(modalElement);
            newModal.hide();
        }
    });
    
    Livewire.on('forceCloseModal', () => {
        // Forza la chiusura del modal e rimuovi l'overlay
        const modalElement = document.getElementById('statisticModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
        
        // Rimuovi manualmente l'overlay se rimane
        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }, 100);
    });
});
</script>