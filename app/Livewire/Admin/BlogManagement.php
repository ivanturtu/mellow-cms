<?php

namespace App\Livewire\Admin;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Traits\HandlesImageOptimization;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin')]
class BlogManagement extends Component
{
    use WithFileUploads, HandlesImageOptimization;

    // Properties for form
    public $title = '';
    public $excerpt = '';
    public $content = '';
    public $image;
    public $category = '';
    public $is_published = false;
    public $published_at = '';

    // Component ID for unique identification
    public $id;

    // Properties for editing
    public $editingBlog = null;
    public $showForm = false;
    
    // Properties for drag & drop
    public $showImageUpload = false;
    public $uploadedImage = null;

    // Properties for listing
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'title' => 'required|string|max:255',
        'excerpt' => 'nullable|string',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category' => 'nullable|string|max:255',
        'is_published' => 'boolean',
        'published_at' => 'nullable|date'
    ];

    public function mount()
    {
        $this->id = uniqid();
        $this->resetForm();
    }

    public function render()
    {
        $blogs = Blog::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.admin.blog-management', compact('blogs'))
            ->title('Gestione Blog');
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(Blog $blog)
    {
        $this->editingBlog = $blog;
        $this->title = $blog->title;
        $this->excerpt = $blog->excerpt;
        $this->content = $blog->content;
        $this->category = $blog->category;
        $this->is_published = $blog->is_published;
        $this->published_at = $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '';
        $this->showForm = true;
    }

    public function save()
    {
        $rules = $this->rules;
        
        // If creating new blog, image is required
        if (!$this->editingBlog) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'is_published' => $this->is_published,
            'slug' => Str::slug($this->title),
        ];

        // Handle published_at
        if ($this->is_published && $this->published_at) {
            $data['published_at'] = $this->published_at;
        } elseif ($this->is_published && !$this->published_at) {
            $data['published_at'] = now();
        }

        // Handle image upload with WEBP variants
        if ($this->image) {
            // Delete old image if editing
            if ($this->editingBlog && $this->editingBlog->image) {
                Storage::disk('public')->delete($this->editingBlog->image);
            }
            $storedPath = $this->image->store('blogs', 'public');
            $data['image'] = $storedPath;
            $processed = $this->processStoredImage($storedPath, 'blogs');
            $data['image_sizes'] = json_encode($processed['sizes'] ?? []);
        } elseif ($this->uploadedImage) {
            // Handle drag & drop uploaded image
            // Delete old image if editing
            if ($this->editingBlog && $this->editingBlog->image) {
                Storage::disk('public')->delete($this->editingBlog->image);
            }
            
            // Use the uploaded image path directly
            $data['image'] = $this->uploadedImage;
            $processed = $this->processStoredImage($this->uploadedImage, 'blogs');
            $data['image_sizes'] = json_encode($processed['sizes'] ?? []);
        }

        if ($this->editingBlog) {
            $this->editingBlog->update($data);
            session()->flash('success', 'Articolo blog aggiornato con successo!');
        } else {
            Blog::create($data);
            session()->flash('success', 'Articolo blog creato con successo!');
        }

        $this->resetForm();
    }

    public function delete(Blog $blog)
    {
        // Delete image
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();
        session()->flash('success', 'Articolo blog eliminato con successo!');
    }

    public function togglePublished(Blog $blog)
    {
        $data = ['is_published' => !$blog->is_published];
        
        if (!$blog->is_published && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);
        session()->flash('success', 'Stato pubblicazione aggiornato!');
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
        $this->excerpt = '';
        $this->content = '';
        $this->image = null;
        $this->uploadedImage = null;
        $this->category = '';
        $this->is_published = false;
        $this->published_at = '';
        $this->editingBlog = null;
        $this->showForm = false;
        $this->resetErrorBag();
    }

    public function cancel()
    {
        $this->resetForm();
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
