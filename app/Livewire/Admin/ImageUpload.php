<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUpload extends Component
{
    use WithFileUploads;

    // Component ID for unique identification
    public $id;

    public $images = [];
    public $uploadedImages = [];
    public $dragOver = false;
    public $maxFiles = 10;
    public $acceptedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    public $maxSize = 2048; // KB
    public $folder = 'uploads';

    protected $listeners = ['refreshImages' => 'refreshImages'];

    public function mount($folder = 'uploads', $maxFiles = 10)
    {
        $this->id = uniqid();
        $this->folder = $folder;
        $this->maxFiles = $maxFiles;
    }

    public function render()
    {
        return view('livewire.admin.image-upload');
    }

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'image|max:' . $this->maxSize
        ]);

        foreach ($this->images as $image) {
            if ($image) {
                $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($this->folder, $filename, 'public');
                
                $this->uploadedImages[] = [
                    'path' => $path,
                    'url' => asset('storage/' . $path),
                    'name' => $image->getClientOriginalName(),
                    'size' => $image->getSize(),
                    'type' => $image->getMimeType()
                ];
            }
        }

        $this->images = [];
        
        // Debug: Log the uploaded images
        \Log::info('ImageUpload: Uploaded images', [
            'count' => count($this->uploadedImages),
            'images' => $this->uploadedImages,
            'component_id' => $this->id
        ]);
        
        // Dispatch the uploaded images array
        $this->dispatch('imagesUploaded', $this->uploadedImages);
        
        // Also dispatch individual image paths for single file uploads
        if (count($this->uploadedImages) === 1) {
            $imagePath = $this->uploadedImages[0]['path'];
            \Log::info('ImageUpload: Dispatching imageUploaded event', [
                'path' => $imagePath,
                'component_id' => $this->id
            ]);
            
            // Dispatch both globally and to parent component
            $this->dispatch('imageUploaded', $imagePath);
            
            // Also try broadcasting to ensure parent receives it
            $this->dispatch('imageUploaded', imagePath: $imagePath);
        }
    }

    public function removeImage($index)
    {
        if (isset($this->uploadedImages[$index])) {
            $image = $this->uploadedImages[$index];
            
            // Delete from storage
            if (Storage::disk('public')->exists($image['path'])) {
                Storage::disk('public')->delete($image['path']);
            }
            
            unset($this->uploadedImages[$index]);
            $this->uploadedImages = array_values($this->uploadedImages);
            
            $this->dispatch('imageRemoved', $index);
        }
    }

    public function setImages($images)
    {
        $this->uploadedImages = $images;
    }

    public function refreshImages()
    {
        $this->uploadedImages = [];
    }

    public function getUploadedImages()
    {
        return $this->uploadedImages;
    }

    public function dragOver()
    {
        $this->dragOver = true;
    }

    public function dragLeave()
    {
        $this->dragOver = false;
    }

    public function drop()
    {
        $this->dragOver = false;
    }
}
