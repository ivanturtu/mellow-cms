<div class="image-upload-component">
    <!-- Drop Zone -->
    <div class="drop-zone {{ $dragOver ? 'drag-over' : '' }}" 
         wire:drop="drop"
         wire:dragover="dragOver"
         wire:dragleave="dragLeave"
         onclick="document.getElementById('image-input-{{ $id }}').click()">
        
        <div class="drop-zone-content text-center">
            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Trascina le immagini qui</h5>
            <p class="text-muted small">oppure clicca per selezionare</p>
            <p class="text-muted small">
                Formati supportati: JPEG, PNG, JPG, GIF<br>
                Dimensione massima: {{ $maxSize }}KB<br>
                Massimo {{ $maxFiles }} file
            </p>
        </div>
        
        <input type="file" 
               id="image-input-{{ $id }}" 
               wire:model="images" 
               multiple 
               accept="image/*" 
               style="display: none;">
    </div>

    <!-- Uploaded Images Grid -->
    @if(count($uploadedImages) > 0)
        <div class="uploaded-images mt-4">
            <h6 class="mb-3">Immagini caricate ({{ count($uploadedImages) }})</h6>
            <div class="row">
                @foreach($uploadedImages as $index => $image)
                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                        <div class="image-item position-relative">
                            <img src="{{ $image['url'] }}" 
                                 alt="{{ $image['name'] }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="width: 100%; height: 150px; object-fit: cover;">
                            
                            <!-- Remove Button -->
                            <button type="button" 
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                    wire:click="removeImage({{ $index }})"
                                    onclick="return confirm('Sei sicuro di voler eliminare questa immagine?')">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <!-- Image Info -->
                            <div class="image-info position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2">
                                <small class="d-block text-truncate">{{ $image['name'] }}</small>
                                <small class="text-muted">{{ number_format($image['size'] / 1024, 1) }} KB</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Loading State -->
    <div wire:loading wire:target="images" class="text-center mt-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Caricamento...</span>
        </div>
        <p class="text-muted mt-2">Caricamento immagini...</p>
    </div>

    <style>
    .drop-zone {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .drop-zone:hover {
        border-color: #007bff;
        background-color: #e3f2fd;
    }

    .drop-zone.drag-over {
        border-color: #007bff;
        background-color: #e3f2fd;
        transform: scale(1.02);
    }

    .drop-zone-content {
        pointer-events: none;
    }

    .image-item {
        transition: transform 0.2s ease;
    }

    .image-item:hover {
        transform: scale(1.05);
    }

    .uploaded-images {
        border-top: 1px solid #dee2e6;
        padding-top: 1rem;
    }

    .image-info {
        font-size: 0.75rem;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle drag and drop events
        const dropZone = document.querySelector('.drop-zone');
        
        if (dropZone) {
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop zone when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            // Handle dropped files
            dropZone.addEventListener('drop', handleDrop, false);
        }

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropZone.classList.add('drag-over');
        }

        function unhighlight(e) {
            dropZone.classList.remove('drag-over');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                // Trigger file input with dropped files
                const input = document.getElementById('image-input-{{ $id }}');
                if (input) {
                    input.files = files;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        }
    });
    </script>
</div>