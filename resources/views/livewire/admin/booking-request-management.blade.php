<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">Gestione Richieste Prenotazione</h2>
        <div class="d-flex gap-2">
            <span class="badge bg-primary">{{ $bookingRequests->total() }} Richieste</span>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtri e Ricerca -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cerca</label>
                    <input type="text" class="form-control" id="search" wire:model.live="search" 
                           placeholder="Email, telefono, date...">
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Stato</label>
                    <select class="form-select" id="statusFilter" wire:model.live="statusFilter">
                        <option value="">Tutti gli stati</option>
                        <option value="pending">In attesa</option>
                        <option value="confirmed">Confermata</option>
                        <option value="cancelled">Cancellata</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="perPage" class="form-label">Per pagina</label>
                    <select class="form-select" id="perPage" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabella Richieste -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th wire:click="sortBy('id')" style="cursor: pointer;">
                                ID
                                @if($sortBy === 'id')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('checkin_date')" style="cursor: pointer;">
                                Check-in
                                @if($sortBy === 'checkin_date')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('checkout_date')" style="cursor: pointer;">
                                Check-out
                                @if($sortBy === 'checkout_date')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Ospiti</th>
                            <th>Camere</th>
                            <th>Contatto</th>
                            <th wire:click="sortBy('status')" style="cursor: pointer;">
                                Stato
                                @if($sortBy === 'status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                Data Richiesta
                                @if($sortBy === 'created_at')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingRequests as $booking)
                            <tr>
                                <td><strong>#{{ $booking->id }}</strong></td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $booking->checkin_date->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $booking->checkout_date->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $booking->guests }} ospiti</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $booking->rooms }} camere</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">{{ $booking->email }}</small>
                                        @if($booking->phone)
                                            <small class="text-muted">{{ $booking->phone }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @switch($booking->status)
                                        @case('pending')
                                            <span class="badge bg-warning">In attesa</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-success">Confermata</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancellata</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $booking->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Cambio Stato -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       wire:click="updateStatus({{ $booking->id }}, 'pending')">
                                                        <i class="fas fa-clock text-warning me-2"></i>In attesa
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       wire:click="updateStatus({{ $booking->id }}, 'confirmed')">
                                                        <i class="fas fa-check text-success me-2"></i>Conferma
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       wire:click="updateStatus({{ $booking->id }}, 'cancelled')">
                                                        <i class="fas fa-times text-danger me-2"></i>Cancella
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Elimina -->
                                        <button class="btn btn-sm btn-outline-danger" 
                                                wire:click="deleteBooking({{ $booking->id }})"
                                                onclick="return confirm('Sei sicuro di voler eliminare questa richiesta?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Nessuna richiesta di prenotazione trovata</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Paginazione -->
        @if($bookingRequests->hasPages())
            <div class="card-footer">
                {{ $bookingRequests->links() }}
            </div>
        @endif
    </div>
</div>
