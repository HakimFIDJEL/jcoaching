@extends('admin._elements.layout')

@section('title', 'Modifier ' . $admin->firstname . ' ' . $admin->lastname)


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Administrateurs</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Modifier vos informations</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Bonjour {{ $admin->firstname }} {{ $admin->lastname }}</h2>
                <p class="text-light">
                    Vous pouvez modifier vos informations ci-dessous.
                </p>
            </div>	
            <span>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary ">
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
                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">Sécurité</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pfp-tab" data-bs-toggle="tab" data-bs-target="#pfp" type="button" role="tab" aria-controls="pfp" aria-selected="false">Photo de profil</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">
                
                <form action="{{ route('admin.admins.update') }}" method="post">
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
                                    placeholder="Entrez votre prénom" 
                                    autofocus 
                                    required 
                                    value="{{ $admin->firstname }}"
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
                                    placeholder="Entrez votre nom"
                                    required 
                                    value="{{ $admin->lastname }}"
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
                                    placeholder="Entrez votre numéro de téléphone" 
                                    required 
                                    value="{{ $admin->phone }}"
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
                                placeholder="Entrez votre e-mail" 
                                required 
                                value="{{ $admin->email }}"
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
                                    placeholder="Entrez votre adresse" 
                                    required 
                                    value="{{ $admin->address }}"
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
                                    placeholder="Entrez votre ville" 
                                    required 
                                    value="{{ $admin->city }}"
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
                                    placeholder="Entrez votre code postal" 
                                    required 
                                    value="{{ $admin->postal_code }}"
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
                                    placeholder="Entrez votre pays" 
                                    required 
                                    value="{{ $admin->country }}"
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
                                >{{ $admin->address_complement }}</textarea>
                            </div>
                        </div> 
                    </div>
        
                    
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <span>
                                Modifier vos informations
                            </span>
                            <i class="fas fa-user-edit ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                <form action="{{ route('admin.admins.updatePassword') }}" method="post">
                    @csrf
            
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mot de passe actuel</label>
                                <input 
                                    type="password" 
                                    class="form-control @error('current_password') is-invalid @enderror" 
                                    id="current_password" 
                                    name="current_password" 
                                    placeholder="Entrez votre mot de passe actuel" 
                                    autofocus 
                                    required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Entrez votre nouveau mot de passe" 
                                    required 
                                >
                            </div>
                        </div>
                        <div class="col">
                            <label for="password_confirmation" class="form-label">Confirmez votre nouveau mot de passe</label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Confirmez votre nouveau mot de passe" 
                                required
                            >
                        </div>
                    </div>
        
                    
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <span>
                                Modifier votre mot de passe
                            </span>
                            <i class="fas fa-key ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="pfp" role="tabpanel" aria-labelledby="pfp-tab">
                <form action="{{ route('admin.admins.update-pfp') }}" method="post" enctype="multipart/form-data">
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
                                @if($admin->pfp_path)
                                    data-documents="{{ json_encode([[
                                        'source' => asset('storage/' . str_replace('public/', '', $admin->pfp_path)),
                                    ]]) }}"
                                @endif
                            >
                        </div>
                    </div>
                    
        
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <span>
                                    Modifier votre photo de profil
                                </span>
                                <i class="fas fa-upload ms-2"></i>
                            </button>
                        </div>
                        @if($admin->pfp_path)
                            <div class="col-4">
                                <a href="{{ route('admin.admins.download-pfp', ['user' => $admin]) }}" class="btn btn-secondary w-100">
                                    <span>
                                        Télécharger votre photo de profil
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

