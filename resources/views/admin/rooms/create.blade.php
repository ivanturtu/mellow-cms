<x-layouts.admin title="Nuova Camera">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nuova Camera</h2>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Torna alla Lista
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Camera *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Prezzo per Notte (€) *</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price') }}" required>
                                        <span class="input-group-text bg-primary text-white">€</span>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="show_price" name="show_price" 
                                               value="1" {{ old('show_price', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_price">
                                            Mostra prezzo (se deselezionato, mostra "Prezzi su richiesta")
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacità (persone) *</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                           id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
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
                                           id="size" name="size" value="{{ old('size') }}" placeholder="es. 35 m²">
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bed_type" class="form-label">Tipo di Letto</label>
                                    <input type="text" class="form-control @error('bed_type') is-invalid @enderror" 
                                           id="bed_type" name="bed_type" value="{{ old('bed_type') }}" placeholder="es. King Size">
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
                                      placeholder="es. WiFi, TV, Minibar, Aria condizionata, Bagno privato">{{ old('services') }}</textarea>
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
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active') ? 'checked' : '' }}>
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
                            <label for="image" class="form-label">Immagine *</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Formati supportati: JPEG, PNG, JPG, GIF. Max 2MB.</div>
                        </div>

                        <div id="image-preview" class="mt-3" style="display: none;">
                            <img id="preview-img" src="" alt="Preview" class="img-fluid rounded">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salva Camera
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

