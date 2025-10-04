<x-layouts.admin title="Gestione Camere">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Camere</h2>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuova Camera
        </a>
    </div>

    @if($rooms->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Immagine</th>
                                <th>Nome</th>
                                <th>Prezzo</th>
                                <th>Capacità</th>
                                <th>Stato</th>
                                <th>Ordine</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td>
                                        @if($room->image)
                                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" 
                                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Nessuna immagine</span>
                                        @endif
                                    </td>
                                    <td>{{ $room->name }}</td>
                                    <td>€{{ $room->price }}</td>
                                    <td>{{ $room->capacity }} persone</td>
                                    <td>
                                        @if($room->is_active)
                                            <span class="badge bg-success">Attiva</span>
                                        @else
                                            <span class="badge bg-secondary">Inattiva</span>
                                        @endif
                                    </td>
                                    <td>{{ $room->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.rooms.edit', $room) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" 
                                                  class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa camera?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessuna camera trovata</h5>
                <p class="text-muted">Inizia creando la tua prima camera.</p>
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crea Prima Camera
                </a>
            </div>
        </div>
    @endif
</x-layouts.admin>

