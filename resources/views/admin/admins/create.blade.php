@extends('admin._elements.layout')

@section('title', 'Ajouter un administrateur')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Administrateurs</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un administrateur</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

     {{-- Content Header --}}
     <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Ajouter un administrateur
            </h4>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary ">
                <i class="fa fa-arrow-left me-2"></i>
                <span>
                    Retour
                </span>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez créer les administrateurs de votre application.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <form action="{{ route('admin.admins.store') }}" method="post">
            @csrf
    
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">
                            Prénom
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('firstname') is-invalid @enderror" 
                            id="firstname" 
                            name="firstname" 
                            placeholder="Entrez le prénom" 
                            autofocus 
                            required 
                            value="{{ old('firstname') }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">
                            Nom
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('lastname') is-invalid @enderror" 
                            id="lastname" 
                            name="lastname" 
                            placeholder="Entrez le nom"
                            required 
                            value="{{ old('lastname') }}"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            Téléphone
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            id="phone" 
                            name="phone" 
                            placeholder="Entrez le numéro de téléphone" 
                            required 
                            value="{{ old('phone') }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <label for="email" class="form-label">
                        Adresse e-mail
                        <span class="text-muted">
                            *
                        </span>
                    </label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        placeholder="Entrez l'e-mail" 
                        required 
                        value="{{ old('email') }}"
                    >
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3 form-group position-relative">
                        <label for="address" class="form-label">
                            Adresse
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('address') is-invalid @enderror" 
                            id="address" 
                            name="address" 
                            placeholder="Entrez l'adresse" 
                            required 
                            value="{{ old('address') }}"
                        >
                        {{-- <div class="dropdown-menu w-100" id="search-results">
                            <li class="dropdown-item loading">Chargement...</li>
                        </div> --}}
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="city" class="form-label">
                            Ville
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('city') is-invalid @enderror" 
                            id="city" 
                            name="city" 
                            placeholder="Entrez la ville" 
                            required 
                            value="{{ old('city') }}"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">
                            Code postal
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('postal_code') is-invalid @enderror" 
                            id="postal_code" 
                            name="postal_code" 
                            placeholder="Entrez le code postal" 
                            required 
                            value="{{ old('postal_code') }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="country" class="form-label">
                            Pays
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('pays') is-invalid @enderror" 
                            id="country" 
                            name="country" 
                            placeholder="Entrez le pays" 
                            required 
                            value="{{ old('country') }}"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="address_complement" class="form-label">
                            Complément d'adresse
                            <span class="text-muted fw-light">
                                (facultatif)
                            </span>
                        </label>
                        <textarea 
                            class="form-control @error('address_complement') is-invalid @enderror" 
                            name="address_complement" 
                            id="address_complement" 
                            rows="2" 
                            style="resize: none;" 
                            placeholder="Entrez ou non un complément d'adresse"
                        >{{ old('address_complement') }}</textarea>
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
                            {{ old('email_verified') ? 'checked' : '' }}
                        >
                        <label class="custom-control-label" for="email_verified">Vérifier l'adresse e-mail ?</label>
                        <div class="text-muted font-weight-light">
                            En cochant cette case, l'administrateur n'aura pas à vérifier son adresse e-mail.
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Ajouter l'administrateur
                    </span>
                    <i class="fas fa-user-plus ms-2"></i>
                </button>
            </div>
        </form>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection

