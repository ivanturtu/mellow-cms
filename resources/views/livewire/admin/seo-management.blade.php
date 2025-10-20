<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestione SEO</h2>
        <div>
            <button wire:click="resetToDefaults" class="btn btn-outline-secondary me-2">
                <i class="fas fa-undo me-2"></i>Ripristina
            </button>
            <button wire:click="save" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Salva Impostazioni
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs mb-4" id="seoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                    <i class="fas fa-cog me-2"></i>Generale
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages" type="button" role="tab">
                    <i class="fas fa-file-alt me-2"></i>Pagine
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                    <i class="fas fa-share-alt me-2"></i>Social Media
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="technical-tab" data-bs-toggle="tab" data-bs-target="#technical" type="button" role="tab">
                    <i class="fas fa-code me-2"></i>Tecnico
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab">
                    <i class="fas fa-cogs me-2"></i>Avanzato
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="seoTabsContent">
            <!-- General SEO Tab -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Impostazioni SEO Generali</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_title" class="form-label">Titolo del Sito *</label>
                                    <input type="text" wire:model="site_title" class="form-control @error('site_title') is-invalid @enderror" id="site_title" maxlength="255">
                                    @error('site_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">Titolo principale del sito (max 60 caratteri)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Descrizione del Sito *</label>
                                    <textarea wire:model="site_description" class="form-control @error('site_description') is-invalid @enderror" id="site_description" rows="3" maxlength="500"></textarea>
                                    @error('site_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">Descrizione principale del sito (max 160 caratteri)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="site_keywords" class="form-label">Parole Chiave *</label>
                                    <input type="text" wire:model="site_keywords" class="form-control @error('site_keywords') is-invalid @enderror" id="site_keywords" maxlength="500">
                                    @error('site_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">Parole chiave separate da virgola</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_author" class="form-label">Autore del Sito *</label>
                                    <input type="text" wire:model="site_author" class="form-control @error('site_author') is-invalid @enderror" id="site_author" maxlength="255">
                                    @error('site_author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Nome del Sito *</label>
                                    <input type="text" wire:model="site_name" class="form-control @error('site_name') is-invalid @enderror" id="site_name" maxlength="255">
                                    @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="hreflang" class="form-label">Lingua del Sito</label>
                                    <select wire:model="hreflang" class="form-control @error('hreflang') is-invalid @enderror" id="hreflang">
                                        <option value="it">Italiano (it)</option>
                                        <option value="en">English (en)</option>
                                        <option value="fr">Français (fr)</option>
                                        <option value="de">Deutsch (de)</option>
                                        <option value="es">Español (es)</option>
                                    </select>
                                    @error('hreflang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pages SEO Tab -->
            <div class="tab-pane fade" id="pages" role="tabpanel">
                <div class="row">
                    <!-- Homepage SEO -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Homepage</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="home_title" class="form-label">Titolo Homepage *</label>
                                    <input type="text" wire:model="home_title" class="form-control @error('home_title') is-invalid @enderror" id="home_title" maxlength="255">
                                    @error('home_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="home_description" class="form-label">Descrizione Homepage *</label>
                                    <textarea wire:model="home_description" class="form-control @error('home_description') is-invalid @enderror" id="home_description" rows="3" maxlength="500"></textarea>
                                    @error('home_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="home_keywords" class="form-label">Parole Chiave Homepage *</label>
                                    <input type="text" wire:model="home_keywords" class="form-control @error('home_keywords') is-invalid @enderror" id="home_keywords" maxlength="500">
                                    @error('home_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rooms SEO -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Camere</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="rooms_title" class="form-label">Titolo Camere *</label>
                                    <input type="text" wire:model="rooms_title" class="form-control @error('rooms_title') is-invalid @enderror" id="rooms_title" maxlength="255">
                                    @error('rooms_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="rooms_description" class="form-label">Descrizione Camere *</label>
                                    <textarea wire:model="rooms_description" class="form-control @error('rooms_description') is-invalid @enderror" id="rooms_description" rows="3" maxlength="500"></textarea>
                                    @error('rooms_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="rooms_keywords" class="form-label">Parole Chiave Camere *</label>
                                    <input type="text" wire:model="rooms_keywords" class="form-control @error('rooms_keywords') is-invalid @enderror" id="rooms_keywords" maxlength="500">
                                    @error('rooms_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog SEO -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Blog</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="blog_title" class="form-label">Titolo Blog *</label>
                                    <input type="text" wire:model="blog_title" class="form-control @error('blog_title') is-invalid @enderror" id="blog_title" maxlength="255">
                                    @error('blog_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="blog_description" class="form-label">Descrizione Blog *</label>
                                    <textarea wire:model="blog_description" class="form-control @error('blog_description') is-invalid @enderror" id="blog_description" rows="3" maxlength="500"></textarea>
                                    @error('blog_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="blog_keywords" class="form-label">Parole Chiave Blog *</label>
                                    <input type="text" wire:model="blog_keywords" class="form-control @error('blog_keywords') is-invalid @enderror" id="blog_keywords" maxlength="500">
                                    @error('blog_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact SEO -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Contatti</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="contact_title" class="form-label">Titolo Contatti *</label>
                                    <input type="text" wire:model="contact_title" class="form-control @error('contact_title') is-invalid @enderror" id="contact_title" maxlength="255">
                                    @error('contact_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_description" class="form-label">Descrizione Contatti *</label>
                                    <textarea wire:model="contact_description" class="form-control @error('contact_description') is-invalid @enderror" id="contact_description" rows="3" maxlength="500"></textarea>
                                    @error('contact_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_keywords" class="form-label">Parole Chiave Contatti *</label>
                                    <input type="text" wire:model="contact_keywords" class="form-control @error('contact_keywords') is-invalid @enderror" id="contact_keywords" maxlength="500">
                                    @error('contact_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div class="tab-pane fade" id="social" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Social Media & Open Graph</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="og_image" class="form-label">Immagine Open Graph</label>
                                    <input type="url" wire:model="og_image" class="form-control @error('og_image') is-invalid @enderror" id="og_image" placeholder="https://example.com/og-image.jpg">
                                    @error('og_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">URL dell'immagine per condivisioni social (1200x630px)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_handle" class="form-label">Twitter Handle</label>
                                    <input type="text" wire:model="twitter_handle" class="form-control @error('twitter_handle') is-invalid @enderror" id="twitter_handle" placeholder="@hotelmellow">
                                    @error('twitter_handle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">URL Facebook</label>
                                    <input type="url" wire:model="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" placeholder="https://facebook.com/hotelmellow">
                                    @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">URL Instagram</label>
                                    <input type="url" wire:model="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" placeholder="https://instagram.com/hotelmellow">
                                    @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical SEO Tab -->
            <div class="tab-pane fade" id="technical" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Analytics & Tracking</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="google_analytics" class="form-label">Google Analytics ID</label>
                                    <input type="text" wire:model="google_analytics" class="form-control @error('google_analytics') is-invalid @enderror" id="google_analytics" placeholder="G-XXXXXXXXXX">
                                    @error('google_analytics') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="google_tag_manager" class="form-label">Google Tag Manager ID</label>
                                    <input type="text" wire:model="google_tag_manager" class="form-control @error('google_tag_manager') is-invalid @enderror" id="google_tag_manager" placeholder="GTM-XXXXXXX">
                                    @error('google_tag_manager') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="google_search_console" class="form-label">Google Search Console</label>
                                    <input type="text" wire:model="google_search_console" class="form-control @error('google_search_console') is-invalid @enderror" id="google_search_console" placeholder="Meta tag verification">
                                    @error('google_search_console') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="facebook_pixel" class="form-label">Facebook Pixel ID</label>
                                    <input type="text" wire:model="facebook_pixel" class="form-control @error('facebook_pixel') is-invalid @enderror" id="facebook_pixel" placeholder="123456789012345">
                                    @error('facebook_pixel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced SEO Tab -->
            <div class="tab-pane fade" id="advanced" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Impostazioni Avanzate</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="canonical_domain" class="form-label">Dominio Canonico</label>
                                    <input type="url" wire:model="canonical_domain" class="form-control @error('canonical_domain') is-invalid @enderror" id="canonical_domain" placeholder="https://www.hotelmellow.com">
                                    @error('canonical_domain') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">Dominio principale per canonical URLs</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="robots_txt" class="form-label">Robots.txt Personalizzato</label>
                                    <textarea wire:model="robots_txt" class="form-control @error('robots_txt') is-invalid @enderror" id="robots_txt" rows="4" maxlength="1000"></textarea>
                                    @error('robots_txt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">Contenuto personalizzato per robots.txt</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i>Salva Tutte le Impostazioni SEO
            </button>
        </div>
    </form>
</div>