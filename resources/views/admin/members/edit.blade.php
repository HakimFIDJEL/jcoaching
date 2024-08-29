@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Membres</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Modifier un membre</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Modifier {{ $member->firstname }} {{ $member->lastname }}</h2>
                <p class="text-light">
                    Vous pouvez modifier les informations de {{ $member->firstname }} {{ $member->lastname }} ici.
                </p>
            </div>	
            <span>
                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary ">
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

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="informations-tab" data-bs-toggle="tab" data-bs-target="#informations" type="button" role="tab" aria-controls="informations" aria-selected="true">Informations</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pfp-tab" data-bs-toggle="tab" data-bs-target="#pfp" type="button" role="tab" aria-controls="pfp" aria-selected="false">Photo de profil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="document-tab" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab" aria-controls="document" aria-selected="false">Documents</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">
                
                <form action="{{ route('admin.members.update', ['user' => $member]) }}" method="post">
                    @csrf
            
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Prénom</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('firstname') is-invalid @enderror" 
                                    id="firstname" 
                                    name="firstname" 
                                    placeholder="Entrez le prénom" 
                                    autofocus 
                                    required 
                                    value="{{ $member->firstname }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Nom</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('lastname') is-invalid @enderror" 
                                    id="lastname" 
                                    name="lastname" 
                                    placeholder="Entrez le nom"
                                    required 
                                    value="{{ $member->lastname }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" 
                                    name="phone" 
                                    placeholder="Entrez le numéro de téléphone" 
                                    required 
                                    value="{{ $member->phone }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="Entrez l'e-mail" 
                                required 
                                value="{{ $member->email }}"
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3 form-group position-relative">
                                <label for="address" class="form-label">Adresse</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('address') is-invalid @enderror" 
                                    id="address" 
                                    name="address" 
                                    placeholder="Entrez l'adresse" 
                                    required 
                                    value="{{ $member->address }}"
                                >
                                {{-- <div class="dropdown-menu w-100" id="search-results">
                                    <li class="dropdown-item loading">Chargement...</li>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('city') is-invalid @enderror" 
                                    id="city" 
                                    name="city" 
                                    placeholder="Entrez la ville" 
                                    required 
                                    value="{{ $member->city }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="postal_code" class="form-label">Code postal</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('postal_code') is-invalid @enderror" 
                                    id="postal_code" 
                                    name="postal_code" 
                                    placeholder="Entrez le code postal" 
                                    required 
                                    value="{{ $member->postal_code }}"
                                >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="country" class="form-label">Pays</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('pays') is-invalid @enderror" 
                                    id="country" 
                                    name="country" 
                                    placeholder="Entrez le pays" 
                                    required 
                                    value="{{ $member->country }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="address_complement" class="form-label">Complément d'adresse (facultatif)</label>
                                <textarea 
                                    class="form-control @error('address_complement') is-invalid @enderror" 
                                    name="address_complement" 
                                    id="address_complement" 
                                    rows="2" 
                                    style="resize: none;" 
                                    placeholder="Entrez ou non un complément d'adresse"
                                >{{ $member->address_complement }}</textarea>
                            </div>
                        </div> 
                        <div class="col d-flex align-items-center">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="email_verified" value="0">
                                <input 
                                    type="checkbox" 
                                    class="custom-control-input" 
                                    id="email_verified" 
                                    name="email_verified"
                                    value="1"
                                    checked={{ $member->email_verified_at ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="email_verified">Vérifier l'adresse e-mail ?</label>
                                <div class="text-muted font-weight-light">
                                    En cochant cette case, le membre n'aura pas à vérifier son adresse e-mail.
                                </div>
                            </div>
                        </div>
                    </div>
        
                    
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <span>
                                Modifier les informations
                            </span>
                            <i class="fas fa-user-edit ms-2"></i>
                        </button>
                    </div>
                </form>


            </div>

            <div class="tab-pane fade" id="pfp" role="tabpanel" aria-labelledby="pfp-tab">
                
                <form action="{{ route('admin.members.update-pfp', ['user' => $member]) }}" method="post" enctype="multipart/form-data">
                    @csrf
            
                    <div class="row">
                        <div class="col">
                            <label for="pfp" class="form-label">Photo de profil</label>
                            <input 
                                type="file"
                                class="filepond"
                                id="pfp"
                                name="pfp"
                                accept="image/*, video/*"
                                data-max-files="1"
                                @if($member->pfp_path)
                                    data-documents="{{ json_encode([[
                                        'source' => asset('storage/' . str_replace('public/', '', $member->pfp_path)),
                                    ]]) }}"
                                @endif                                
                            >
                        </div>
                    </div>
                    
        
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <span>
                                    Modifier la photo de profil
                                </span>
                                <i class="fas fa-upload ms-2"></i>
                            </button>
                        </div>
                        @if($member->pfp_path)
                            <div class="col-4">
                                <a href="{{ route('admin.members.download-pfp', ['user' => $member]) }}" class="btn btn-secondary w-100">
                                    <span>
                                        Télécharger la photo de profil
                                    </span>
                                    <i class="fas fa-download ms-2"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                
                <form action="{{ route('admin.members.update-documents', ['user' => $member]) }}" method="post" enctype="multipart/form-data">
                    @csrf
            
                    <div class="row">
                        <div class="col">
                            <label for="documents[]" class="form-label">Documents (5 maximum)</label>
                            <input 
                                type="file"
                                class="filepond"
                                id="documents[]"
                                name="documents[]"
                                data-max-files="5"
                                accept="application/pdf"     
                                @if($member->documents->count() > 0)
                                    data-documents="{{ json_encode($member->documents->map(function($doc) {
                                        return [
                                            'source' => asset('storage/' . str_replace('public/', '', $doc->path)),
                                        ];
                                    })) }}"
                                @endif       
                            >
                        </div>
                    </div>
                    
        
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <span>
                                    Modifier les documents
                                </span>
                                <i class="fas fa-upload ms-2"></i>
                            </button>
                        </div>
                        @if($member->documents->count() > 0)
                            <div class="col-4">
                                <a href="{{ route('admin.members.download-documents', ['user' => $member]) }}" class="btn btn-secondary w-100">
                                    <span>
                                        Télécharger les documents
                                    </span>
                                    <i class="fas fa-download ms-2"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>


    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

