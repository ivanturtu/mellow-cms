<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Statistic;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class StatisticManagement extends Component
{
    use WithPagination;
    
    public function mount()
    {
        $this->id = uniqid();
    }

    public $id;
    public $statistic;
    public $title = '';
    public $value = '';
    public $description = '';
    public $icon = '';
    public $is_active = true;
    public $sort_order = 0;
    public $editing = false;
    public $search = '';

    public function render()
    {
        $statistics = Statistic::when($this->search, function ($query) {
            return $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('value', 'like', '%' . $this->search . '%');
        })->ordered()->paginate(10);

        return view('livewire.admin.statistic-management', compact('statistics'));
    }

    public function create()
    {
        $this->resetForm();
        $this->editing = false;
    }

    public function edit(Statistic $statistic)
    {
        $this->statistic = $statistic;
        $this->title = $statistic->title;
        $this->value = $statistic->value;
        $this->description = $statistic->description;
        $this->icon = $statistic->icon;
        $this->is_active = $statistic->is_active;
        $this->sort_order = $statistic->sort_order;
        $this->editing = true;
        
        session()->flash('message', 'Statistica caricata per la modifica');
        
        // Apri il modal
        $this->dispatch('openModal');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0'
        ]);

        if ($this->editing) {
            $this->statistic->update([
                'title' => $this->title,
                'value' => $this->value,
                'description' => $this->description,
                'icon' => $this->icon,
                'is_active' => $this->is_active,
                'sort_order' => $this->sort_order
            ]);
            session()->flash('message', 'Statistica aggiornata con successo!');
        } else {
            Statistic::create([
                'title' => $this->title,
                'value' => $this->value,
                'description' => $this->description,
                'icon' => $this->icon,
                'is_active' => $this->is_active,
                'sort_order' => $this->sort_order
            ]);
            session()->flash('message', 'Statistica creata con successo!');
        }

        $this->resetForm();
        
        // Chiudi il modal
        $this->dispatch('closeModal');
        
        // Forza la chiusura del modal se necessario
        $this->dispatch('forceCloseModal');
    }

    public function delete(Statistic $statistic)
    {
        $statistic->delete();
        session()->flash('message', 'Statistica eliminata con successo!');
    }

    public function toggleActive(Statistic $statistic)
    {
        $statistic->update(['is_active' => !$statistic->is_active]);
        session()->flash('message', 'Stato della statistica aggiornato!');
    }

    private function resetForm()
    {
        $this->title = '';
        $this->value = '';
        $this->description = '';
        $this->icon = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->editing = false;
    }
}
