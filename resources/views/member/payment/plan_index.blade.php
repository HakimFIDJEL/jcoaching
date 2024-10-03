@extends('member._elements.layout')

@section('title', 'Souscrire à un abonnement')

@section('styles')
<link href="{{ asset('backoffice/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" rel="stylesheet">
@endsection

@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('member.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('member.plans.index') }}">Paiement</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Abonnement</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}

{{-- Page content --}}
<div class="row">
    <div class="col-xl-12 col-xxl-12">
        <div class="card border-primary border">
            <div class="card-header border-bottom border-primary">
                <h4 class="card-title mt-1 mb-1" style="text-transform: none">  
                    Souscrire à un abonnement
                </h4>
            </div>

            
            <div class="card-body">
                <div id="smartwizard" class="form-wizard order-create">
                    <ul class="nav nav-wizard">
                        <li><a class="nav-link" href="#wizard_selection"> 
                            <span>1</span> 
                        </a></li>
                        <li><a class="nav-link" href="#wizard_nutrition">
                            <span>2</span>
                        </a></li>
                        <li><a class="nav-link" href="#wizard_payment">
                            <span>3</span>
                        </a></li>
                    </ul>

                    <div class="tab-content p-2">
                        <div id="wizard_selection" class="tab-pane" role="tabpanel">
                            <div class="row mt-4 mb-4">
                                {{-- Content --}}
                                <div class="col-4">
                                    <div class="card-title d-flex justify-content-between w-100 align-items-center">
                                        <h4 class="mb-0">
                                            Les abonnements
                                        </h4>
                                    </div>
                                    <div class="card-description">
                                        <p class="text-muted  mb-0 font-weight-light">
                                            Nous proposons plusieurs abonnements pour répondre à vos besoins, choisissez celui qui vous convient le mieux. 
                                            <br />
                                            <br />
                                            Un abonnement est valable 30 jours et vous offre un nombre plus qu'avantageux de séances tout en vous laissant la possibilité de choisir l'option de suivi nutritionnel.
                                        </p>
                                    </div>
                                </div>
                                {{-- /Content --}}

                                {{-- Cards --}}
                                <div class="col-8 d-flex gap-2 flex-wrap w-100">
                                    @foreach($pricings as $pricing)
                                            <div class=" col card pricing-selection pt-4 pb-4 pl-2 pr-2 border" data-pricing="{{ $pricing }}">
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
                                                            <i class="fa fa-check me-2"></i>
                                                            <span>
                                                                {{ $pricing->nbr_sessions }} séances
                                                            </span>
                                                        </li>
                                                        @foreach($pricing->features as $feature)
                                                            <li class="">
                                                                <i class="fa fa-check me-2"></i>
                                                                <span>
                                                                    {{ $feature->label }}
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="d-flex justify-content-between gap-2 align-items-end">
                                                        <button class="btn btn-primary select-btn">Sélectionner</button>
                                                        <div class="price text-muted font-weight-light">
                                                            <span class="price-value">{{ $pricing->price }} €</span>
                                                            <span class="price-duration">/30 jours</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                                {{-- /Cards --}}
                            </div>
                        </div>
                        <div id="wizard_nutrition" class="tab-pane" role="tabpanel" data-nutrition-price="{{ $nutrition_price }}">
                            <div class="row mt-4 mb-4">
                                {{-- Cards --}}
                                <div class="col-4 d-flex gap-2 w-100 flex-column">
                                    <div class="col card nutrition-selection pt-4 pb-4 pl-2 pr-2 border">
                                        <div class="card-header d-flex flex-column align-items-start">
                                            <h5 class="card-title">Nutrition</h5>
                                            <div class="card-description">
                                                <div class="text-muted mb-0 font-weight-light">
                                                    Je choisis de bénéficier d'un suivi nutritionnel
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between gap-2 align-items-end">
                                                <button class="btn btn-primary select-btn">Sélectionner</button>
                                                <div class="price text-muted font-weight-light">
                                                    <span class="price-value">+ {{ $nutrition_price }} €</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- /Cards --}}
                                {{-- Content --}}
                                <div class="col-8 pt-4 pb-4">
                                    <div class="card-title d-flex justify-content-between w-100 align-items-center">
                                        <h4 class="mb-0">
                                            Suivi nutritionnel
                                        </h4>
                                    </div>
                                    <div class="card-description">
                                        <p class="text-muted  mb-0 font-weight-light">
                                            La nutrition est clé pour vos résultats. En plus des séances, je vous guide sur cet aspect essentiel.
                                            <br />
                                            Si vos apports égalent vos besoins, vous ne perdrez pas de poids. Ensemble, optimisons tout pour avancer.
                                            <br />
                                            « Ne remplacez pas vos habitudes, créons-en de nouvelles. »
                                        </p>
                                    </div>
                                </div>
                                {{-- /Content --}}
                            </div>
                        </div>
                        <div id="wizard_payment" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4 order-lg-2 mb-4 border-primary border pt-4 pb-4">
                                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="text-primary text-center w-100 d-flex align-items-center gap-3">	
                                                            <i class="fa fa-shopping-cart"></i>
                                                            <span>
                                                                Votre panier
                                                            </span>
                                                        </span>
                                                    </h4>
                                                    <hr>
                                                    <ul class="list-group mb-3" id="wizard-cart-list">
                                                        <li 
                                                            class="list-group-item justify-content-between lh-condensed" 
                                                            id="cart-pricing" 
                                                            style="display: none;"
                                                        >
                                                            <div>
                                                                <h6 class="my-0 title">
                                                                    {{-- Title of pricing --}}
                                                                </h6>
                                                                <small class="text-muted subtitle">
                                                                    {{-- Subtitle of pricing --}}
                                                                </small>
                                                            </div>
                                                            <span class="text-muted price" style="white-space: nowrap;">
                                                                {{-- Price of pricing --}}
                                                            </span>
                                                        </li>
                                                        <li 
                                                            class="list-group-item justify-content-between lh-condensed"
                                                            id="cart-nutrition"
                                                            style="display: none;"
                                                        >
                                                            <div>
                                                                <h6 class="my-0 title">Option nutrition</h6>
                                                                <small class="text-muted subtitle">
                                                                    Un suivi nutritionnel personnalisé pour vous aider à atteindre vos objectifs.
                                                                </small>
                                                            </div>
                                                            <span class="text-muted price" style="white-space: nowrap;">
                                                                {{ $nutrition_price }} €
                                                            </span>
                                                        </li>
                                                        <li 
                                                            class="list-group-item justify-content-between active"
                                                            id="cart-reduction"
                                                            style="display: none;"
                                                        >
                                                            <div class="text-white">
                                                                <h6 class="my-0 text-white title" style="white-space: nowrap;">
                                                                    Code de réduction
                                                                </h6>
                                                                <small class="subtitle">
                                                                    {{-- Code de réduction --}}
                                                                </small>
                                                            </div>
                                                            <span class="text-white price">
                                                                - {{-- Réduction en euro et en pourcentage --}}
                                                            </span>
                                                        </li>
                                                        <hr>
                                                        <li 
                                                            class="list-group-item d-flex justify-content-between text-white"
                                                            id="cart-total"
                                                        >
                                                            <span>Total (EUR)</span>
                                                            <strong class="price">
                                                                {{-- Total --}}
                                                            </strong>
                                                        </li>
                                                    </ul>
            
                                                    <form action="{{ route('member.payment.reduction') }}" method="POST" id="cart-reduction-form">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                placeholder="Code de réduction"
                                                                required 
                                                                name="code"
                                                            >
                                                            <button type="submit" class="input-group-text">
                                                                <span class="cart-form-text">
                                                                    Appliquer
                                                                </span>
                                                                <span class="spinner-border spinner-border-sm cart-form-loader" style="display: none;"></span>
                                                            </button>
                                                        </div>
                                                    </form>

                                                    <a href="javascript:void(0);" id="cart-reduction-remove" class="btn btn-danger w-100" style="display: none;">
                                                        <span>
                                                            Supprimer le code de réduction
                                                        </span>
                                                        <i class="fa fa-times ms-2"></i>
                                                    </a>
                                                </div>
                                                <div class="col-lg-8 order-lg-1">
                                                    <h4 class="mb-3 d-flex align-items-center gap-3">
                                                        <i class="fa fa-user"></i>
                                                        <span>
                                                            Vos informations
                                                        </span>
                                                    </h4>
                                                    <hr class="mb-4">
                                                    <form action="{{ route('member.payment.plan.payment') }}" method="POST" id="cart-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="pricing_id" id="pricing_id" value="">
                                                        <input type="hidden" name="nutrition_option" id="nutrition_option" value="">
                                                        <input type="hidden" name="reduction_id" id="reduction_id" value="">
                                                        <input type="hidden" name="total_price" id="total_price" value="">

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="lastname" class="form-label">
                                                                    Nom
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control @error('lastname') is-invalid @enderror" 
                                                                    id="lastname" 
                                                                    name="lastname" 
                                                                    placeholder="Entrez votre nom de famille" 
                                                                    autofocus 
                                                                    required 
                                                                    value="{{ Auth::user()->lastname }}"
                                                                >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="firstname" class="form-label">
                                                                    Prénom
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control @error('firstname') is-invalid @enderror" 
                                                                    id="firstname" 
                                                                    name="firstname" 
                                                                    placeholder="Entrez votre prénom"  
                                                                    required 
                                                                    value="{{ Auth::user()->firstname }}"
                                                                >
                                                            </div>
                                                        </div>
            
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="firstname" class="form-label">
                                                                    Email
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="email" 
                                                                    class="form-control @error('email') is-invalid @enderror" 
                                                                    id="email" 
                                                                    name="email" 
                                                                    placeholder="Entrez votre adresse e-mail"  
                                                                    required 
                                                                    value="{{ Auth::user()->email }}"
                                                                >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="phone" class="form-label">
                                                                    Téléphone
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control @error('phone') is-invalid @enderror" 
                                                                    id="phone" 
                                                                    name="phone" 
                                                                    placeholder="Entrez votre numéro de téléphone"  
                                                                    required 
                                                                    value="{{ Auth::user()->phone }}"
                                                                >
                                                            </div>
                                                        </div>
            
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">
                                                                Adresse
                                                                <span class="text-muted">
                                                                    *
                                                                </span>
                                                            </label>
                                                            <input 
                                                                type="text" 
                                                                class="form-control @error('address') is-invalid @enderror" 
                                                                id="address" 
                                                                name="address" 
                                                                placeholder="Entrez votre adresse"  
                                                                required 
                                                                value="{{ Auth::user()->address }}"
                                                            >
                                                        </div>
            
                                                        <div class="row">
                                                            <div class="col-md-5 mb-3">
                                                                <label for="country" class="form-label">
                                                                    Pays
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control @error('country') is-invalid @enderror" 
                                                                    id="country" 
                                                                    name="country" 
                                                                    placeholder="Entrez votre pays"  
                                                                    required 
                                                                    value="{{ Auth::user()->country }}"
                                                                >
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="city" class="form-label">
                                                                    Ville
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control @error('city') is-invalid @enderror" 
                                                                    id="city" 
                                                                    name="city" 
                                                                    placeholder="Entrez votre ville"  
                                                                    required 
                                                                    value="{{ Auth::user()->city }}"
                                                                >
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="postal_code" class="form-label">
                                                                    Code postal
                                                                    <span class="text-muted">
                                                                        *
                                                                    </span>
                                                                </label>
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control @error('postal_code') is-invalid @enderror" 
                                                                    id="postal_code" 
                                                                    name="postal_code" 
                                                                    placeholder="Entrez votre code postal"  
                                                                    required 
                                                                    value="{{ Auth::user()->postal_code }}"
                                                                >
                                                            </div>
                                                        </div>
                                                        <hr class="mb-4">

                                                        {{-- Checkboxes --}}
                                                        <div class="mb-3">
                                                            {{-- CGV --}}
                                                            <div class="custom-control custom-checkbox">
                                                                <input 
                                                                    class="custom-control-input" 
                                                                    type="checkbox" 
                                                                    value="1" 
                                                                    id="cgv_terms" 
                                                                    name="cgv_terms"
                                                                    required
                                                                >
                                                                <label class="custom-control-label
                                                                    @error('cgv_terms') is-invalid @enderror" 
                                                                    for="cgv_terms"
                                                                >
                                                                    J'ai lu et j'accepte les 
                                                                    <a href="{{ route('main.legal.sales') }}" target="_blank" class="text-decoration-underline">
                                                                        conditions générales de ventes
                                                                    </a>
                                                                </label>
                                                            </div>

                                                            {{-- RGPD --}}
                                                            <div class="custom-control custom-checkbox">
                                                                <input 
                                                                    class="custom-control-input" 
                                                                    type="checkbox" 
                                                                    value="1" 
                                                                    id="rgpd_terms" 
                                                                    name="rgpd_terms"
                                                                    required
                                                                >
                                                                <label class="custom-control-label
                                                                    @error('rgpd_terms') is-invalid @enderror" 
                                                                    for="rgpd_terms"
                                                                >
                                                                    J'ai lu et j'accepte la 
                                                                    <a href="{{ route('main.legal.privacy') }}" target="_blank" class="text-decoration-underline">
                                                                        politique de confidentialité
                                                                    </a>
                                                                </label>
                                                            </div>
                                                        </div>
            
                                                        <button class="btn btn-primary btn-lg btn-block d-flex align-items-center justify-content-center" type="submit">
                                                            <span class="align-items-center gap-3 justify-content-center span-form-text " style="display: flex;">
                                                                <span>
                                                                    Continuer vers le paiement
                                                                </span>
                                                                <i class="fa fa-angle-right"></i>
                                                            </span>
                                                            <span class="spinner-border spinner-border-sm span-form-loader" style="display: none;"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
{{-- /Page content --}}


@endsection

@section('scripts')
    <script src="{{ asset('backoffice/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}" defer></script>
    <script src="{{ asset('backoffice/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}" defer></script>
    @vite('resources/js/plugins/smartwizard.js')
    @vite('resources/js/pages/member/plan_index.js')
@endsection