<?php

namespace App\Livewire\Admin;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Traits\HandlesImageOptimization;

#[Layout('components.layouts.admin')]
class SliderManagement extends Component
{
    use WithFileUploads, HandlesImageOptimization;

    // Component ID for unique identification
    public $id;

    // Properties for form
    public $title = '';
    public $description = '';
    public $image;
    public $cta_text = '';
    public $cta_link = '';
    public $is_active = true;
    public $sort_order = 0;
    
    // Properties for image upload
    public $uploadedImage = null;
    public $showImageUpload = false;

    // Properties for editing
    public $editingSlider = null;
    public $showForm = false;

    // Properties for listing
    public $search = '';
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'cta_text' => 'nullable|string|max:255',
        'cta_link' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0'
    ];

    public function mount()
    {
        $this->id = uniqid();
        $this->resetForm();
    }

    public function getTitle()
    {
        return 'Gestione Slider';
    }

    public function render()
    {
        $sliders = Slider::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.admin.slider-management', compact('sliders'))
            ->title('Gestione Slider');
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(Slider $slider)
    {
        $this->editingSlider = $slider;
        $this->title = $slider->title;
        $this->description = $slider->description;
        $this->cta_text = $slider->cta_text;
        $this->cta_link = $slider->cta_link;
        $this->is_active = $slider->is_active;
        $this->sort_order = $slider->sort_order;
        $this->showForm = true;
    }

    public function save()
    {
        $rules = $this->rules;
        
        // If creating new slider, image is required
        if (!$this->editingSlider) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'cta_text' => $this->cta_text,
            'cta_link' => $this->cta_link,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        // Handle image upload with optimization
        if ($this->image) {
            // Delete old image if editing
            if ($this->editingSlider && $this->editingSlider->image) {
                Storage::disk('public')->delete($this->editingSlider->image);
            }
            
            // Process image with optimization
            $processedImages = $this->createResponsiveImages($this->image, 'sliders', 85);
            
            // Store the medium size as the main image
            $data['image'] = $processedImages['md']['path'];
            
            // Store all sizes in a JSON field for future use
            $data['image_sizes'] = json_encode($processedImages);
        }

        if ($this->editingSlider) {
            $this->editingSlider->update($data);
            session()->flash('success', 'Slider aggiornato con successo!');
        } else {
            Slider::create($data);
            session()->flash('success', 'Slider creato con successo!');
        }

        $this->resetForm();
    }

    public function delete(Slider $slider)
    {
        // Delete image
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();
        session()->flash('success', 'Slider eliminato con successo!');
    }

    public function toggleActive(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        session()->flash('success', 'Stato slider aggiornato!');
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->image = null;
        $this->cta_text = '';
        $this->cta_link = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->editingSlider = null;
        $this->showForm = false;
        $this->uploadedImage = null;
        $this->showImageUpload = false;
        $this->resetErrorBag();
    }

    public function showImageUploadModal()
    {
        $this->showImageUpload = true;
    }

    public function hideImageUploadModal()
    {
        $this->showImageUpload = false;
    }

    public function setUploadedImage($imagePath)
    {
        $this->uploadedImage = $imagePath;
        $this->image = $imagePath;
        $this->showImageUpload = false;
        session()->flash('success', 'Immagine caricata con successo!');
    }

    public function cancel()
    {
        $this->resetForm();
    }
}
