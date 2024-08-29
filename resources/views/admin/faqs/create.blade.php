@extends('admin._elements.layout')

@section('title', 'Ajouter une faq')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">Faqs</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter une faq</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Ajouter une faq</h2>
                <p class="text-light">
                    On vous pose souvent les mêmes questions ? Créez une FAQ pour y répondre.
                </p>
            </div>	
            <span>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary ">
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
        <form action="{{ route('admin.faqs.store') }}" method="post">
            @csrf
    
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input 
                            type="text" 
                            class="form-control @error('question') is-invalid @enderror" 
                            id="question" 
                            name="question" 
                            placeholder="Entrez la question" 
                            autofocus 
                            required 
                            value="{{ old('question') }}"
                        >
                    </div>
                </div>
            </div>
            
            
            
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="answer" class="form-label">Réponse</label>

                        {{-- Richeditor --}}
                        <textarea 
                            class="form-control editor @error('answer') is-invalid @enderror" 
                            name="answer" 
                            id="answer" 
                            rows="2" 
                            style="resize: none;" 
                            placeholder="Entrez la réponse"
                        >{{ old('answer') }}</textarea>
                        
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
                            Si vous cochez cette case, la faq sera visible sur le site.
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Ajouter la faq
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