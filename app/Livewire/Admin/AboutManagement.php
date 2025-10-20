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
    public $editing = false;
    public $search = '';

    public function mount()
    {
        $this->id = uniqid();
    }

    public function render()
    {
        $aboutSections = AboutSection::when($this->search, function ($query) {
            return $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('subtitle', 'like', '%' . $this->search . '%');
        })->ordered()->paginate(10);

        return view('livewire.admin.about-management', compact('aboutSections'));
    }

    public function create()
    {
        $this->resetForm();
        $this->editing = false;
    }

    public function edit(AboutSection $aboutSection)
    {
        $this->aboutSection = $aboutSection;
        $this->title = $aboutSection->title;
        $this->subtitle = $aboutSection->subtitle;
        $this->description = $aboutSection->description;
        $this->cta_text = $aboutSection->cta_text;
        $this->cta_link = $aboutSection->cta_link;
        $this->is_active = $aboutSection->is_active;
        $this->sort_order = $aboutSection->sort_order;
        $this->editing = true;
        
        session()->flash('message', 'Sezione About caricata per la modifica');
        
        // Apri il modal
        $this->dispatch('openModal');
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
            'description' => $this->description,
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

        if ($this->editing) {
            $this->aboutSection->update($data);
            session()->flash('message', 'Sezione About aggiornata con successo!');
        } else {
            AboutSection::create($data);
            session()->flash('message', 'Sezione About creata con successo!');
        }

        $this->resetForm();
        
        // Chiudi il modal
        $this->dispatch('closeModal');
        
        // Forza la chiusura del modal se necessario
        $this->dispatch('forceCloseModal');
    }

    public function delete(AboutSection $aboutSection)
    {
        $aboutSection->delete();
        session()->flash('message', 'Sezione About eliminata con successo!');
    }

    public function toggleActive(AboutSection $aboutSection)
    {
        $aboutSection->update(['is_active' => !$aboutSection->is_active]);
        session()->flash('message', 'Stato della sezione About aggiornato!');
    }

    private function resetForm()
    {
        $this->title = '';
        $this->subtitle = '';
        $this->description = '';
        $this->cta_text = '';
        $this->cta_link = '';
        $this->image_1 = null;
        $this->image_2 = null;
        $this->image_3 = null;
        $this->is_active = true;
        $this->sort_order = 0;
        $this->editing = false;
    }
}
