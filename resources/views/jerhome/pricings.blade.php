@extends('jerhome._elements.layout')

@section('title', 'Tarifs')


@section('meta_title', "Tarifs & Offres - JerHomeCoaching")
@section('meta_description', "Des séances adaptées à ton budget ! Séances à l'unité ou abonnements avantageux. Première séance offerte. Option suivi nutritionnel dispo. Check nos tarifs !")

@section('content')

    <!-- Tarifs -->
    <div class="container my-5">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                Tarifs
            </h1>
            <p class="fw-light mb-0 text-center">
                Prêt à vous lancer ? Découvrez les services et tarifs proposés.
            </p>
            <hr>
        </div>

        <div class="alert alert-success text-center" role="alert">
            <strong>Bonne nouvelle !</strong> Votre première séance est <strong>gratuite</strong> lors de votre inscription.
        </div>
    </div>

    <div class="container my-5 ">
        <h5 class="text-primary fw-bold">
            Tarifs
        </h5>
        <hr>

        <div class="pt-4">
            <div class="row g-5">
                @foreach ($pricings as $pricing)
                    <div class="col-md">
                        <div class="card border border-primary pt-4 pb-4 pl-2 pr-2">
                            <div class="card-header d-flex flex-column align-items-start">
                                <h5 class="card-title">{{ $pricing->title }}</h5>
                                <div class="card-description">
                                    <div class="text-muted mb-0 font-weight-light">
                                        {{ $pricing->subtitle }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-0">
                                <ul class="list-unstyled d-flex flex-column gap-2">
                                    <li class="">
                                        <i class="fa fa-check me-2 text-primary"></i>
                                        <span>
                                            {{ $pricing->nbr_sessions }} séances
                                        </span>
                                    </li>
                                    @foreach ($pricing->features as $feature)
                                        <li class="">
                                            <i class="fa fa-check me-2 text-primary"></i>
                                            <span>
                                                {{ $feature->label }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between gap-2 align-items-start align-items-lg-end flex-column flex-lg-row">
                                    <button class="btn btn-primary select-btn read-description" data-description="{!! $pricing->description !!}">En savoir plus</button>
                                    <div class="price text-muted font-weight-light">
                                        <span class="price-value">{{ $pricing->price }} €</span>
                                        <span class="price-duration">/30 jours</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="container my-5 pb-5">

        <!-- Option Suivi Nutritionnel -->
        <div class="mt-5 pb-4">
            <h5 class="text-primary fw-bold">
                Option Suivi Nutritionnel
            </h5>
            <hr>
            <p class="mt-4">
                Pour optimiser tes résultats, ajoute l'option de suivi nutritionnel pour seulement {{ $nutrition_price }}
                &euro; sur ton abonnement. Vous bénéficierez d'idées de repas chaque semaine et d'un suivi nutritionnel global.
            </p>
        </div>

        <!-- Infos supplémentaires -->
        <div class="mt-5 pb-4">
            <h5 class="text-primary fw-bold">
                Pourquoi choisir un abonnement ?
            </h5>
            <hr>
            <p class="mt-4">
                L'abonnement t'offre un tarif plus avantageux pour un nombre de séances défini et te permet de bénéficier de
                l'option nutritionnelle. Améliorez votre condition physique en combinant entraînement et nutrition adaptée.
            </p>
            <p class="mt-4 text-primary">
                Vous pouvez aussi acheter des séances à l'unité depuis ton espace membre si vous préfèrez plus de flexibilité pour seulement {{ $workout_price }} &euro; la séance.
            </p>
        </div>

        {{-- Déductible à 50% des impôts grâce à la certification "Service à la personne" --}}
        <div class="mt-5 pb-4">
            <h5 class="text-primary fw-bold">
                Déductible à 50% des impôts
            </h5>
            <hr>
            <p class="mt-4">
                Grâce à la certification "Service à la personne", vous pouvez déduire 50% des frais d'abonnement de tes impôts. Pour plus d'informations, n'hésitez pas à me contacter.
            </p>
        </div>


    </div>

@endsection

@section('scripts')
    <!-- jQuery et Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
