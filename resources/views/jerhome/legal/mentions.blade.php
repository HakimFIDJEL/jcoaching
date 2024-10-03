@extends('jerhome._elements.layout')

@section('title', 'Mentions légales')

@section('content')

    <div class="container my-5">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                Mentions légales
            </h1>
            <hr>
        </div>
    </div>

    <section class="my-5 pb-5">

        <h5 class="my-4 text-primary fw-bold">
            1. Éditeur du Site
        </h5>
        <hr>

        Nom de l'entreprise : {{ $company_name }}
        <br>
        Adresse : {{ $company_address }}
        <br>
        Téléphone : {{ $company_phone }}
        <br>
        Email : {{ $company_email }}
        <br>
        Statut juridique : Micro-entrepreneur / Auto-entrepreneur
        <br>
        Numéro SIRET : {{ $company_siret }}
        <br>
        Numéro de TVA intracommunautaire : {{ $company_tva }}
        <br>

        <h5 class="my-4 text-primary fw-bold">
            2. Directeur de la Publication
        </h5>
        <hr>

        Nom : {{ $company_name }}

        <h5 class="my-4 text-primary fw-bold">
            3. Hébergeur du Site
        </h5>
        <hr>

        Nom de l'hébergeur : Hostinger
        <br>
        Adresse : Hostinger International Ltd., 61 Lordou Vironos Street, 6023 Larnaca, Chypre
        <br>
        Téléphone : +357 24030121
        <br>
        Site Web : www.hostinger.fr
        <br>

        <h5 class="my-4 text-primary fw-bold">
            4. Conditions d'utilisation du site
        </h5>
        <hr>

        L'utilisation du site {{ $company_name }} implique l'acceptation pleine et entière des conditions générales
        d'utilisation décrites dans les <a href="{{ route('main.legal.terms') }}" class="text-decoration-underline">CGU</a>. Ces conditions sont susceptibles d'être modifiées ou complétées à tout moment.

        <h5 class="my-4 text-primary fw-bold">
            5. Propriété intellectuelle
        </h5>
        <hr>

        Tous les éléments accessibles sur le site, notamment les textes, images, logos, icônes, sons, logiciels, sont
        protégés par les lois en vigueur sur la propriété intellectuelle.

        <h5 class="my-4 text-primary fw-bold">
            6. Limitations de responsabilité
        </h5>
        <hr>

        L'éditeur du site ne pourra être tenu responsable des dommages directs et indirects causés au matériel de
        l'utilisateur lors de l'accès au site.

        <h5 class="my-4 text-primary fw-bold">
            7. Données personnelles
        </h5>
        <hr>

        Pour plus d'informations sur la gestion de vos données personnelles, consultez notre <a href="{{ route('main.legal.privacy') }}" class="text-decoration-underline"> Politique de Confidentialité</a>.

        <h5 class="my-4 text-primary fw-bold">
            8. Liens hypertextes
        </h5>
        <hr>

        Le site peut contenir des liens vers d'autres sites. Cependant, nous n'assumons aucune responsabilité quant au
        contenu de ces sites externes.

        <h5 class="my-4 text-primary fw-bold">
            9. Droit applicable
        </h5>
        <hr>

        Tout litige en relation avec l'utilisation du site est soumis au droit français. Il est fait attribution exclusive
        de juridiction aux tribunaux compétents.

    </section>



@endsection
