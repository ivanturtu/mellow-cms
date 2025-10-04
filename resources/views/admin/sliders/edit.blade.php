<x-layouts.admin title="Modifica Slider">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Modifica Slider</h2>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Torna alla Lista
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titolo *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $slider->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $slider->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cta_text" class="form-label">Testo CTA</label>
                                    <input type="text" class="form-control @error('cta_text') is-invalid @enderror" 
                                           id="cta_text" name="cta_text" value="{{ old('cta_text', $slider->cta_text) }}">
                                    @error('cta_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cta_link" class="form-label">Link CTA</label>
                                    <input type="text" class="form-control @error('cta_link') is-invalid @enderror" 
                                           id="cta_link" name="cta_link" value="{{ old('cta_link', $slider->cta_link) }}">
                                    @error('cta_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Ordine</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Attivo
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

                        @if($slider->image)
                            <div class="mb-3">
                                <label class="form-label">Immagine Attuale</label>
                                <div>
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" 
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
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Aggiorna Slider
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

