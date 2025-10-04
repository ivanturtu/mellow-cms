<x-layouts.admin title="Modifica Articolo Blog">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Modifica Articolo Blog</h2>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Torna alla Lista
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titolo *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Riassunto</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" placeholder="Breve descrizione dell'articolo...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenuto *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Categoria</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                           id="category" name="category" value="{{ old('category', $blog->category) }}" placeholder="es. Hotel, Eventi, News">
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Data Pubblicazione</label>
                                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" name="published_at" 
                                           value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                       value="1" {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Pubblicato
                                </label>
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

                        @if($blog->image)
                            <div class="mb-3">
                                <label class="form-label">Immagine Attuale</label>
                                <div>
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" 
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
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Aggiorna Articolo
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

        // Auto-fill published_at when is_published is checked
        document.getElementById('is_published').addEventListener('change', function(e) {
            if (e.target.checked && !document.getElementById('published_at').value) {
                const now = new Date();
                const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
                document.getElementById('published_at').value = localDateTime;
            }
        });
    </script>
</x-layouts.admin>
