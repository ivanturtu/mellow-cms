<x-layouts.admin title="Profilo">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>{{ __('Informazioni Profilo') }}
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lock me-2"></i>{{ __('Cambia Password') }}
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="card mb-4 border-danger">
                <div class="card-header bg-danger bg-opacity-10">
                    <h5 class="mb-0 text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Zona Pericolosa') }}
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
