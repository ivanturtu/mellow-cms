<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AboutSection;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Traits\HandlesImageOptimization;

#[Layout('components.layouts.admin')]
class AboutManagement extends Component
{
    use WithFileUploads, HandlesImageOptimization;

    public $id;
    public $aboutSection;
    public $title = '';
    public $subtitle = '';
    public $description = '';
    public $cta_text = '';
    public $cta_link = '';
    public $image_1;
    public $image_2;
    public $image_3;
    public $is_active = true;
    public $sort_order = 0;

    public function mount()
    {
        $this->id = uniqid();
        $this->loadAboutSection();
    }
    
    public function updated($propertyName)
    {
        // Questo metodo viene chiamato automaticamente quando una proprietà viene aggiornata
        // Non serve fare nulla, ma può essere utile per debug
    }

    public function render()
    {
        return view('livewire.admin.about-management');
    }

    private function loadAboutSection()
    {
        // Carica la prima sezione disponibile (attiva o meno) o crea una nuova se non esiste
        $this->aboutSection = AboutSection::orderBy('sort_order')
            ->orderBy('created_at')
            ->first();
        
        if (!$this->aboutSection) {
            // Se non esiste, crea una sezione vuota
            $this->aboutSection = AboutSection::create([
                'title' => '',
                'subtitle' => '',
                'description' => '',
                'cta_text' => '',
                'cta_link' => '',
                'is_active' => true,
                'sort_order' => 0
            ]);
        }
        
        // Carica i dati nel form
        $this->title = $this->aboutSection->title ?? '';
        $this->subtitle = $this->aboutSection->subtitle ?? '';
        $this->description = $this->aboutSection->description ?? '';
        $this->cta_text = $this->aboutSection->cta_text ?? '';
        $this->cta_link = $this->aboutSection->cta_link ?? '';
        $this->is_active = $this->aboutSection->is_active ?? true;
        $this->sort_order = $this->aboutSection->sort_order ?? 0;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0'
        ]);

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description, // HTML content from Trix editor
            'cta_text' => $this->cta_text,
            'cta_link' => $this->cta_link,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order
        ];

        // Gestisci upload immagini con varianti WEBP
        if ($this->image_1) {
            $stored = $this->image_1->store('about', 'public');
            $data['image_1'] = $stored;
            $processed = $this->processStoredImage($stored, 'about');
            $data['image_1_sizes'] = json_encode($processed['sizes'] ?? []);
        }
        if ($this->image_2) {
            $stored = $this->image_2->store('about', 'public');
            $data['image_2'] = $stored;
            $processed = $this->processStoredImage($stored, 'about');
            $data['image_2_sizes'] = json_encode($processed['sizes'] ?? []);
        }
        if ($this->image_3) {
            $stored = $this->image_3->store('about', 'public');
            $data['image_3'] = $stored;
            $processed = $this->processStoredImage($stored, 'about');
            $data['image_3_sizes'] = json_encode($processed['sizes'] ?? []);
        }

        // Aggiorna sempre la sezione esistente usando fill e save
        $this->aboutSection->fill($data);
        $this->aboutSection->save();
        
        // Refresh the aboutSection model to get updated data
        $this->aboutSection->refresh();
        
        // Aggiorna le proprietà del componente con i valori salvati
        $this->title = $this->aboutSection->title ?? '';
        $this->subtitle = $this->aboutSection->subtitle ?? '';
        $this->description = $this->aboutSection->description ?? '';
        $this->cta_text = $this->aboutSection->cta_text ?? '';
        $this->cta_link = $this->aboutSection->cta_link ?? '';
        $this->is_active = $this->aboutSection->is_active ?? true;
        $this->sort_order = $this->aboutSection->sort_order ?? 0;
        
        // Reset immagini
        $this->image_1 = null;
        $this->image_2 = null;
        $this->image_3 = null;
        
        // Dispatch event to update Trix editor and inputs
        $this->dispatch('about-section-saved');
        
        session()->flash('message', 'Sezione About aggiornata con successo!');
    }
}
