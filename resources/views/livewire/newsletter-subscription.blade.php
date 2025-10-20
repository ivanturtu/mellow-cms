<div>
    @if($success)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            Iscrizione alla newsletter completata con successo! Ti invieremo le nostre novità.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form wire:submit="subscribe" class="newsletter-form">
        <div class="input-group">
            <input type="email" 
                   wire:model="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   placeholder="Inserisci la tua email" 
                   required>
            <button type="submit" 
                    class="btn btn-primary" 
                    wire:loading.attr="disabled"
                    wire:target="subscribe">
                <span wire:loading.remove wire:target="subscribe">
                    <i class="fas fa-paper-plane me-1"></i>
                    Iscriviti
                </span>
                <span wire:loading wire:target="subscribe">
                    <i class="fas fa-spinner fa-spin me-1"></i>
                    ...
                </span>
            </button>
        </div>
        @error('email') 
            <div class="invalid-feedback d-block">{{ $message }}</div> 
        @enderror
        
        <small class="text-muted mt-2 d-block">
            <i class="fas fa-shield-alt me-1"></i>
            I tuoi dati sono al sicuro. Non condivideremo mai la tua email con terze parti.
        </small>
    </form>
</div>
