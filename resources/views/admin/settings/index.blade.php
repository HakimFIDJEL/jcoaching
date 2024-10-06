@extends('admin._elements.layout')

@section('title', 'Paramètres')


@section('content')



<h1 class="mb-4">Paramètres</h1>
<div class="row">
    <div class="col-md-3">
        <ul class="nav nav-pills flex-column" id="settingsTabs" role="tablist">
            <li class="nav-item">
                <a href="#company" data-bs-toggle="pill" class="nav-link active show">Entreprise</a>
                <a href="#socials" data-bs-toggle="pill" class="nav-link">Réseaux sociaux</a>
                <a href="#nutrition" data-bs-toggle="pill" class="nav-link">Nutrition</a>
                <a href="#pricings" data-bs-toggle="pill" class="nav-link">Prix</a>
                <a href="#colors" data-bs-toggle="pill" class="nav-link">Charte graphique</a>
                <a href="#others" data-bs-toggle="pill" class="nav-link">Autres</a>
            </li>
            {{-- <li class="nav-item">
                <a href="#v-pills-profile" data-bs-toggle="pill" class="nav-link">Profile</a>
            </li> --}}
        </ul>
    </div>
    <div class="col-md-9">
        <div class="tab-content">

            <div id="company" class="tab-pane fade active show">
                <div class="card border-primary">
                    {{-- Card Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                Informations sur l'entreprise
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Informations de base sur l'entreprise
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update-company') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- /Card Header --}}

                        {{-- Card body --}}
                        <div class="card-body mb-2 mt-2">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">
                                            Nom
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_name') is-invalid @enderror" 
                                            id="company_name" 
                                            name="company_name" 
                                            placeholder="Entrez le nom de la société"  
                                            value="{{ $setting->company_name ?? old('company_name') }}"
                                        >
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_address" class="form-label">
                                            Adresse 
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_address') is-invalid @enderror" 
                                            id="company_address" 
                                            name="company_address" 
                                            placeholder="Entrez l'adresse de la société"
                                            value="{{ $setting->company_address ?? old('company_address') }}"
                                        >
                                    </div>
                                </div>
                            </div>

                            {{-- Company Logo --}}
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_logo" class="form-label">
                                            Logo
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>
                                        <input 
                                            type="file" 
                                            class="filepond" 
                                            id="company_logo" 
                                            name="company_logo" 
                                            accept="image/*, video/*"
                                            data-max-files="1" 
                                            @if($setting->company_logo)
                                                data-documents="{{ json_encode([[
                                                    'source' => Storage::url($setting->company_logo),
                                                ]]) }}"
                                            @endif      
                                        >
                                    </div>
                                </div>
                            </div>

                            {{-- Company Icon --}}
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_icon" class="form-label">
                                            Icône
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>
                                        <input 
                                            type="file" 
                                            class="filepond" 
                                            id="company_icon" 
                                            name="company_icon" 
                                            accept="image/*, video/*"
                                            data-max-files="1" 
                                            @if($setting->company_icon)
                                                data-documents="{{ json_encode([[
                                                    'source' => Storage::url($setting->company_icon),
                                                ]]) }}"
                                            @endif      
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="company_phone" class="form-label">
                                        Téléphone
                                        <span class="text-muted fw-light">
                                            (facultatif)
                                        </span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('company_phone') is-invalid @enderror" 
                                        id="company_phone" 
                                        name="company_phone" 
                                        placeholder="Entrez le numéro de téléphone de la société" 
                                        value="{{ $setting->company_phone ?? old('company_phone') }}"
                                    >
                                </div>
                                <div class="col">
                                    <label for="company_email" class="form-label">
                                        Adresse mail
                                        <span class="text-muted fw-light">
                                            (facultatif)
                                        </span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('company_email') is-invalid @enderror" 
                                        id="company_email" 
                                        name="company_email" 
                                        placeholder="Entrez l'adresse mail de la société" 
                                        value="{{ $setting->company_email ?? old('company_email') }}"
                                    >
                                </div>  
                            </div>
                              
                            <div class="row mb-3">
                                <div class="col">
                                        {{-- Siret --}}
                                        <label for="company_siret" class="form-label">
                                            Siret
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>

                                        <input 
                                            type="text" 
                                            class="form-control @error('company_siret') is-invalid @enderror" 
                                            id="company_siret" 
                                            name="company_siret" 
                                            placeholder="Entrez le numéro de Siret de la société" 
                                            value="{{ $setting->company_siret ?? old('company_siret') }}"
                                        >
                                </div>
                                <div class="col">
                                    {{-- TVA --}}
                                    <label for="company_tva" class="form-label">
                                        TVA
                                        <span class="text-muted fw-light">
                                            (facultatif)
                                        </span>
                                    </label>

                                    <input 
                                        type="text" 
                                        class="form-control @error('company_tva') is-invalid @enderror" 
                                        id="company_tva" 
                                        name="company_tva" 
                                        placeholder="Entrez le numéro de TVA de la société" 
                                        value="{{ $setting->company_tva ?? old('company_tva') }}"
                                    >
                                </div>
                            </div>

                        </div>
                        {{-- /Card body --}}

                        {{-- Card Footer --}}
                        <div class="card-footer border-top border-primary">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>
                                    Enregistrer
                                </span>
                                <i class="fas fa-edit ms-2"></i>
                            </button>
                            <div class="d-flex justify-content-between gap-2 align-items-center w-100 align-items-center mt-2">
                                @if($setting->company_logo)
                                    <a href="{{ route('admin.settings.download-logo') }}" class="btn btn-secondary w-100">
                                        <span>
                                            Télécharger le logo
                                        </span>
                                        <i class="fas fa-download ms-2"></i>
                                    </a>
                                @endif
                                @if($setting->company_icon)
                                    <a href="{{ route('admin.settings.download-icon') }}" class="btn btn-secondary w-100">
                                        <span>
                                            Télécharger l'icône
                                        </span>
                                        <i class="fas fa-download ms-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{-- /Card Footer --}}

                    </form>
                </div>
            </div>

            <div id="socials" class="tab-pane fade">
                <div class="card border-primary">
                    {{-- Card Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                Réseaux sociaux de l'entreprise
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Informations sur les réseaux sociaux de l'entreprise
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update-socials') }}" method="POST">
                        @csrf

                        {{-- /Card Header --}}

                        {{-- Card body --}}
                        <div class="card-body mb-2 mt-2">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_facebook" class="form-label">
                                            <i class="fab fa-facebook me-2"></i>
                                            <span>
                                                Facebook
                                                <span class="text-muted fw-light">
                                                    (facultatif)
                                                </span>
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_facebook') is-invalid @enderror" 
                                            id="company_facebook" 
                                            name="company_facebook" 
                                            placeholder="Entrez le lien de la page Facebook de la société"  
                                            value="{{ $setting->company_facebook ?? old('company_facebook') }}"
                                        >
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_instagram" class="form-label">
                                            <i class="fab fa-instagram me-2"></i>
                                            <span>
                                                Instagram
                                                <span class="text-muted fw-light">
                                                    (facultatif)
                                                </span>
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_instagram') is-invalid @enderror" 
                                            id="company_instagram" 
                                            name="company_instagram" 
                                            placeholder="Entrez le lien de la page Instagram de la société"
                                            value="{{ $setting->company_instagram ?? old('company_instagram') }}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_youtube" class="form-label">
                                            <i class="fab fa-youtube me-2"></i>
                                            <span>
                                                Youtube
                                                <span class="text-muted fw-light">
                                                    (facultatif)
                                                </span>
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_youtube') is-invalid @enderror" 
                                            id="company_youtube" 
                                            name="company_youtube" 
                                            placeholder="Entrez le lien de la page Youtube de la société"
                                            value="{{ $setting->company_youtube ?? old('company_youtube') }}"
                                        >
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_linkedin" class="form-label">
                                            <i class="fab fa-linkedin me-2"></i>
                                            <span>
                                                LinkedIn
                                                <span class="text-muted fw-light">
                                                    (facultatif)
                                                </span>
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_linkedin') is-invalid @enderror" 
                                            id="company_linkedin" 
                                            name="company_linkedin" 
                                            placeholder="Entrez le lien de la page LinkedIn de la société"
                                            value="{{ $setting->company_linkedin ?? old('company_linkedin') }}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_twitter" class="form-label">
                                            <i class="fab fa-twitter me-2"></i>
                                            <span>
                                                Twitter
                                                <span class="text-muted fw-light">
                                                    (facultatif)
                                                </span>
                                            </span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('company_twitter') is-invalid @enderror" 
                                            id="company_twitter" 
                                            name="company_twitter" 
                                            placeholder="Entrez le lien de la page Twitter de la société"
                                            value="{{ $setting->company_twitter ?? old('company_twitter') }}"
                                        >
                                    </div>
                                </div>
                            </div>


                        </div>
                        {{-- /Card body --}}

                        {{-- Card Footer --}}
                        <div class="card-footer border-top border-primary">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>
                                    Enregistrer
                                </span>
                                <i class="fas fa-edit ms-2"></i>
                            </button>
                        </div>
                        {{-- /Card Footer --}}

                    </form>
                </div>
            </div>

            <div id="nutrition" class="tab-pane fade">
                <div class="card border-primary">
                    {{-- Card Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                Idée nutrition
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                L'idée de repas de la semaine !
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update-nutrition') }}" method="POST">
                        @csrf

                        {{-- /Card Header --}}

                        {{-- Card body --}}
                        <div class="card-body mb-2 mt-2">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nutrition_title" class="form-label">
                                            Idée nutrition
                                            <span class="text-muted">
                                                *
                                            </span>
                                        </label>
                                        <textarea 
                                            class="form-control editor @error('nutrition_idea') is-invalid @enderror" 
                                            name="nutrition_idea" 
                                            id="nutrition_idea" 
                                            rows="2" 
                                            style="resize: none;" 
                                            placeholder="Entrez l'idée nutrition de la semaine"
                                        >{{ $setting->nutrition_idea ?? old('nutrition_idea') }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- /Card body --}}

                        {{-- Card Footer --}}
                        <div class="card-footer border-top border-primary">
                            <div class="d-flex justify-content-between gap-2 align-items-center w-100">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span>
                                        Enregistrer
                                    </span>
                                    <i class="fas fa-edit ms-2"></i>
                                </button>
                                <a href="{{ route('admin.settings.notify') }}" class="btn btn-secondary w-100">
                                    <span>
                                        Notifier les abonnés
                                    </span>
                                    <i class="fas fa-bell ms-2"></i>
                                </a>
                            </div>
                        </div>
                        {{-- /Card Footer --}}

                    </form>
                </div>
            </div>

            <div id="pricings" class="tab-pane fade">
                <div class="card border-primary">
                    {{-- Card Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                Les prix
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Les prix des séances uniques et de l'option de nutrition
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update-pricings') }}" method="POST">
                        @csrf

                        {{-- /Card Header --}}

                        {{-- Card body --}}
                        <div class="card-body mb-2 mt-2">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nutrition_title" class="form-label">
                                            Option nutrition
                                            <span class="text-muted">
                                                *    
                                            </span>
                                        </label>
                                        <div class="input-group">
                                            <input 
                                                type="number" 
                                                step="0.01"
                                                class="form-control @error('nutrition_price') is-invalid @enderror" 
                                                id="nutrition_price" 
                                                name="nutrition_price" 
                                                placeholder="Entrez le prix de l'option nutrition"
                                                required
                                                value="{{ $setting->nutrition_price ?? old('nutrition_price') }}"
                                            >
                                            <span class="input-group-text">
                                                € / 30 jours
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nutrition_title" class="form-label">
                                            Séance
                                            <span class="text-muted">
                                                *    
                                            </span>
                                        </label>
                                        <div class="input-group">
                                            <input 
                                                type="number" 
                                                step="0.01"
                                                class="form-control @error('workout_price') is-invalid @enderror" 
                                                id="workout_price" 
                                                name="workout_price" 
                                                placeholder="Entrez le prix d'une séance"
                                                required
                                                value="{{ $setting->workout_price ?? old('workout_price') }}"
                                            >
                                            <span class="input-group-text">
                                                € / unité
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- /Card body --}}

                        {{-- Card Footer --}}
                        <div class="card-footer border-top border-primary">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>
                                    Enregistrer
                                </span>
                                <i class="fas fa-edit ms-2"></i>
                            </button>
                        </div>
                        {{-- /Card Footer --}}

                    </form>
                </div>
            </div>

            <div id="colors" class="tab-pane fade">
                <div class="card border-primary">
                    {{-- Card Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                La charte graphique
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Les couleurs de la charte graphique
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update-colors') }}" method="POST">
                        @csrf

                        {{-- /Card Header --}}

                        {{-- Card body --}}
                        <div class="card-body mb-2 mt-2">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="primary_color" class="form-label">
                                            Couleur principale
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>

                                        <input 
                                            type="color" 
                                            class="form-control @error('primary_color') is-invalid @enderror" 
                                            id="primary_color" 
                                            name="primary_color" 
                                            value="{{ $setting->primary_color ?? old('primary_color') }}"
                                        >
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="secondary_color" class="form-label">
                                            Couleur secondaire
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>

                                        <input 
                                            type="color" 
                                            class="form-control @error('secondary_color') is-invalid @enderror" 
                                            id="secondary_color" 
                                            name="secondary_color" 
                                            value="{{ $setting->secondary_color ?? old('secondary_color') }}"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="background-color" class="form-label">
                                            Couleur de fond
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>

                                        <input 
                                            type="color" 
                                            class="form-control @error('background_color') is-invalid @enderror" 
                                            id="background_color" 
                                            name="background_color" 
                                            value="{{ $setting->background_color ?? old('background_color') }}"
                                        >
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="font_color" class="form-label">
                                            Couleur du texte
                                            <span class="text-muted fw-light">
                                                (facultatif)
                                            </span>
                                        </label>

                                        <input 
                                            type="color" 
                                            class="form-control @error('font_color') is-invalid @enderror" 
                                            id="font_color" 
                                            name="font_color" 
                                            value="{{ $setting->font_color ?? old('font_color') }}"
                                        >
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- /Card body --}}

                        {{-- Card Footer --}}
                        <div class="card-footer border-top border-primary">
                            <div class="d-flex justify-content-between gap-2 align-items-center w-100 align-items-center">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span>
                                        Enregistrer
                                    </span>
                                    <i class="fas fa-edit ms-2"></i>
                                </button>
                                <a href="{{ route('admin.settings.colors-reset') }}" class="btn btn-secondary w-100 warning-row">
                                    <span>
                                        Réinitialiser par défaut
                                    </span>
                                    <i class="fas fa-undo ms-2"></i>
                                </a>
                            </div>
                        </div>

                        
                        {{-- /Card Footer --}}

                    </form>
                </div>
            </div>

            <div id="others" class="tab-pane fade">
                <div class="card border-primary">
                    {{-- Card Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                Autres informations
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Autres informations sur l'entreprise ou le site
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update-others') }}" method="POST">
                        @csrf

                        {{-- /Card Header --}}

                        {{-- Card body --}}
                        <div class="card-body mb-2 mt-2">

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="meta_title" class="form-label">
                                        Méta titre
                                        <span class="text-muted">
                                            *
                                        </span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('meta_title') is-invalid @enderror" 
                                        id="meta_title" 
                                        name="meta_title" 
                                        placeholder="Entrez le méta titre du site"
                                        required
                                        value="{{ $setting->meta_title ?? old('meta_title') }}"
                                    >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="meta_title" class="form-label">
                                        Méta description
                                        <span class="text-muted">
                                            *    
                                        </span>
                                    </label>
                                    <textarea 
                                        class="form-control @error('meta_description') is-invalid @enderror" 
                                        name="meta_description" 
                                        id="meta_description" 
                                        rows="2" 
                                        style="resize: none;" 
                                        placeholder="Entrez la méta description du site"
                                        required
                                    >{{ $setting->meta_description ?? old('meta_description') }}</textarea>
                                </div>
                            </div>

                        </div>
                        {{-- /Card body --}}

                        {{-- Card Footer --}}
                        <div class="card-footer border-top border-primary">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>
                                    Enregistrer
                                </span>
                                <i class="fas fa-edit ms-2"></i>
                            </button>
                        </div>
                        {{-- /Card Footer --}}

                    </form>
                </div>
            </div>


            
        </div>
    </div>
</div>
  

@endsection



@section('scripts')
    @vite('resources/js/plugins/filepond.js')
    @vite('resources/js/plugins/ckeditor.js')
@endsection