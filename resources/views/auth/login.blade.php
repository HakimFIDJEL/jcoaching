@extends('auth._elements.layout')

@section('title', 'Connexion')


@section('meta_title', "Connexion - JerHomeCoaching")
@section('meta_description', "Connecte-toi à ton espace membre JerHomeCoaching pour accéder à tes séances, ton planning et ton suivi personnalisé.")

@section('content')

<div class="p-4 shadow card border-primary mb-3" style="max-width: 400px; width: 100%;">
    <div class="mb-4">
        <h3 class="mt-3" style="font-family: 'Raleway'">Connexion</h3>
    </div>
    <form action="{{ route('auth.toLogin') }}" method="post">
        @csrf

        <div class="mb-3">
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
                autofocus 
                required 
                value="{{ old('email') }}"
            >
        </div>
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
                    class="form-control @error('password') is-invalid @enderror" 
                    id="password" 
                    name="password" 
                    placeholder="Entrez votre mot de passe" 
                    required
                >
                <button type="button" class="input-group-text show-pass btn btn-primary">
                    <i class="fa fa-eye-slash"></i>
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3 form-group">
            <div class="custom-control custom-switch">
                <input 
                    type="checkbox" 
                    class="custom-control-input" 
                    id="remember" 
                    name="remember"
                >
                <label class="custom-control-label" for="remember">Se souvenir de moi</label>
            </div>


        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary w-100 ">Se connecter</button>
            <a href="{{ route('auth.register') }}" class="btn btn-outline-primary w-100">Inscription</a>
        </div>
        <div class="mt-3 text-right">
            <a href="{{ route('auth.password.forget') }}" class="text-decoration-underline text-white ">Mot de passe oublié ?</a>
        </div>
    </form>
</div>

@endsection