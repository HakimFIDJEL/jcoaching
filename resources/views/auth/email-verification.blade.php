@extends('auth._elements.layout')

@section('title', 'Vérification de l\'adresse e-mail')

@section('content')

<div class="p-4 shadow card border-primary mb-3" style="max-width: 400px; width: 100%;">
    <div class="mb-4">
        <h3 class="mt-3" style="font-family: 'Raleway'">Vérification de l'adresse e-mail</h3>
        <div class="text-muted" style="font-size: 0.9rem;">
            Un code de vérification a été envoyé à l'adresse e-mail renseignée, ce code est valable 24 heures.
        </div>
    </div>
    <form action="{{ route('auth.email-verification') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="email_token" class="form-label">Code de vérification</label>
            <input 
                type="text" 
                class="form-control @error('email_token') is-invalid @enderror" 
                id="email_token" 
                name="email_token" 
                placeholder="Entrez le code de vérification" 
                autofocus 
                required 
                value="{{ old('email_token') }}"
            >
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary w-100 mb-2">Vérifier l'adresse e-mail</button>
            <a href="{{ route('auth.logout') }}" class="btn btn-outline-primary w-100">Déconnexion</a>
        </div>
        <div class="mt-3 text-right">
            <a href="{{ route('auth.email-verification.resend') }}" class="btn btn-link">Renvoyer le code de vérification</a>
        </div>
    </form>
</div>

@endsection