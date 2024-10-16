@extends('auth._elements.layout')

@section('title', 'Inscription')


@section('meta_title', "Inscription - JerHomeCoaching")
@section('meta_description', "Rejoins JerHomeCoaching dès maintenant ! Crée ton compte et profite de ta première séance gratuite avec Jérôme, ton coach sportif perso.")

@section('content')

<div class="p-4 shadow card border-primary mb-3" style="max-width: 600px; width: 100%;">
    <div class="mb-4">
        <h3 class="mt-3" style="font-family: 'Raleway'">Inscription</h3>
    </div>
    <form action="{{ route('auth.toRegister') }}" method="post">
        @csrf

        <div class="row">
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre prénom" 
                        autofocus 
                        required 
                        value="{{ old('firstname') }}"
                    >
                </div>
            </div>
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre nom"
                        required 
                        value="{{ old('lastname') }}"
                    >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre numéro de téléphone" 
                        required 
                        value="{{ old('phone') }}"
                    >
                </div>
            </div>
            <div class="col-lg-6 col-12">
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
                    placeholder="Entrez votre e-mail" 
                    required 
                    value="{{ old('email') }}"
                >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre adresse" 
                        required 
                        value="{{ old('address') }}"
                    >
                    {{-- <div class="dropdown-menu w-100" id="search-results">
                        <li class="dropdown-item loading">Chargement...</li>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre ville" 
                        required 
                        value="{{ old('city') }}"
                    >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre code postal" 
                        required 
                        value="{{ old('postal_code') }}"
                    >
                </div>
            </div>
            <div class="col-lg-6 col-12">
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
                        placeholder="Entrez votre pays" 
                        required 
                        value="{{ old('country') }}"
                    >
                </div>
            </div>
        </div>
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
                placeholder="Entrez un complément d'adresse"
            >{{ old('address_complement') }}</textarea>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="mb-3">
                    <label for="password" class="form-label">
                        Mot de passe
                        <span class="text-muted">
                            *
                        </span>
                    </label>
                    <div class="input-group">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            placeholder="Entrez votre mot de passe" 
                            required 
                        >
                        <button type="button" class="input-group-text show-pass btn btn-primary">
                            <i class="fa fa-eye-slash"></i>
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        Confirmer le mot de passe
                        <span class="text-muted">
                            *
                        </span>
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                        id="password_confirmation" 
                        placeholder="Confirmez votre mot de passe" 
                        required
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mb-3">
                <div class="custom-control custom-checkbox">
                    <input 
                        class="custom-control-input" 
                        type="checkbox" 
                        value="1" 
                        id="privacy_terms" 
                        name="privacy_terms"
                        required
                    >
                    <label class="custom-control-label 
                        @error('privacy_terms') is-invalid @enderror" 
                        for="privacy_terms"
                    >
                        J'ai lu et j'accepte la 
                        <a href="{{ route('main.legal.privacy') }}" target="_blank" class="text-decoration-underline text-white">
                            politique de confidentialité
                        </a>
                    </label>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 mt-2">
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            <a href="{{ route('auth.login') }}" class="btn btn-outline-primary w-100">Connexion</a>
        </div>
    </form>
</div>

@endsection

{{-- @section('scripts')
    @vite('resources/js/auth/location.js')
@endsection --}}