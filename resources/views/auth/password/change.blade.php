@extends('auth._elements.layout')

@section('title', 'Modifier votre mot de passe')

@section('content')

<div class="p-4 shadow card border-primary mb-3" style="max-width: 400px; width: 100%;">
    <div class="mb-4">
        <h3 class="mt-3" style="font-family: 'Raleway'">Mise à jour sécurité</h3>
        <div class="text-muted" style="font-size: 0.9rem;">
            Pour des raisons de sécurité, vous devez modifier votre mot de passe, cette opération est obligatoire mais n'arrive qu'une fois par an.
        </div>
    </div>
    <form action="{{ route('auth.password.toChange') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">
                Nouveau mot de passe
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
                    placeholder="Entrez votre nouveau mot de passe"
                    autofocus 
                    required 
                >
                <button type="button" class="input-group-text show-pass btn btn-primary">
                    <i class="fa fa-eye-slash"></i>
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                Confirmez votre mot de passe
                <span class="text-muted">
                    *
                </span>
            </label>
            <input 
                type="password" 
                class="form-control @error('password_confirmation') is-invalid @enderror" 
                id="password_confirmation" 
                name="password_confirmation" 
                placeholder="Confirmez votre mot de passe" 
                required 
            >
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary w-100 mb-2">Modifier</button>
        </div>
    </form>
</div>

@endsection