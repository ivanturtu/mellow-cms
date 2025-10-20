<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\RoomImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Traits\HandlesImageOptimization;

#[Layout('components.layouts.admin')]
class RoomManagement extends Component
{
    use WithFileUploads, HandlesImageOptimization;

    // Properties for form
    public $name = '';
    public $description = '';
    public $image;
    public $price = 0;
    public $size = '';
    public $capacity = 1;
    public $bed_type = '';
    public $bed_count = null;
    public $bath_count = null;
    // rimosso person_count (usiamo capacity)
    public $wifi = false;
    public $air_conditioning = false;
    public $tv_cable = false;
    public $services = '';
    public $is_active = true;
    public $sort_order = 0;

    // Properties for editing
    public $editingRoom = null;
    public $showForm = false;
    
    // Properties for drag & drop
    public $uploadedImage = null;
    public $dragOver = false;

    // Room gallery management
    public $roomImages = [];
    public $roomGalleryImage = null; // legacy single file input
    public $roomGalleryImages = []; // multiple files input
    public $roomGalleryUploadedImage = null; // path via DnD (if implemented later)

    // Properties for listing
    public $search = '';
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' => 'required|numeric|min:0',
        'size' => 'nullable|string|max:255',
        'capacity' => 'required|integer|min:1',
        'bed_type' => 'nullable|string|max:255',
        'bed_count' => 'nullable|integer|min:0',
        'bath_count' => 'nullable|integer|min:0',
        'wifi' => 'boolean',
        'air_conditioning' => 'boolean',
        'tv_cable' => 'boolean',
        'services' => 'nullable|string',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0'
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function getTitle()
    {
        return 'Gestione Camere';
    }

