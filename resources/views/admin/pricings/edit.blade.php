@extends('admin._elements.layout')

@section('title', 'Ajouter un tarif')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pricings.index') }}">Tarifs</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Modifier un tarif</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Modifier un tarif</h2>
                <p class="text-light">
                    Modifiez un tarif pour le rendre visible sur le site. A noter qu'un tarif est renouvelable tous les 30 jours.
                </p>
            </div>	
            <span>
                <a href="{{ route('admin.pricings.index') }}" class="btn btn-secondary ">
                    <i class="fa fa-arrow-left me-2"></i>
                    <span>
                        Retour
                    </span>
                </a>
            </span>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <form action="{{ route('admin.pricings.update', ['pricing' => $pricing]) }}" method="post">
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
                                <label for="title" class="form-label">Titre</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror" 
                                    id="title" 
                                    name="title" 
                                    placeholder="Entrez le titre" 
                                    autofocus 
                                    required 
                                    value="{{ $pricing->title }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="subtitle" class="form-label">Sous-titre</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('subtitle') is-invalid @enderror" 
                                    id="subtitle" 
                                    name="subtitle" 
                                    placeholder="Entrez le sous-titre"
                                    required 
                                    value="{{ $pricing->subtitle }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
    
                                <textarea 
                                    class="form-control editor @error('description') is-invalid @enderror" 
                                    name="description" 
                                    id="description" 
                                    rows="2" 
                                    style="resize: none;" 
                                    placeholder="Entrez la description"
                                >{!! $pricing->description !!}</textarea>
                                
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
                                    checked="{{ $pricing->online == 1 ? 'checked' : '' }}"
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
                                <label for="nbr_sessions" class="form-label">Nombre de sessions</label>
                                <input
                                    type="number"
                                    class="form-control @error('nbr_sessions') is-invalid @enderror"
                                    id="nbr_sessions"
                                    name="nbr_sessions"
                                    placeholder="Entrez le nombre de sessions"
                                    required
                                    value="{{ $pricing->nbr_sessions }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="price" class="form-label">Prix</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control @error('price') is-invalid @enderror"
                                    id="price"
                                    name="price"
                                    placeholder="Entrez le prix"
                                    required
                                    value="{{ $pricing->price }}"
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
                                </span>
                                <i class="fas fa-plus ms-2"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div id="features-container">

                        @php 
                            $count = 0;
                        @endphp

                        @foreach($pricing->features as $feature)

                            @php 
                                $count++;
                            @endphp

                            <div class="row mb-3 feature-row" data-feature-id="{{ $count }}">
                                <div class="col">
                                    <div>
                                        <label for="feature_{{ $count }}" class="form-label">Spécifité {{ $count }}</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="feature_{{ $count }}"
                                            name="features[]" 
                                            value="{{ $feature->label }}" 
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-1 d-flex align-items-end justify-content-end">
                                    <a href="javascript:void(0);" title="Supprimer la spécificité" class="btn btn-outline-danger mt-2 remove-feature">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                                        
            </div>



            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Modifier le tarif
                    </span>
                    <i class="fas fa-edit ms-2"></i>
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