@extends('admin._elements.layout')

@section('title', 'Ajouter un média')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.medias.index') }}">Médias</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un média</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Ajouter un média</h2>
                <p class="text-light">
                    Remplissez le formulaire ci-dessous pour ajouter un média à la galerie
                </p>
            </div>	
            <span>
                <a href="{{ route('admin.medias.index') }}" class="btn btn-secondary ">
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
        <form action="{{ route('admin.medias.store') }}" method="post" enctype="multipart/form-data">
            @csrf


            <div class="row">
                <div class="col-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Libellé</label>
                        <input 
                            type="text" 
                            class="form-control @error('label') is-invalid @enderror" 
                            id="label" 
                            name="label" 
                            placeholder="Entrez le libellé du média" 
                            autofocus 
                            required 
                            value="{{ old('label') }}"
                        >
                    </div>
                    <div class="custom-control custom-switch mb-3">
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
                            Si vous cochez cette case, le média sera visible sur le site.
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="file" class="form-label">Média</label>
                        <input 
                            type="file" 
                            class="filepond" 
                            id="file" 
                            name="file" 
                            accept="image/*, video/*"
                            data-max-files="1"
                            required
                        >
                    </div>
                </div>
            </div>

    
            
            

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Ajouter le média
                    </span>
                    <i class="fa fa-plus ms-2"></i>
                </button>
            </div>
        </form>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection


@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

