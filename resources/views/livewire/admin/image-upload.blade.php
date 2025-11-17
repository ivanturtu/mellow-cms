<div class="image-upload-component" id="image-upload-component-{{ $id }}">
    <!-- Drop Zone -->
    <div class="drop-zone {{ $dragOver ? 'drag-over' : '' }}" 
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
    (function() {
        const componentId = '{{ $id }}';
        const inputId = 'image-input-' + componentId;
        
        console.log('[ImageUpload Debug] Component ID:', componentId);
        console.log('[ImageUpload Debug] Input ID:', inputId);
        
        function initDragAndDrop() {
            // Find drop zone - use a more specific selector
            const dropZone = document.querySelector('#image-upload-component-' + componentId + ' .drop-zone') || 
                            document.querySelector('.drop-zone');
            
            console.log('[ImageUpload Debug] Drop zone found:', !!dropZone);
            
            if (!dropZone) {
                console.warn('[ImageUpload Debug] Drop zone not found, retrying in 100ms...');
                setTimeout(initDragAndDrop, 100);
                return;
            }
            
            const input = document.getElementById(inputId);
            console.log('[ImageUpload Debug] Input element found:', !!input);
            
            if (!input) {
                console.error('[ImageUpload Debug] Input element not found with ID:', inputId);
                return;
            }

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop zone when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, function(e) {
                    console.log('[ImageUpload Debug] Event:', eventName);
                    highlight(e);
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, function(e) {
                    console.log('[ImageUpload Debug] Event:', eventName);
                    unhighlight(e);
                }, false);
            });

            // Handle dropped files
            dropZone.addEventListener('drop', function(e) {
                console.log('[ImageUpload Debug] Drop event triggered');
                handleDrop(e);
            }, false);
            
            console.log('[ImageUpload Debug] Drag & drop initialized successfully');
        }

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            const dropZone = document.querySelector('#image-upload-component-' + componentId + ' .drop-zone') || 
                            document.querySelector('.drop-zone');
            if (dropZone) {
                dropZone.classList.add('drag-over');
                console.log('[ImageUpload Debug] Drop zone highlighted');
            }
        }

        function unhighlight(e) {
            const dropZone = document.querySelector('#image-upload-component-' + componentId + ' .drop-zone') || 
                            document.querySelector('.drop-zone');
            if (dropZone) {
                dropZone.classList.remove('drag-over');
                console.log('[ImageUpload Debug] Drop zone unhighlighted');
            }
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            console.log('[ImageUpload Debug] Files dropped:', files.length);
            
            if (files.length > 0) {
                // Log file details
                for (let i = 0; i < files.length; i++) {
                    console.log('[ImageUpload Debug] File', i + ':', {
                        name: files[i].name,
                        type: files[i].type,
                        size: files[i].size
                    });
                }
                
                // Trigger file input with dropped files
                const input = document.getElementById(inputId);
                if (input) {
                    // Create a new DataTransfer object to set files
                    const dataTransfer = new DataTransfer();
                    for (let i = 0; i < files.length; i++) {
                        dataTransfer.items.add(files[i]);
                    }
                    input.files = dataTransfer.files;
                    
                    console.log('[ImageUpload Debug] Files assigned to input, triggering change event');
                    
                    // Trigger change event - Livewire will pick this up via wire:model
                    const changeEvent = new Event('change', { bubbles: true, cancelable: true });
                    input.dispatchEvent(changeEvent);
                    
                    // Also trigger input event for better compatibility
                    const inputEvent = new Event('input', { bubbles: true, cancelable: true });
                    input.dispatchEvent(inputEvent);
                    
                    console.log('[ImageUpload Debug] Events dispatched, waiting for Livewire...');
                } else {
                    console.error('[ImageUpload Debug] Input element not found when handling drop');
                }
            }
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDragAndDrop);
        } else {
            initDragAndDrop();
        }
        
        // Also try to initialize after Livewire loads
        document.addEventListener('livewire:init', function() {
            console.log('[ImageUpload Debug] Livewire initialized, reinitializing drag & drop');
            setTimeout(initDragAndDrop, 100);
        });
        
        // Reinitialize when component is updated (if Livewire hooks are available)
        if (window.Livewire && typeof Livewire.hook === 'function') {
            Livewire.hook('morph.updated', ({ component }) => {
                console.log('[ImageUpload Debug] Component updated, reinitializing drag & drop');
                setTimeout(initDragAndDrop, 100);
            });
        }
        
        // Alternative: Use MutationObserver to detect when modal opens
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    const dropZone = document.querySelector('#image-upload-component-' + componentId + ' .drop-zone');
                    if (dropZone && !dropZone.hasAttribute('data-drag-initialized')) {
                        console.log('[ImageUpload Debug] Drop zone detected in DOM, initializing...');
                        dropZone.setAttribute('data-drag-initialized', 'true');
                        setTimeout(initDragAndDrop, 50);
                    }
                }
            });
        });
        
        // Observe the document body for changes
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    })();
    </script>
</div>