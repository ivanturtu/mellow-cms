<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div>
    <form wire:submit="updateProfileInformation">
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input wire:model="name" 
                   id="name" 
                   name="name" 
                   type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="{{ __('Il tuo nome') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input wire:model="email" 
                   id="email" 
                   name="email" 
                   type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   required 
                   autocomplete="username"
                   placeholder="nome@esempio.com">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="alert alert-warning mt-2">
                    <p class="mb-2">{{ __('Il tuo indirizzo email non è verificato.') }}</p>
                    <button wire:click.prevent="sendVerification" class="btn btn-sm btn-outline-warning">
                        {{ __('Clicca qui per inviare nuovamente l\'email di verifica.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 mb-0 text-success">
                            {{ __('Un nuovo link di verifica è stato inviato al tuo indirizzo email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ __('Salva') }}
            </button>

            <div wire:loading wire:target="updateProfileInformation" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Caricamento...</span>
            </div>

            <div wire:loading.remove wire:target="updateProfileInformation">
                <div x-data="{ show: false }" 
                     x-show="show" 
                     x-transition
                     @profile-updated.window="show = true; setTimeout(() => show = false, 3000)"
                     class="text-success">
                    <i class="fas fa-check-circle me-2"></i>{{ __('Salvato.') }}
                </div>
            </div>
        </div>
    </form>
</div>
