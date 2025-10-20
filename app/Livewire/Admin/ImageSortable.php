<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;

class ImageSortable extends Component
{
    // Component ID for unique identification
    public $id;

    public $images = [];
    public $modelId;
    public $sortField = 'sort_order';

    protected $listeners = ['refreshImages' => 'refreshImages'];

    public function mount($modelClass = null, $modelId = null, $sortField = 'sort_order')
    {
        $this->id = uniqid();
        $this->modelId = $modelId;
        $this->sortField = $sortField;
        $this->loadImages();
    }

    public function render()
    {
        return view('livewire.admin.image-sortable');
    }

    public function loadImages()
    {
        if ($this->modelId) {
            $model = Gallery::find($this->modelId);
            if ($model) {
                $this->images = $model->images ?? [];
            }
        } else {
            $this->images = Gallery::orderBy($this->sortField)->get()->toArray();
        }
    }

    public function updateOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Gallery::where('id', $id)->update([$this->sortField => $index]);
        }
        
        $this->loadImages();
        $this->dispatch('orderUpdated');
    }

    public function removeImage($id)
    {
        $image = Gallery::find($id);
        
        if ($image) {
            // Delete image file
            if (isset($image->image) && $image->image) {
                Storage::disk('public')->delete($image->image);
            }
            
            $image->delete();
            $this->loadImages();
            $this->dispatch('imageRemoved', $id);
        }
    }

    public function toggleActive($id)
    {
        $image = Gallery::find($id);
        
        if ($image) {
            $image->update(['is_active' => !$image->is_active]);
            $this->loadImages();
            $this->dispatch('statusUpdated', $id);
        }
    }

    public function refreshImages()
    {
        $this->loadImages();
    }
}
