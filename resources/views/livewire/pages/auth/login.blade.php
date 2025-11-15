<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Redirect to admin dashboard - use JavaScript as primary method for reliability
        $dashboardUrl = route('admin.dashboard', absolute: false);
        $this->js("window.location.href = '{$dashboardUrl}'");
    }
}; ?>

<div>
    <form wire:submit.prevent="login">
        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input wire:model="form.email" 
                   id="email" 
                   class="form-control @error('form.email') is-invalid @enderror" 
                   type="email" 
                   name="email" 
                   required 
                   autofocus 
                   autocomplete="username"
                   placeholder="nome@esempio.com">
            @error('form.email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input wire:model="form.password" 
                   id="password" 
                   class="form-control @error('form.password') is-invalid @enderror"
                   type="password"
                   name="password"
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••">
            @error('form.password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input wire:model.live="form.remember" 
                       id="remember" 
                       type="checkbox" 
                       class="form-check-input" 
                       name="remember">
                <label for="remember" class="form-check-label">
                    {{ __('Remember me') }}
                </label>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-decoration-none">
                    {{ __('Forgot your password?') }}
                </a>
            @else
                <span></span>
            @endif

            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">
                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Log in') }}
                </span>
                <span wire:loading wire:target="login">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    {{ __('Accesso in corso...') }}
                </span>
            </button>
        </div>
    </form>
</div>
