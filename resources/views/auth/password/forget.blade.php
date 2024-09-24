@extends('auth._elements.layout')

@section('title', 'Mot de passe oublié')

@section('content')

<div class="p-4 shadow card border-primary mb-3" style="max-width: 400px; width: 100%;">
    <div class="mb-4">
        <h3 class="mt-3" style="font-family: 'Raleway'">Mot de passe oublié</h3>
    </div>
    <form action="{{ route('auth.password.toForget') }}" method="post">
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
                placeholder="Entrez l'adresse e-mail de votre compte" 
                autofocus 
                required 
                value="{{ old('email') }}"
            >
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary w-100">Valider</button>
            <a href="{{ route('auth.login') }}" class="btn btn-outline-primary w-100">Connexion</a>
        </div>
    </form>
</div>

@endsection