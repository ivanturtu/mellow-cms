<div class="about-management-component">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestione Sezione About</h2>
                <button type="button" class="btn btn-primary" wire:click="create" data-bs-toggle="modal" data-bs-target="#aboutModal">
                    <i class="fas fa-plus"></i> Aggiungi Sezione About
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
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cerca sezioni About...">
            </div>

            <!-- About Sections Table -->
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Titolo</th>
                            <th>Sottotitolo</th>
                            <th>CTA</th>
                            <th>Immagini</th>
                            <th>Ordinamento</th>
                            <th>Stato</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aboutSections as $aboutSection)
                            <tr>
                                <td>{{ $aboutSection->title }}</td>
                                <td>{{ $aboutSection->subtitle ?? 'N/A' }}</td>
                                <td>{{ $aboutSection->cta_text ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $imageCount = 0;
                                        if($aboutSection->image_1) $imageCount++;
                                        if($aboutSection->image_2) $imageCount++;
                                        if($aboutSection->image_3) $imageCount++;
                                    @endphp
                                    {{ $imageCount }}/3
                                </td>
                                <td>{{ $aboutSection->sort_order }}</td>
                                <td>
                                    <span class="badge bg-{{ $aboutSection->is_active ? 'success' : 'secondary' }}">
                                        {{ $aboutSection->is_active ? 'Attivo' : 'Inattivo' }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info me-2" wire:click="edit({{ $aboutSection->id }})" data-bs-toggle="modal" data-bs-target="#aboutModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ $aboutSection->id }})" wire:confirm="Sei sicuro di voler eliminare questa sezione About?">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm {{ $aboutSection->is_active ? 'btn-warning' : 'btn-success' }}" wire:click="toggleActive({{ $aboutSection->id }})">
                                        <i class="fas fa-{{ $aboutSection->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nessuna sezione About trovata.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $aboutSections->links() }}
        </div>
    </div>

    <!-- About Modal -->
    <div wire:ignore.self class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutModalLabel">{{ $editing ? 'Modifica Sezione About' : 'Aggiungi Sezione About' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Titolo *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" wire:model="title" placeholder="es. Civico 41: Il Vostro Gateway">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subtitle" class="form-label">Sottotitolo</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                       id="subtitle" wire:model="subtitle" placeholder="es. Alla Valle Peligna">
                                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" wire:model="description" rows="4" 
                                      placeholder="Descrizione della sezione About..."></textarea>
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
                                @elseif($editing && $aboutSection && $aboutSection->image_1)
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
                                @elseif($editing && $aboutSection && $aboutSection->image_2)
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
                                @elseif($editing && $aboutSection && $aboutSection->image_3)
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">{{ $editing ? 'Aggiorna' : 'Crea' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:init', function () {
    Livewire.on('openModal', () => {
        const modal = new bootstrap.Modal(document.getElementById('aboutModal'));
        modal.show();
    });
    
    Livewire.on('closeModal', () => {
        const modalElement = document.getElementById('aboutModal');
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
        const modalElement = document.getElementById('aboutModal');
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
    
    // Gestione overlay per il modal About
    document.addEventListener('DOMContentLoaded', function() {
        const aboutModal = document.getElementById('aboutModal');
        if (aboutModal) {
            aboutModal.addEventListener('hidden.bs.modal', function () {
                // Rimuovi l'overlay quando il modal si chiude
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        }
    });
});
</script>