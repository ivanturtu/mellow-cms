<div class="image-sortable-component">
    @if(count($images) > 0)
        <div class="sortable-grid" id="sortable-grid-{{ $id }}">
            @foreach($images as $index => $image)
                <div class="sortable-item" data-id="{{ $image['id'] }}" data-index="{{ $index }}">
                    <div class="image-card">
                        <!-- Image -->
                        <div class="image-container">
                            @if(isset($image['image']) && $image['image'])
                                <img src="{{ asset('storage/' . $image['image']) }}" 
                                     alt="{{ $image['title'] ?? 'Immagine' }}" 
                                     class="img-fluid">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                            
                            <!-- Drag Handle -->
                            <div class="drag-handle">
                                <i class="fas fa-grip-vertical"></i>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="status-badge">
                                @if(isset($image['is_active']) && $image['is_active'])
                                    <span class="badge bg-success">Attivo</span>
                                @else
                                    <span class="badge bg-secondary">Inattivo</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Image Info -->
                        <div class="image-info">
                            <h6 class="image-title">{{ $image['title'] ?? 'Senza titolo' }}</h6>
                            @if(isset($image['description']) && $image['description'])
                                <p class="image-description">{{ Str::limit($image['description'], 50) }}</p>
                            @endif
                            @if(isset($image['category']) && $image['category'])
                                <span class="badge bg-info">{{ $image['category'] }}</span>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="image-actions">
                            <button type="button" 
                                    wire:click="toggleActive({{ $image['id'] }})"
                                    class="btn btn-sm {{ isset($image['is_active']) && $image['is_active'] ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ isset($image['is_active']) && $image['is_active'] ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                            <button type="button" 
                                    wire:click="removeImage({{ $image['id'] }})"
                                    wire:confirm="Sei sicuro di voler eliminare questa immagine?"
                                    class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Nessuna immagine trovata</h5>
            <p class="text-muted">Trascina le immagini qui per iniziare.</p>
        </div>
    @endif

    <style>
.image-sortable-component {
    min-height: 200px;
}

.sortable-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
    padding: 1rem 0;
}

.sortable-item {
    cursor: move;
    transition: all 0.3s ease;
}

.sortable-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.sortable-item.sortable-ghost {
    opacity: 0.4;
}

.sortable-item.sortable-chosen {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.image-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background-color: #f8f9fa;
}

.drag-handle {
    position: absolute;
    top: 8px;
    left: 8px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: grab;
}

.drag-handle:active {
    cursor: grabbing;
}

.status-badge {
    position: absolute;
    top: 8px;
    right: 8px;
}

.image-info {
    padding: 1rem;
}

.image-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.image-description {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.image-actions {
    padding: 0.5rem 1rem 1rem;
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.image-actions .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize SortableJS
    const sortableGrid = document.getElementById('sortable-grid-{{ $id }}');
    
    if (sortableGrid) {
        new Sortable(sortableGrid, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            handle: '.drag-handle',
            onEnd: function(evt) {
                const orderedIds = Array.from(sortableGrid.children).map(item => {
                    return parseInt(item.dataset.id);
                });
                
                @this.updateOrder(orderedIds);
            }
        });
    }
});

// Listen for Livewire events
document.addEventListener('livewire:init', function () {
    Livewire.on('orderUpdated', () => {
        // Optionally show a success message
        console.log('Ordine aggiornato');
    });
    
    Livewire.on('imageRemoved', (id) => {
        console.log('Immagine rimossa:', id);
    });
    
    Livewire.on('statusUpdated', (id) => {
        console.log('Stato aggiornato:', id);
    });
});
</script>

<!-- Include SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</div>