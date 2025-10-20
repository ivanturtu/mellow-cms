<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Newsletter\Newsletter;
use Illuminate\Support\Facades\Log;

class NewsletterSubscription extends Component
{
    public $email = '';
    public $success = false;
    public $error = '';
    public $loading = false;

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'L\'email è obbligatoria.',
        'email.email' => 'Inserisci un indirizzo email valido.',
        'email.max' => 'L\'email non può superare i 255 caratteri.',
    ];

    public function subscribe()
    {
        $this->loading = true;
        $this->error = '';
        $this->success = false;

        $this->validate();

        try {
            // Subscribe to Mailchimp with just email
            $result = app(Newsletter::class)->subscribe($this->email);

            if ($result) {
                $this->success = true;
                $this->reset(['email']);
            } else {
                $this->error = 'Errore durante l\'iscrizione alla newsletter.';
            }

        } catch (\Exception $e) {
            Log::error('Newsletter subscription error: ' . $e->getMessage());
            $this->error = 'Errore durante l\'iscrizione alla newsletter. Riprova più tardi.';
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.newsletter-subscription');
    }
}
