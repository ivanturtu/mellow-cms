<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class ServiceManagement extends Component
{

    // Properties for form
    public $name = '';
    public $description = '';
    public $icon = '';
    public $is_active = true;
    public $sort_order = 0;

    // Component ID for unique identification
    public $id;

    // Properties for editing
    public $editingService = null;
    public $showForm = false;

    // Properties for listing
    public $search = '';
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'nullable|string|max:255',
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
        $services = Service::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.admin.service-management', compact('services'))
            ->title('Gestione Servizi');
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(Service $service)
    {
        $this->editingService = $service;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->icon = $service->icon;
        $this->is_active = $service->is_active;
        $this->sort_order = $service->sort_order;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate($this->rules);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingService) {
            $this->editingService->update($data);
            session()->flash('success', 'Servizio aggiornato con successo!');
        } else {
            Service::create($data);
            session()->flash('success', 'Servizio creato con successo!');
        }

        $this->resetForm();
    }

    public function delete(Service $service)
    {
        $service->delete();
        session()->flash('success', 'Servizio eliminato con successo!');
    }

    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        session()->flash('success', 'Stato servizio aggiornato!');
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
        $this->icon = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->editingService = null;
        $this->showForm = false;
        $this->resetErrorBag();
    }

    public function cancel()
    {
        $this->resetForm();
    }
}
