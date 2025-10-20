<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Admin\ModalTrait;
use App\Traits\HandlesImageOptimization;

#[Layout('layouts.admin')]
class GalleryManagement extends Component
{
    use WithFileUploads, ModalTrait, HandlesImageOptimization;

    // Component ID for unique identification
    public $id;

    // Properties for form
    public $title = '';
    public $description = '';
    public $image;
    public $category = '';
    public $is_active = true;
    public $sort_order = 0;
    
    // Properties for bulk upload
    public $bulkUpload = false;
    public $uploadedImages = [];
    public $showBulkUpload = false;

    // Properties for editing
    public $editingGallery = null;
    public $showForm = false;
    
    // Properties for drag & drop
    public $showImageUpload = false;
    public $uploadedImage = null;

    // Properties for listing
    public $search = '';
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0'
    ];

    public function mount()
    {
        $this->id = uniqid();
        $this->resetForm();
    }

    public function render()
    {
        $galleries = Gallery::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.admin.gallery-management', compact('galleries'))
            ->title('Gestione Gallery');
    }

    public function create()
    {
        $this->resetForm();
        $this->openModal('form');
    }

    public function edit(Gallery $gallery)
    {
        $this->editingGallery = $gallery;
        $this->title = $gallery->title;
        $this->description = $gallery->description;
        $this->category = $gallery->category;
        $this->is_active = $gallery->is_active;
        $this->sort_order = $gallery->sort_order;
        $this->openModal('form');
    }

    public function save()
    {
        $rules = $this->rules;
        
        // If creating new gallery, image is required
        if (!$this->editingGallery) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        // Handle image upload with optimization to WEBP variants
        if ($this->image) {
            // Delete old image if editing
            if ($this->editingGallery && $this->editingGallery->image) {
                Storage::disk('public')->delete($this->editingGallery->image);
            }
            
            // Store the original image first
            $storedPath = $this->image->store('gallery', 'public');
            $data['image'] = $storedPath;

            // Generate WEBP responsive sizes based on the stored original
            $processed = $this->processStoredImage($storedPath, 'gallery');
            $data['image_sizes'] = json_encode($processed['sizes'] ?? []);
        } elseif ($this->uploadedImage) {
            // Handle drag & drop uploaded image
            // Delete old image if editing
            if ($this->editingGallery && $this->editingGallery->image) {
                Storage::disk('public')->delete($this->editingGallery->image);
            }
            
            // Use the uploaded image path directly
            $data['image'] = $this->uploadedImage;

            // Generate WEBP responsive sizes for the already stored file
            $processed = $this->processStoredImage($this->uploadedImage, 'gallery');
            $data['image_sizes'] = json_encode($processed['sizes'] ?? []);
        }

        if ($this->editingGallery) {
            $this->editingGallery->update($data);
            session()->flash('success', 'Immagine gallery aggiornata con successo!');
        } else {
            Gallery::create($data);
            session()->flash('success', 'Immagine gallery creata con successo!');
        }

        $this->resetForm();
    }

    public function delete(Gallery $gallery)
    {
        // Delete image
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();
        session()->flash('success', 'Immagine gallery eliminata con successo!');
    }

    public function toggleActive(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        session()->flash('success', 'Stato immagine aggiornato!');
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
        $this->uploadedImage = null;
        $this->category = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->editingGallery = null;
        $this->resetModal();
        $this->bulkUpload = false;
        $this->uploadedImages = [];
        $this->resetErrorBag();
    }

    public function showBulkUploadModal()
    {
        $this->openModal('bulk');
    }

    public function hideBulkUploadModal()
    {
        $this->closeModal();
    }

    public function processBulkUpload($images)
    {
        $this->uploadedImages = $images;
        
        // Create gallery entries for each uploaded image
        foreach ($images as $index => $image) {
            Gallery::create([
                'title' => $image['name'] ?? 'Immagine ' . ($index + 1),
                'description' => '',
                'image' => $image['path'],
                'category' => $this->category,
                'is_active' => $this->is_active,
                'sort_order' => $this->sort_order + $index,
            ]);
        }
        
        $this->hideBulkUploadModal();
        session()->flash('success', count($images) . ' immagini caricate con successo!');
    }

    public function cancel()
    {
        $this->resetForm();
        $this->closeModal();
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
        // Store the image path for later use in save method
        $this->image = null; // Clear any existing file upload
        $this->showImageUpload = false;
        session()->flash('success', 'Immagine caricata con successo!');
    }
}