    public function render()
    {
        $rooms = Room::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('bed_type', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.admin.room-management', compact('rooms'))
            ->title('Gestione Camere');
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(Room $room)
    {
        $this->editingRoom = $room;
        $this->name = $room->name;
        $this->description = $room->description;
        $this->price = $room->price;
        $this->size = $room->size;
        $this->capacity = $room->capacity;
        $this->bed_type = $room->bed_type;
        $this->bed_count = $room->bed_count;
        $this->bath_count = $room->bath_count;
        $this->wifi = (bool) $room->wifi;
        $this->air_conditioning = (bool) $room->air_conditioning;
        $this->tv_cable = (bool) $room->tv_cable;
        $this->services = $room->services;
        $this->is_active = $room->is_active;
        $this->sort_order = $room->sort_order;
        $this->showForm = true;
        $this->loadRoomImages();
    }

    public function save()
    {
        $rules = $this->rules;
        
        // If creating new room, image is required
        if (!$this->editingRoom) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'size' => $this->size,
            'capacity' => $this->capacity,
            'bed_type' => $this->bed_type,
            'bed_count' => $this->bed_count,
            'bath_count' => $this->bath_count,
            'wifi' => $this->wifi,
            'air_conditioning' => $this->air_conditioning,
            'tv_cable' => $this->tv_cable,
            'services' => $this->services,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        // Handle image upload with optimization
        if ($this->image) {
            // Delete old image if editing
            if ($this->editingRoom && $this->editingRoom->image) {
                Storage::disk('public')->delete($this->editingRoom->image);
            }
            
            // Process image with optimization
            $processedImages = $this->createResponsiveImages($this->image, 'rooms', 85);
            
            // Store the medium size as the main image (fallback to original if not present)
            $data['image'] = $processedImages['sizes']['md']['path'] ?? $processedImages['original'];
            
            // Store only sizes mapping for future use
            $data['image_sizes'] = json_encode($processedImages['sizes'] ?? []);
        } elseif ($this->uploadedImage) {
            // Handle drag & drop uploaded image
            // Delete old image if editing
            if ($this->editingRoom && $this->editingRoom->image) {
                Storage::disk('public')->delete($this->editingRoom->image);
            }
            
            // Use the uploaded image path directly
            $data['image'] = $this->uploadedImage;

            // Generate WEBP responsive sizes for the stored file
            $processed = $this->processStoredImage($this->uploadedImage, 'rooms');
            $data['image_sizes'] = json_encode($processed['sizes'] ?? []);
        }

        if ($this->editingRoom) {
            $this->editingRoom->update($data);
            session()->flash('success', 'Camera aggiornata con successo!');
        } else {
            Room::create($data);
            session()->flash('success', 'Camera creata con successo!');
        }

        $this->resetForm();
    }

    public function delete(Room $room)
    {
        // Delete image
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();
        session()->flash('success', 'Camera eliminata con successo!');
    }

    public function toggleActive(Room $room)
    {
        $room->update(['is_active' => !$room->is_active]);
        session()->flash('success', 'Stato camera aggiornato!');
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
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->uploadedImage = null;
        $this->price = 0;
        $this->size = '';
        $this->capacity = 1;
        $this->bed_type = '';
        $this->bed_count = null;
        $this->bath_count = null;
        $this->wifi = false;
        $this->air_conditioning = false;
        $this->tv_cable = false;
        $this->services = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->editingRoom = null;
        $this->showForm = false;
        $this->resetErrorBag();

        // Reset gallery props
        $this->roomImages = [];
        $this->roomGalleryImage = null;
        $this->roomGalleryImages = [];
        $this->roomGalleryUploadedImage = null;
    }

    public function cancel()
    {
        $this->resetForm();
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
        // The file will be handled by the file input when dropped
    }

    // ---------- Room Gallery Methods ----------
    public function loadRoomImages(): void
    {
        if (!$this->editingRoom) {
            $this->roomImages = [];
            return;
        }
        $this->roomImages = RoomImage::where('room_id', $this->editingRoom->id)
            ->ordered()
            ->get();
    }

    public function uploadRoomGalleryImage(): void
    {
        if (!$this->editingRoom) {
            session()->flash('error', 'Salva prima la camera per aggiungere immagini alla galleria.');
            return;
        }

        $this->validate([
            'roomGalleryImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Store original
        $storedPath = $this->roomGalleryImage->store('rooms/gallery', 'public');

        // Generate WEBP sizes
        $processed = $this->processStoredImage($storedPath, 'rooms/gallery');

        // Create DB record
        RoomImage::create([
            'room_id' => $this->editingRoom->id,
            'image_path' => $storedPath,
            'alt_text' => $this->name,
            'is_primary' => false,
            'sort_order' => ($this->roomImages->max('sort_order') ?? 0) + 1,
            'is_active' => true,
        ]);

        $this->roomGalleryImage = null;
        $this->loadRoomImages();
        session()->flash('success', 'Immagine aggiunta alla galleria.');
    }

    public function uploadRoomGalleryImages(): void
    {
        if (!$this->editingRoom) {
            session()->flash('error', 'Salva prima la camera per aggiungere immagini alla galleria.');
            return;
        }

        $this->validate([
            'roomGalleryImages' => 'required|array',
            'roomGalleryImages.*' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $currentMaxOrder = ($this->roomImages->max('sort_order') ?? 0);
        $added = 0;

        foreach ($this->roomGalleryImages as $index => $file) {
            // Store original
            $storedPath = $file->store('rooms/gallery', 'public');

            // Generate WEBP sizes
            $this->processStoredImage($storedPath, 'rooms/gallery');

            // Create DB record
            RoomImage::create([
                'room_id' => $this->editingRoom->id,
                'image_path' => $storedPath,
                'alt_text' => $this->name,
                'is_primary' => false,
                'sort_order' => $currentMaxOrder + (++$added),
                'is_active' => true,
            ]);
        }

        $this->roomGalleryImages = [];
        $this->loadRoomImages();
        session()->flash('success', 'Immagini aggiunte alla galleria.');
    }

    public function removeRoomImage(int $imageId): void
    {
        $image = RoomImage::where('room_id', $this->editingRoom->id)->findOrFail($imageId);
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        $this->loadRoomImages();
        session()->flash('success', 'Immagine rimossa.');
    }

    public function makePrimary(int $imageId): void
    {
        if (!$this->editingRoom) return;
        RoomImage::where('room_id', $this->editingRoom->id)->update(['is_primary' => false]);
        RoomImage::where('room_id', $this->editingRoom->id)->where('id', $imageId)->update(['is_primary' => true]);
        $this->loadRoomImages();
        session()->flash('success', 'Immagine primaria aggiornata.');
    }
}
