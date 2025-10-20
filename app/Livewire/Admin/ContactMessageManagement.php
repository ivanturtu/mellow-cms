<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class ContactMessageManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $selectedMessage = null;
    public $showMessageModal = false;

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        $messages = ContactMessage::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.contact-message-management', [
            'messages' => $messages,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function viewMessage($id)
    {
        $this->selectedMessage = ContactMessage::find($id);
        $this->showMessageModal = true;
        
        // Mark as read if it's new
        if ($this->selectedMessage->status === 'new') {
            $this->selectedMessage->update(['status' => 'read']);
        }
    }

    public function updateStatus($id, $status)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            $message->status = $status;
            $message->save();
            session()->flash('message', 'Stato messaggio aggiornato con successo!');
        }
    }

    public function deleteMessage($id)
    {
        ContactMessage::destroy($id);
        session()->flash('message', 'Messaggio eliminato con successo!');
    }

    public function closeModal()
    {
        $this->showMessageModal = false;
        $this->selectedMessage = null;
    }
}