@extends('admin._elements.layout')

@section('title', 'Ajouter un témoignage')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.feedbacks.index') }}">Témoignages</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un témoignage</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Ajouter un témoignage</h2>
                <p class="text-light">
                    Quelqu'un veut partager son expérience ? Ou vous voulez tout simplement ajouter une citation ?
                </p>
            </div>	
            <span>
                <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-secondary ">
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
        <form action="{{ route('admin.feedbacks.store') }}" method="post">
            @csrf
    
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom complet</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            placeholder="Entrez le nom complet" 
                            autofocus 
                            required 
                            value="{{ old('name') }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="job" class="form-label">Emploi / Métier</label>
                        <input 
                            type="text" 
                            class="form-control @error('job') is-invalid @enderror" 
                            id="job" 
                            name="job" 
                            placeholder="Entrez l'emploi ou le métier (ou les deux)"
                            required 
                            value="{{ old('job') }}"
                        >
                    </div>
                </div>
            </div>
            
            
            
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="message" class="form-label">Témoignage</label>

                        {{-- Richeditor --}}
                        <textarea 
                            class="form-control editor @error('message') is-invalid @enderror" 
                            name="message" 
                            id="message" 
                            rows="2" 
                            style="resize: none;" 
                            placeholder="Entrez le contenu du témoignage"
                        >{{ old('message') }}</textarea>
                        
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
                            checked={{ old('online') ? 'checked' : '' }}
                        >
                        <label class="custom-control-label" for="online">En ligne ?</label>
                        <div class="text-muted font-weight-light">
                            Si vous cochez cette case, le témoignage sera visible sur le site.
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Ajouter le témoignage
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
@endsection