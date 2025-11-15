<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.admin')]
class SettingsManagement extends Component
{
    use WithFileUploads;

    // Component ID for unique identification
    public $id;

    // Properties for settings
    public $settings = [];
    public $newKey = '';
    public $newValue = '';
    public $newGroup = 'general';
    
    // Properties for logo upload
    public $logo;
    public $currentLogo = '';

    protected $rules = [
        'newKey' => 'required|string|max:255',
        'newValue' => 'required|string',
        'newGroup' => 'required|string|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

    public function mount()
    {
        $this->id = uniqid();
        $this->loadSettings();
        $this->currentLogo = $this->getSetting('general', 'logo', '');
        
        // Initialize maintenance mode settings if they don't exist
        if (!isset($this->settings['maintenance']['maintenance_enabled'])) {
            $maintenanceEnabled = Setting::get('maintenance_enabled', '0');
            $this->settings['maintenance']['maintenance_enabled'] = $maintenanceEnabled === '1' ? '1' : '0';
        }
        if (!isset($this->settings['maintenance']['maintenance_message'])) {
            $this->settings['maintenance']['maintenance_message'] = Setting::get('maintenance_message', 'Stiamo lavorando per migliorare il sito. Torneremo presto online!');
        }
    }

    public function render()
    {
        return view('livewire.admin.settings-management')
            ->title('Impostazioni');
    }

    public function loadSettings()
    {
        $this->settings = Setting::all()->groupBy('group')->map(function ($group) {
            return $group->pluck('value', 'key');
        })->toArray();
        
        // Convert WhatsApp URL back to phone number for display
        if (isset($this->settings['social']['whatsapp_url']) && !empty($this->settings['social']['whatsapp_url'])) {
            $whatsappUrl = $this->settings['social']['whatsapp_url'];
            if (str_starts_with($whatsappUrl, 'https://wa.me/')) {
                $phoneNumber = str_replace('https://wa.me/', '', $whatsappUrl);
                $this->settings['social']['whatsapp_url'] = $phoneNumber;
            }
        }
    }

    public function updateSetting($group, $key, $value)
    {
        Setting::updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => $value, 'type' => $this->getSettingType($key)]
        );
    }
    
    private function getSettingType($key)
    {
        // Define types based on key for better form rendering
        if (str_contains($key, 'url') || str_contains($key, 'link')) {
            return 'url';
        } elseif (str_contains($key, 'description')) {
            return 'textarea';
        }
        return 'text';
    }

    public function addSetting()
    {
        $this->validate();

        // Check if setting already exists
        $existing = Setting::where('group', $this->newGroup)
                          ->where('key', $this->newKey)
                          ->first();

        if ($existing) {
            session()->flash('error', 'Questa impostazione esiste già!');
            return;
        }

        Setting::create([
            'group' => $this->newGroup,
            'key' => $this->newKey,
            'value' => $this->newValue
        ]);

        $this->newKey = '';
        $this->newValue = '';
        $this->newGroup = 'general';
        
        $this->loadSettings();
        session()->flash('success', 'Impostazione aggiunta con successo!');
    }

    public function deleteSetting($group, $key)
    {
        $setting = Setting::where('group', $group)->where('key', $key)->first();
        
        if ($setting) {
            $setting->delete();
            $this->loadSettings();
            session()->flash('success', 'Impostazione eliminata con successo!');
        }
    }

    public function getSetting($group, $key, $default = '')
    {
        return $this->settings[$group][$key] ?? $default;
    }

    public function uploadLogo()
    {
        $this->validate(['logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        // Delete old logo if exists
        if ($this->currentLogo && Storage::disk('public')->exists($this->currentLogo)) {
            Storage::disk('public')->delete($this->currentLogo);
        }

        // Store new logo
        $logoPath = $this->logo->store('logos', 'public');
        
        // Update setting
        $this->updateSetting('general', 'logo', $logoPath);
        $this->currentLogo = $logoPath;
        $this->logo = null;
        
        session()->flash('success', 'Logo caricato con successo!');
    }

    public function removeLogo()
    {
        if ($this->currentLogo && Storage::disk('public')->exists($this->currentLogo)) {
            Storage::disk('public')->delete($this->currentLogo);
        }
        
        $this->updateSetting('general', 'logo', '');
        $this->currentLogo = '';
        
        session()->flash('success', 'Logo rimosso con successo!');
    }



    public function saveSocialSettings()
    {
        try {
            // Save social media settings
            $socialFields = ['facebook_url', 'instagram_url', 'tiktok_url', 'whatsapp_url', 'linkedin_url'];
            
            foreach ($socialFields as $field) {
                $value = $this->settings['social'][$field] ?? '';
                
                // Special handling for WhatsApp
                if ($field === 'whatsapp_url' && !empty($value) && !str_starts_with($value, 'http')) {
                    // Remove any non-numeric characters except +
                    $phoneNumber = preg_replace('/[^0-9+]/', '', $value);
                    // Ensure it starts with country code
                    if (!str_starts_with($phoneNumber, '+')) {
                        $phoneNumber = '+' . $phoneNumber;
                    }
                    $value = 'https://wa.me/' . ltrim($phoneNumber, '+');
                }
                
                $this->updateSetting('social', $field, $value);
            }
            
            // Reload settings to reflect changes
            $this->loadSettings();
            
            session()->flash('success', 'Impostazioni social media salvate con successo!');
            
        } catch (\Exception $e) {
            \Log::error('Social settings save error: ' . $e->getMessage());
            session()->flash('error', 'Errore durante il salvataggio delle impostazioni social: ' . $e->getMessage());
        }
    }

    public function saveMailchimpSettings()
    {
        // Save Mailchimp settings
        if (isset($this->settings['mailchimp']['mailchimp_api_key'])) {
            $this->updateSetting('mailchimp', 'mailchimp_api_key', $this->settings['mailchimp']['mailchimp_api_key']);
        }
        if (isset($this->settings['mailchimp']['mailchimp_list_id'])) {
            $this->updateSetting('mailchimp', 'mailchimp_list_id', $this->settings['mailchimp']['mailchimp_list_id']);
        }
        if (isset($this->settings['mailchimp']['mailchimp_server_prefix'])) {
            $this->updateSetting('mailchimp', 'mailchimp_server_prefix', $this->settings['mailchimp']['mailchimp_server_prefix']);
        }
        if (isset($this->settings['mailchimp']['newsletter_enabled'])) {
            $this->updateSetting('mailchimp', 'newsletter_enabled', $this->settings['mailchimp']['newsletter_enabled']);
        }
        if (isset($this->settings['mailchimp']['newsletter_title'])) {
            $this->updateSetting('mailchimp', 'newsletter_title', $this->settings['mailchimp']['newsletter_title']);
        }
        if (isset($this->settings['mailchimp']['newsletter_description'])) {
            $this->updateSetting('mailchimp', 'newsletter_description', $this->settings['mailchimp']['newsletter_description']);
        }
        
        session()->flash('success', 'Impostazioni newsletter salvate con successo!');
    }

    public function saveContactSettings()
    {
        // Save contact settings
        if (isset($this->settings['general']['contact_address'])) {
            $this->updateSetting('general', 'contact_address', $this->settings['general']['contact_address']);
        }
        if (isset($this->settings['general']['contact_phone'])) {
            $this->updateSetting('general', 'contact_phone', $this->settings['general']['contact_phone']);
        }
        if (isset($this->settings['general']['contact_email'])) {
            $this->updateSetting('general', 'contact_email', $this->settings['general']['contact_email']);
        }
        if (isset($this->settings['general']['map_latitude'])) {
            $this->updateSetting('general', 'map_latitude', $this->settings['general']['map_latitude']);
        }
        if (isset($this->settings['general']['map_longitude'])) {
            $this->updateSetting('general', 'map_longitude', $this->settings['general']['map_longitude']);
        }
        if (isset($this->settings['general']['map_zoom'])) {
            $this->updateSetting('general', 'map_zoom', $this->settings['general']['map_zoom']);
        }
        
        session()->flash('success', 'Impostazioni contatti salvate con successo!');
    }

    public function saveMaintenanceSettings()
    {
        // Save maintenance mode settings
        // Handle checkbox value - it can be true, '1', false, null, or '0'
        $enabledValue = $this->settings['maintenance']['maintenance_enabled'] ?? '0';
        $enabled = ($enabledValue === true || $enabledValue === '1' || $enabledValue === 1) ? '1' : '0';
        
        Setting::set('maintenance_enabled', $enabled, 'text', 'maintenance');
        
        if (isset($this->settings['maintenance']['maintenance_message'])) {
            Setting::set('maintenance_message', $this->settings['maintenance']['maintenance_message'], 'textarea', 'maintenance');
        }
        
        $status = $enabled === '1' ? 'attivata' : 'disattivata';
        session()->flash('success', "Modalità manutenzione {$status} con successo!");
        
        // Reload settings to reflect changes
        $this->loadSettings();
        
        // Ensure the checkbox value is set correctly after reload
        $this->settings['maintenance']['maintenance_enabled'] = $enabled;
    }

}
