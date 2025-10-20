<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Impostazioni</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSettingModal">
            <i class="fas fa-plus me-2"></i>Nuova Impostazione
        </button>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Logo Upload Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Logo del Sito</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="logo" class="form-label">Carica Logo</label>
                        <input type="file" wire:model="logo" class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" accept="image/*">
                        @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="form-text text-muted">
                            Formati supportati: JPEG, PNG, JPG, GIF, SVG. Dimensione massima: 2MB
                        </small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="button" wire:click="uploadLogo" 
                                wire:loading.attr="disabled" 
                                class="btn btn-primary"
                                @if(!$logo) disabled @endif>
                            <span wire:loading.remove wire:target="uploadLogo">
                                <i class="fas fa-upload me-2"></i>Carica Logo
                            </span>
                            <span wire:loading wire:target="uploadLogo">
                                <i class="fas fa-spinner fa-spin me-2"></i>Caricamento...
                            </span>
                        </button>
                        
                        @if($currentLogo)
                            <button type="button" wire:click="removeLogo" 
                                    wire:confirm="Sei sicuro di voler rimuovere il logo?"
                                    class="btn btn-outline-danger">
                                <i class="fas fa-trash me-2"></i>Rimuovi Logo
                            </button>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    @if($currentLogo)
                        <div class="text-center">
                            <h6>Logo Attuale</h6>
                            @if(str_starts_with($currentLogo, 'mellow/'))
                                <img src="{{ asset($currentLogo) }}" 
                                     alt="Logo attuale" 
                                     class="img-fluid border rounded"
                                     style="max-height: 150px; max-width: 200px;">
                            @else
                                <img src="{{ asset('storage/' . $currentLogo) }}" 
                                     alt="Logo attuale" 
                                     class="img-fluid border rounded"
                                     style="max-height: 150px; max-width: 200px;">
                            @endif
                            <p class="small text-muted mt-2">{{ $currentLogo }}</p>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>Nessun logo caricato</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informazioni di Contatto</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Indirizzo</label>
                        <input type="text" 
                               wire:model.lazy="settings.general.contact_address" 
                               class="form-control" 
                               placeholder="Via Roma 123, 00100 Roma, Italia">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="text" 
                               wire:model.lazy="settings.general.contact_phone" 
                               class="form-control" 
                               placeholder="+39 06 1234567">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               wire:model.lazy="settings.general.contact_email" 
                               class="form-control" 
                               placeholder="info@hotelmellow.com">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Latitudine Mappa</label>
                        <input type="text" 
                               wire:model.lazy="settings.general.map_latitude" 
                               class="form-control" 
                               placeholder="41.9028">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Longitudine Mappa</label>
                        <input type="text" 
                               wire:model.lazy="settings.general.map_longitude" 
                               class="form-control" 
                               placeholder="12.4922">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Zoom Mappa</label>
                        <input type="number" 
                               wire:model.lazy="settings.general.map_zoom" 
                               class="form-control" 
                               placeholder="15" min="1" max="20">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="button" wire:click="saveContactSettings" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Salva Informazioni Contatto
                </button>
            </div>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Social Media</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" 
                               wire:model.lazy="settings.social.facebook_url" 
                               class="form-control" 
                               placeholder="https://facebook.com/tuopagina">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" 
                               wire:model.lazy="settings.social.instagram_url" 
                               class="form-control" 
                               placeholder="https://instagram.com/tuopagina">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">TikTok URL</label>
                        <input type="url" 
                               wire:model.lazy="settings.social.tiktok_url" 
                               class="form-control" 
                               placeholder="https://tiktok.com/@tuopagina">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">WhatsApp Numero</label>
                        <input type="tel" 
                               wire:model.lazy="settings.social.whatsapp_url" 
                               class="form-control" 
                               placeholder="393123456789">
                        <small class="form-text text-muted">
                            Inserisci solo il numero (es. 393123456789) - il link WhatsApp verrà generato automaticamente
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" 
                               wire:model.lazy="settings.social.linkedin_url" 
                               class="form-control" 
                               placeholder="https://linkedin.com/company/tuopagina">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="button" wire:click="saveSocialSettings" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Salva Social Media
                </button>
            </div>
        </div>
    </div>

    <!-- Mailchimp Newsletter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Newsletter Mailchimp</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">API Key Mailchimp</label>
                        <input type="text" 
                               wire:model.lazy="settings.mailchimp.mailchimp_api_key" 
                               class="form-control" 
                               placeholder="your-api-key-here">
                        <small class="form-text text-muted">
                            Trova la tua API Key in Mailchimp > Account > Extras > API keys
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">List ID</label>
                        <input type="text" 
                               wire:model.lazy="settings.mailchimp.mailchimp_list_id" 
                               class="form-control" 
                               placeholder="your-list-id-here">
                        <small class="form-text text-muted">
                            Trova il List ID in Mailchimp > Audience > Settings > Audience name and defaults
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Server Prefix</label>
                        <input type="text" 
                               wire:model.lazy="settings.mailchimp.mailchimp_server_prefix" 
                               class="form-control" 
                               placeholder="us1">
                        <small class="form-text text-muted">
                            Di solito è "us1", "us2", "us3", etc. (vedi nella tua API Key)
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Newsletter Abilitata</label>
                        <select wire:model.lazy="settings.mailchimp.newsletter_enabled" class="form-select">
                            <option value="1">Sì</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Titolo Newsletter</label>
                        <input type="text" 
                               wire:model.lazy="settings.mailchimp.newsletter_title" 
                               class="form-control" 
                               placeholder="Iscriviti alla nostra Newsletter">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Descrizione Newsletter</label>
                        <textarea wire:model.lazy="settings.mailchimp.newsletter_description" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Ricevi le nostre offerte speciali..."></textarea>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="button" wire:click="saveMailchimpSettings" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Salva Impostazioni Newsletter
                </button>
            </div>
        </div>
    </div>


    <!-- Settings Groups -->
    @if(count($settings) > 0)
        @foreach($settings as $group => $groupSettings)
            @if($group !== 'mailchimp' && $group !== 'social' && $group !== 'general' && $group !== 'contact')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 text-capitalize">{{ $group }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($groupSettings as $key => $value)
                                <div class="col-md-6 mb-3">
                                    <label for="setting_{{ $group }}_{{ $key }}" class="form-label">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                    <div class="input-group">
                                        <input type="text" 
                                               wire:model.live.debounce.500ms="settings.{{ $group }}.{{ $key }}"
                                               wire:change="updateSetting('{{ $group }}', '{{ $key }}', $event.target.value)"
                                               class="form-control" 
                                               id="setting_{{ $group }}_{{ $key }}"
                                               value="{{ $value }}">
                                        <button class="btn btn-outline-danger" type="button"
                                                wire:click="deleteSetting('{{ $group }}', '{{ $key }}')"
                                                wire:confirm="Sei sicuro di voler eliminare questa impostazione?">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-cog fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessuna impostazione trovata</h5>
                <p class="text-muted">Inizia aggiungendo le tue prime impostazioni.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSettingModal">
                    <i class="fas fa-plus me-2"></i>Aggiungi Prima Impostazione
                </button>
            </div>
        </div>
    @endif

    <!-- Add Setting Modal -->
    <div class="modal fade" id="addSettingModal" tabindex="-1" aria-labelledby="addSettingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSettingModalLabel">Nuova Impostazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="addSetting">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newGroup" class="form-label">Gruppo *</label>
                            <select wire:model="newGroup" class="form-select @error('newGroup') is-invalid @enderror" id="newGroup" required>
                                <option value="general">Generale</option>
                                <option value="contact">Contatti</option>
                                <option value="social">Social</option>
                                <option value="seo">SEO</option>
                                <option value="email">Email</option>
                                <option value="payment">Pagamenti</option>
                            </select>
                            @error('newGroup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="newKey" class="form-label">Chiave *</label>
                            <input type="text" wire:model="newKey" class="form-control @error('newKey') is-invalid @enderror" 
                                   id="newKey" placeholder="es. site_name, contact_email" required>
                            @error('newKey') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Usa solo lettere, numeri e underscore</small>
                        </div>

                        <div class="mb-3">
                            <label for="newValue" class="form-label">Valore *</label>
                            <textarea wire:model="newValue" class="form-control @error('newValue') is-invalid @enderror" 
                                      id="newValue" rows="3" required></textarea>
                            @error('newValue') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Common Settings Help -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="mb-0">Impostazioni Comuni</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Generale</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><code>site_name</code> - Nome del sito</li>
                        <li><code>site_description</code> - Descrizione del sito</li>
                        <li><code>site_logo</code> - URL del logo</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Contatti</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><code>contact_email</code> - Email di contatto</li>
                        <li><code>contact_phone</code> - Telefono</li>
                        <li><code>contact_address</code> - Indirizzo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>