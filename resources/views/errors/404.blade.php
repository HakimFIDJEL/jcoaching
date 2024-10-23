@extends('errors.layout')

@section('title', 'Page introuvable')



@section('content')



    <div class="form-input-content text-center error-page">
        <h1 class="error-text fw-bold">404</h1>
        <h4>
            <i class="fa fa-exclamation-triangle text-warning"></i> 
            La page que vous cherchez n'existe pas!
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
