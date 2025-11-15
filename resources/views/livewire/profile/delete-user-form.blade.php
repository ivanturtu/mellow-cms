<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>{{ __('Attenzione!') }}</strong>
        <p class="mb-0 mt-2">{{ __('Una volta eliminato il tuo account, tutte le sue risorse e i dati saranno eliminati permanentemente. Prima di eliminare il tuo account, scarica eventuali dati o informazioni che desideri conservare.') }}</p>
    </div>

    <button type="button" 
            class="btn btn-danger"
            data-bs-toggle="modal" 
            data-bs-target="#confirmUserDeletionModal">
        <i class="fas fa-trash me-2"></i>{{ __('Elimina Account') }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit="deleteUser">
                    <div class="modal-header border-danger">
                        <h5 class="modal-title text-danger" id="confirmUserDeletionModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Conferma Eliminazione Account') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">{{ __('Sei sicuro di voler eliminare il tuo account?') }}</p>
                        <p class="text-muted small mb-3">{{ __('Una volta eliminato il tuo account, tutte le sue risorse e i dati saranno eliminati permanentemente. Inserisci la tua password per confermare che desideri eliminare permanentemente il tuo account.') }}</p>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input wire:model="password"
                                   id="password"
                                   name="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="{{ __('Inserisci la tua password') }}"
                                   required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Annulla') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>{{ __('Elimina Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
