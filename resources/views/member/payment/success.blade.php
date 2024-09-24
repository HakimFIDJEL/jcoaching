@extends('errors.layout')

@section('title', 'Merci ! Votre paiement a bien été effectué')



@section('content')


    <div class="form-input-content text-center error-page">
        <h1 class="fw-light error-text" style="white-space: nowrap">
            Merci !
            <i class="fa fa-check-circle text-success"></i>
        </h1>
        <p class="fw-light">
            Votre paiement a bien été effectué, merci d'avoir fait confiance à nos services, vous pouvez maintenant accéder à votre espace membre.
        </p>
        <div>
            <a class="btn btn-primary" href="{{ route('main.account') }}">
                Retour à l'accueil
            </a>
        </div>
    </div>

@endsection
