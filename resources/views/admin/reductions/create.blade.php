@extends('admin._elements.layout')

@section('title', 'Ajouter un code de réduction')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.reductions.index') }}">Réductions</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un code de réduction</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

   

     {{-- Content Header --}}
     <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Ajouter un code de réduction
            </h4>
            <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-secondary ">
                <i class="fa fa-arrow-left me-2"></i>
                <span>
                    Retour
                </span>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez ajouter un nouveau code de réduction.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <form action="{{ route('admin.reductions.store') }}" method="post">
            @csrf
    

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code de réduction</label>
                        <div class="input-group">
                            <input 
                                type="text" 
                                class="form-control @error('code') is-invalid @enderror" 
                                id="code" 
                                name="code" 
                                placeholder="Entrez un code de réduction unique" 
                                autofocus 
                                required 
                                value="{{ old('code') }}"
                            >
                            <a 
                                href="javascript:void(0)" 
                                class="btn btn-outline-primary" 
                                id="generate-code"
                                title="Générer un code de réduction"
                            >
                                <i class="fas fa-random"></i>
                            </a>
                            <a 
                                href="javascript:void(0)" 
                                class="btn btn-outline-primary" 
                                id="clear-code"
                                title="Supprimer le code de réduction"
                                style="display: none;"
                            >
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Pourcentage de réduction</label>
                        <input 
                            type="number" 
                            class="form-control @error('percentage') is-invalid @enderror" 
                            id="percentage" 
                            name="percentage" 
                            placeholder="Entrez le pourcentage de réduction" 
                            required 
                            value="{{ old('percentage') }}"
                            max="100"
                            min="1"
                        >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Date de début</label>
                        <input 
                            type="date" 
                            class="form-control @error('start_date') is-invalid @enderror" 
                            id="start_date" 
                            name="start_date" 
                            placeholder="Entrez la date de début" 
                            required 
                            value="{{ old('start_date') }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Date de fin</label>
                        <input 
                            type="date" 
                            class="form-control @error('end_date') is-invalid @enderror" 
                            id="end_date" 
                            name="end_date" 
                            placeholder="Entrez la date de fin" 
                            required 
                            value="{{ old('end_date') }}"
                        >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 d-flex align-items-center">
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="online" value="0">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="online" 
                            name="online"
                            value="1"
                            @if(old('online') == 1) checked @endif
                        >
                        <label class="custom-control-label" for="online">En ligne ?</label>
                        <div class="text-muted font-weight-light">
                            Si vous cochez cette case, le code de réduction sera utilisable si les dates de validité sont respectées.
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Ajouter le code de réduction
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
    @vite('resources/js/pages/admin/reductions.js')
@endsection
