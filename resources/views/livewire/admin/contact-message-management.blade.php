<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Gestione Messaggi di Contatto</h1>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Elenco Messaggi di Contatto</h6>
            <div class="d-flex">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control me-2" placeholder="Cerca per nome, email, oggetto...">
                <select wire:model.live="statusFilter" class="form-select">
                    <option value="">Tutti gli stati</option>
                    <option value="new">Nuovo</option>
                    <option value="read">Letto</option>
                    <option value="replied">Risposto</option>
                    <option value="archived">Archiviato</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('id')" style="cursor: pointer;">ID
                                @if ($sortField == 'id')
                                    <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('name')" style="cursor: pointer;">Nome
                                @if ($sortField == 'name')
                                    <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('email')" style="cursor: pointer;">Email
                                @if ($sortField == 'email')
                                    <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('subject')" style="cursor: pointer;">Oggetto
                                @if ($sortField == 'subject')
                                    <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('status')" style="cursor: pointer;">Stato
                                @if ($sortField == 'status')
                                    <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('created_at')" style="cursor: pointer;">Data
                                @if ($sortField == 'created_at')
                                    <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @endif
                            </th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>{{ $message->name }}</td>
                                <td>
                                    <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                        {{ $message->email }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($message->subject, 30) }}</td>
                                <td>
                                    <span class="{{ $message->status_badge }}">
                                        {{ $message->status_text }}
                                    </span>
                                </td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $message->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Azioni
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $message->id }}">
                                            <li><a class="dropdown-item" href="#" wire:click="viewMessage({{ $message->id }})"><i class="fas fa-eye text-info me-2"></i>Visualizza</a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="updateStatus({{ $message->id }}, 'read')"><i class="fas fa-envelope-open text-info me-2"></i>Segna come letto</a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="updateStatus({{ $message->id }}, 'replied')"><i class="fas fa-reply text-success me-2"></i>Segna come risposto</a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="updateStatus({{ $message->id }}, 'archived')"><i class="fas fa-archive text-warning me-2"></i>Archivia</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" wire:click="deleteMessage({{ $message->id }})" onclick="return confirm('Sei sicuro di voler eliminare questo messaggio?')"><i class="fas fa-trash me-2"></i>Elimina</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nessun messaggio di contatto trovato.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $messages->links() }}
        </div>
    </div>

    <!-- Message Modal -->
    @if($showMessageModal && $selectedMessage)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Messaggio di Contatto</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nome:</strong> {{ $selectedMessage->name }}
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong> 
                                <a href="mailto:{{ $selectedMessage->email }}" class="text-decoration-none">
                                    {{ $selectedMessage->email }}
                                </a>
                            </div>
                        </div>
                        @if($selectedMessage->phone)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Telefono:</strong> 
                                    <a href="tel:{{ $selectedMessage->phone }}" class="text-decoration-none">
                                        {{ $selectedMessage->phone }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Oggetto:</strong> {{ $selectedMessage->subject }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Messaggio:</strong>
                                <div class="mt-2 p-3 bg-light rounded">
                                    {{ $selectedMessage->message }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Data invio:</strong> {{ $selectedMessage->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Stato:</strong> 
                                <span class="{{ $selectedMessage->status_badge }}">
                                    {{ $selectedMessage->status_text }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Chiudi</button>
                        <a href="mailto:{{ $selectedMessage->email }}?subject=Re: {{ $selectedMessage->subject }}" class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i>Rispondi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>