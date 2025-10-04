<x-layouts.admin title="Impostazioni">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Impostazioni</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- General Settings -->
                        <h5 class="mb-3">Impostazioni Generali</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hotel_name" class="form-label">Nome Hotel</label>
                                    <input type="text" class="form-control @error('hotel_name') is-invalid @enderror" 
                                           id="hotel_name" name="hotel_name" 
                                           value="{{ old('hotel_name', $settings['general']['hotel_name'] ?? '') }}">
                                    @error('hotel_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hotel_description" class="form-label">Descrizione Hotel</label>
                                    <input type="text" class="form-control @error('hotel_description') is-invalid @enderror" 
                                           id="hotel_description" name="hotel_description" 
                                           value="{{ old('hotel_description', $settings['general']['hotel_description'] ?? '') }}">
                                    @error('hotel_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Contact Settings -->
                        <h5 class="mb-3">Informazioni di Contatto</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Telefono</label>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                           id="contact_phone" name="contact_phone" 
                                           value="{{ old('contact_phone', $settings['contact']['contact_phone'] ?? '') }}">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                           id="contact_email" name="contact_email" 
                                           value="{{ old('contact_email', $settings['contact']['contact_email'] ?? '') }}">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Indirizzo</label>
                                    <input type="text" class="form-control @error('contact_address') is-invalid @enderror" 
                                           id="contact_address" name="contact_address" 
                                           value="{{ old('contact_address', $settings['contact']['contact_address'] ?? '') }}">
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salva Impostazioni
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Logo Hotel</h5>
                    
                    @if(isset($settings['general']['logo']) && $settings['general']['logo'])
                        <div class="mb-3">
                            <label class="form-label">Logo Attuale</label>
                            <div>
                                <img src="{{ asset('storage/' . $settings['general']['logo']) }}" 
                                     alt="Logo Hotel" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="logo" class="form-label">Nuovo Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Formati supportati: JPEG, PNG, JPG, GIF. Max 2MB.</div>
                        </div>

                        <div id="logo-preview" class="mt-3" style="display: none;">
                            <label class="form-label">Anteprima Nuovo Logo</label>
                            <img id="preview-logo" src="" alt="Preview" class="img-fluid rounded">
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-upload me-2"></i>Aggiorna Logo
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">Informazioni Sistema</h6>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Laravel:</strong> {{ app()->version() }}</li>
                        <li><strong>PHP:</strong> {{ PHP_VERSION }}</li>
                        <li><strong>Ambiente:</strong> {{ app()->environment() }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-logo').src = e.target.result;
                    document.getElementById('logo-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('logo-preview').style.display = 'none';
            }
        });
    </script>
</x-layouts.admin>
