@extends('admin._elements.layout')

@section('title', 'Ajouter un tarif')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pricings.index') }}">Tarifs</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un tarif</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Créer un tarif
            </h4>
            <a href="{{ route('admin.pricings.index') }}" class="btn btn-secondary ">
                <i class="fa fa-arrow-left me-2"></i>
                <span>
                    Retour
                </span>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Créez un nouveau tarif pour votre application.  
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <form action="{{ route('admin.pricings.store') }}" method="post">
            @csrf

            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing" type="button" role="tab" aria-controls="pricing" aria-selected="true">Tarif</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false">Spécificités</button>
                </li>
            </ul>
    
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                    
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Titre
                                    <span class="text-muted">
                                        *
                                    </span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror" 
                                    id="title" 
                                    name="title" 
                                    placeholder="Entrez le titre" 
                                    autofocus 
                                    required 
                                    value="{{ old('title') }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="subtitle" class="form-label">
                                    Sous-titre
                                    <span class="text-muted">
                                        *
                                    </span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('subtitle') is-invalid @enderror" 
                                    id="subtitle" 
                                    name="subtitle" 
                                    placeholder="Entrez le sous-titre"
                                    required 
                                    value="{{ old('subtitle') }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    Description
                                    <span class="text-muted">
                                        *
                                    </span>
                                </label>
    
                                <textarea 
                                    class="form-control editor @error('description') is-invalid @enderror" 
                                    name="description" 
                                    id="description" 
                                    rows="2" 
                                    style="resize: none;" 
                                    placeholder="Entrez la description"
                                >{{ old('description') }}</textarea>
                                
                            </div>
                        </div>
    
    
                        <div class="col-3 d-flex align-items-center">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="online" value="0">
                                <input 
                                    type="checkbox" 
                                    class="custom-control-input" 
                                    id="online" 
                                    name="online"
                                    value="1"
                                    {{ old('online') ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="online">En ligne ?</label>
                                <div class="text-muted font-weight-light">
                                    Si vous cochez cette case, le tarif sera visible sur le site.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="nbr_sessions" class="form-label">
                                    Nombre de séances
                                    <span class="text-muted">
                                        *
                                    </span>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('nbr_sessions') is-invalid @enderror"
                                    id="nbr_sessions"
                                    name="nbr_sessions"
                                    placeholder="Entrez le nombre de séances"
                                    required
                                    value="{{ old('nbr_sessions') }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="price" class="form-label">
                                    Prix
                                    <span class="text-muted">
                                        *
                                    </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control @error('price') is-invalid @enderror"
                                    id="price"
                                    name="price"
                                    placeholder="Entrez le prix"
                                    required
                                    value="{{ old('price') }}"
                                >
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="tab-pane fade" id="feature" role="tabpanel" aria-labelledby="feature-tab">

                    {{-- Add Button --}}
                    <div class="row d-flex justify-content-end">
                        <div class="col-3 d-flex justify-content-end">
                            <a href="javascript:void(0);" class="btn btn-outline-primary mt-2" id="add-feature">
                                <span>
                                    Ajouter une spécificité 
                                    <span class="text-muted">
                                        *
                                    </span>
                                </span>
                                <i class="fas fa-plus ms-2"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div id="features-container">



                        
                    </div>

                                        
            </div>



            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Ajouter le tarif
                    </span>
                    <i class="fas fa-plus ms-2"></i>
                </button>
            </div>

        </form>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection


@section('scripts')
    @vite('resources/js/plugins/ckeditor.js')
    @vite('resources/js/pages/admin/pricings.js')
@endsection