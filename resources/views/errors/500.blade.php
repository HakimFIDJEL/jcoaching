@extends('errors.layout')

@section('title', 'Erreur serveur')



@section('content')



    <div class="form-input-content text-center error-page">
        <h1 class="error-text fw-bold">500</h1>
        <h4>
            <i class="fa fa-exclamation-triangle text-warning"></i> 
            Une erreur est survenue sur le serveur!
        </h4>
        <p>
            Nous vous prions de nous excuser pour la gêne occasionnée, veuillez réessayer ultérieurement.
        </p>
        <div>
            <a class="btn btn-primary" href="{{ route('main.account') }}">
                Retour à l'accueil
            </a>
        </div>
    </div>

@endsection
