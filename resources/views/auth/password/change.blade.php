@extends('auth._elements.layout')

@section('title', 'Modifier votre mot de passe')

@section('content')

<div class="p-4 shadow card border-primary mb-3" style="max-width: 400px; width: 100%;">
    <div class="mb-4">
        <h3 class="mt-3" style="font-family: 'Raleway'">Mise à jour sécurité</h3>
        <div class="text-muted" style="font-size: 0.9rem;">
            Cela fait plus d'1 an que vous avez un compte et pour cela merci ! Mais pour des raisons de sécurité, vous devez modifier votre mot de passe.
        </div>
    </div>
    <form action="{{ route('auth.password.toChange') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                id="password" 
                name="password" 
                placeholder="Entrez votre nouveau mot de passe"
                autofocus 
                required 
            >
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmez votre mot de passe</label>
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