@extends('errors.layout')

@section('title', 'Aie ! Votre paiement a été annulé')



@section('content')


    <div class="form-input-content text-center error-page">
        <h1 class="fw-light error-text" style="white-space: nowrap">
            Aie !
            <i class="fa fa-times-circle text-danger"></i>
        </h1>
        <p class="fw-light">
            Votre paiement a bien été annulé, une autre fois peut-être ? Vous pouvez revenir à l'accueil en cliquant sur le bouton ci-dessous.
        </p>
        <div>
            <a class="btn btn-primary" href="{{ route('main.account') }}">
                Retour à l'accueil
            </a>
        </div>
    </div>

@endsection
