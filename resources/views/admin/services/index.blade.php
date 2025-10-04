<x-layouts.admin title="Gestione Servizi">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Servizi</h2>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuovo Servizio
        </a>
    </div>

    @if($services->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Icona</th>
                                <th>Nome</th>
                                <th>Descrizione</th>
                                <th>Stato</th>
                                <th>Ordine</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        @if($service->icon)
                                            <svg class="color" width="30" height="30">
                                                <use xlink:href="#{{ $service->icon }}"></use>
                                            </svg>
                                        @else
                                            <span class="text-muted">Nessuna icona</span>
                                        @endif
                                    </td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ Str::limit($service->description, 50) }}</td>
                                    <td>
                                        @if($service->is_active)
                                            <span class="badge bg-success">Attivo</span>
                                        @else
                                            <span class="badge bg-secondary">Inattivo</span>
                                        @endif
                                    </td>
                                    <td>{{ $service->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.services.edit', $service) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                                                  class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questo servizio?')">
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
                <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessun servizio trovato</h5>
                <p class="text-muted">Inizia creando il tuo primo servizio.</p>
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crea Primo Servizio
                </a>
            </div>
        </div>
    @endif
</x-layouts.admin>
