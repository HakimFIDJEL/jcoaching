@extends('jerhome._elements.layout')

@section('title', 'Politique de cookies')

@section('content')

    <div class="container my-5">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                Politique de cookies
            </h1>
            <hr>
        </div>
    </div>

    <section class="my-5 pb-5">

        Chez {{ $company_name }}, on utilise des cookies pour améliorer ton expérience. Cette politique t'explique comment et
        pourquoi on les utilise.

        <br><br>

        <h5 class="my-4 text-primary fw-bold">
            1. Qu'est-ce qu'un cookie ?
        </h5>
        <hr>

        Un cookie est un petit fichier texte stocké sur ton appareil (ordi, smartphone, etc.) quand tu visites un site web.
        Il permet de retenir des infos sur ta navigation.

        <h5 class="my-4 text-primary fw-bold">
            2. Les cookies qu'on utilise
        </h5>
        <hr>

        On n'utilise qu'un seul cookie :

        Cookie de connexion "remember me" : C'est un cookie facultatif qui te permet de rester connecté(e) même après avoir
        fermé ton navigateur. Il est créé uniquement si tu coches l'option "Se souvenir de moi" lors de la connexion.

        <h5 class="my-4 text-primary fw-bold">
            3. Pourquoi on l'utilise
        </h5>
        <hr>

        Le cookie "remember me" sert à :

        Te garder connecté(e) sans avoir à te reconnecter à chaque fois.
        Améliorer ton confort de navigation sur le site.

        <h5 class="my-4 text-primary fw-bold">
            4. Ton consentement
        </h5>
        <hr>

        En cochant l'option "Se souvenir de moi" lors de la connexion, tu acceptes l'utilisation de ce cookie.

        <h5 class="my-4 text-primary fw-bold">
            5. Gestion des cookies
        </h5>
        <hr>

        Tu peux gérer ou supprimer les cookies comme tu veux :

        Depuis ton navigateur : La plupart des navigateurs te permettent de contrôler les cookies via les paramètres. Tu
        peux les supprimer ou les bloquer.
        Attention : Si tu désactives le cookie "remember me", tu devras te reconnecter à chaque visite.

        <h5 class="my-4 text-primary fw-bold">
            6. Tes droits
        </h5>
        <hr>

        Conformément à notre <a href="{{ route('main.legal.privacy') }}" class="text-decoration-underline">Politique de Confidentialité</a>, tu disposes de droits sur tes données
        personnelles.

        <h5 class="my-4 text-primary fw-bold">
            7. Mises à jour
        </h5>
        <hr>

        On peut être amenés à modifier cette politique de cookies. On te conseille de la consulter régulièrement.

        <h5 class="my-4 text-primary fw-bold">
            8. Contact
        </h5>
        <hr>

        Si t'as des questions sur notre utilisation des cookies, n'hésite pas à nous contacter via le <a href="{{ route('main.contact') }}" class="text-decoration-underline">formulaire de contact</a> du site.


    </section>



@endsection
