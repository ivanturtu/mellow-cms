<x-layouts.admin title="Gestione Slider">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Slider</h2>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuovo Slider
        </a>
    </div>

    @if($sliders->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Immagine</th>
                                <th>Titolo</th>
                                <th>CTA</th>
                                <th>Stato</th>
                                <th>Ordine</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>
                                        @if($slider->image)
                                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" 
                                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Nessuna immagine</span>
                                        @endif
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>
                                        @if($slider->cta_text)
                                            <span class="badge bg-info">{{ $slider->cta_text }}</span>
                                        @else
                                            <span class="text-muted">Nessun CTA</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($slider->is_active)
                                            <span class="badge bg-success">Attivo</span>
                                        @else
                                            <span class="badge bg-secondary">Inattivo</span>
                                        @endif
                                    </td>
                                    <td>{{ $slider->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" 
                                                  class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questo slider?')">
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
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nessuno slider trovato</h5>
                <p class="text-muted">Inizia creando il tuo primo slider per la homepage.</p>
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crea Primo Slider
                </a>
            </div>
        </div>
    @endif
</x-layouts.admin>

