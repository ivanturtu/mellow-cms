<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<div>
    <form wire:submit="updatePassword">
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Password Attuale') }}</label>
            <input wire:model="current_password" 
                   id="update_password_current_password" 
                   name="current_password" 
                   type="password" 
                   class="form-control @error('current_password') is-invalid @enderror" 
                   autocomplete="current-password"
                   placeholder="••••••••">
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Nuova Password') }}</label>
            <input wire:model="password" 
                   id="update_password_password" 
                   name="password" 
                   type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   autocomplete="new-password"
                   placeholder="••••••••">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Conferma Password') }}</label>
            <input wire:model="password_confirmation" 
                   id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                   autocomplete="new-password"
                   placeholder="••••••••">
            @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ __('Salva') }}
            </button>

            <div wire:loading wire:target="updatePassword" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Caricamento...</span>
            </div>

            <div wire:loading.remove wire:target="updatePassword">
                <div x-data="{ show: false }" 
                     x-show="show" 
                     x-transition
                     @password-updated.window="show = true; setTimeout(() => show = false, 3000)"
                     class="text-success">
                    <i class="fas fa-check-circle me-2"></i>{{ __('Salvato.') }}
                </div>
            </div>
        </div>
    </form>
</div>
