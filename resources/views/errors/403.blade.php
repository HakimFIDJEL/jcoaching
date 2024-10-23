@extends('errors.layout')

@section('title', 'Non autorisé')



@section('content')



    <div class="form-input-content text-center error-page">
        <h1 class="error-text fw-bold">403</h1>
        <h4>
            <i class="fa fa-exclamation-triangle text-warning"></i> 
            Vous n'êtes pas autorisé à accéder à cette page!
        </h4>
        <p>
            Vous avez peut-être mal tapé l'adresse ou la page a peut-être été déplacée.
        </p>
        <div>
            <a class="btn btn-primary" href="{{ route('main.account') }}">
                Retour à l'accueil
            </a>
        </div>
    </div>

@endsection
