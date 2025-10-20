<?php

namespace App\Livewire\Admin;

use App\Models\BookingRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class BookingRequestManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updateStatus($bookingId, $status)
    {
        $booking = BookingRequest::findOrFail($bookingId);
        $booking->update(['status' => $status]);
        
        session()->flash('message', 'Stato della richiesta aggiornato con successo!');
    }

    public function deleteBooking($bookingId)
    {
        $booking = BookingRequest::findOrFail($bookingId);
        $booking->delete();
        
        session()->flash('message', 'Richiesta eliminata con successo!');
    }

    public function render()
    {
        $query = BookingRequest::query();

        // Filtro per ricerca
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('checkin_date', 'like', '%' . $this->search . '%')
                  ->orWhere('checkout_date', 'like', '%' . $this->search . '%');
            });
        }

        // Filtro per stato
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Ordinamento
        $query->orderBy($this->sortBy, $this->sortDirection);

        $bookingRequests = $query->paginate($this->perPage);

        return view('livewire.admin.booking-request-management', [
            'bookingRequests' => $bookingRequests
        ]);
    }
}
