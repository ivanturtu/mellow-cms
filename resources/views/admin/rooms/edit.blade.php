<x-layouts.admin title="Modifica Camera">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Modifica Camera</h2>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Torna alla Lista
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Camera *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $room->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Prezzo per Notte (€) *</label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $room->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacità (persone) *</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                           id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="size" class="form-label">Dimensione</label>
                                    <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                           id="size" name="size" value="{{ old('size', $room->size) }}" placeholder="es. 35 m²">
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bed_type" class="form-label">Tipo di Letto</label>
                                    <input type="text" class="form-control @error('bed_type') is-invalid @enderror" 
                                           id="bed_type" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}" placeholder="es. King Size">
                                    @error('bed_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="services" class="form-label">Servizi</label>
                            <textarea class="form-control @error('services') is-invalid @enderror" 
                                      id="services" name="services" rows="2" 
                                      placeholder="es. WiFi, TV, Minibar, Aria condizionata, Bagno privato">{{ old('services', $room->services) }}</textarea>
                            @error('services')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Separare i servizi con virgole.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Ordine</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $room->sort_order) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Attiva
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Nuova Immagine</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lascia vuoto per mantenere l'immagine attuale. Formati supportati: JPEG, PNG, JPG, GIF. Max 2MB.</div>
                        </div>

                        @if($room->image)
                            <div class="mb-3">
                                <label class="form-label">Immagine Attuale</label>
                                <div>
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" 
                                         class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        @endif

                        <div id="image-preview" class="mt-3" style="display: none;">
                            <label class="form-label">Anteprima Nuova Immagine</label>
                            <img id="preview-img" src="" alt="Preview" class="img-fluid rounded">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Aggiorna Camera
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('image-preview').style.display = 'none';
            }
        });
    </script>
</x-layouts.admin>

