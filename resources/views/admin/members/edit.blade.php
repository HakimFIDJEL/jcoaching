@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
<div class="page-header mb-3">
    <div class="d-flex align-items-center gap-1">
        @if($member->pfp_path)
            <a class="avatar avatar-sm me-3" style = "width: 3rem; height: 3rem;" href="{{ $member->getProfilePicture() }}" target= "_blank">
                <img src="{{ $member->getProfilePicture() }}" class="rounded-circle" style="width: 100%; height: 100%;">
            </a>
        @endif
        <h1 class="h3 mb-0" style="text-transform: none;">
            Modifier {{ $member->firstname }} {{ $member->lastname }}
        </h1>
        <div class="badges ms-2 d-flex align-items-center gap-2 flex-wrap">
            @if($member->email_verified_at)
                <span class="badge bg-success me-2 p-1">
                    <span class="">Adresse e-mail vérifiée</span>
                    <i class="fas fa-check"></i>
                </span>
            @else 
                <span class="badge bg-danger me-2 p-1">
                    <span class="">Adresse e-mail non vérifiée</span>
                    <i class="fas fa-times"></i>
                </span>
            @endif
            @if($member->hasCurrentPlan())
                <span class="badge bg-success me-2 p-1">
                    <span class="">Abonnement actif</span>
                    <i class="fas fa-check"></i>
                </span>
            @endif
            <span class="badge bg-secondary me-2 p-1">
                <span class="">Membre depuis le {{ $member->created_at->format('d/m/Y') }}</span>
                <i class="fas fa-calendar-alt"></i>
            </span>
        </div>
    </div>
</div>
{{-- /Page Header --}}

{{-- Breadcrumbs --}}
    
<div class="d-flex align-items-center mb-4 gap-5 justify-content-between">
    <div class="col d-flex align-items-center gap-3 p-0 flex-wrap">

        <a href="{{ route('admin.members.edit', ['user' => $member]) }}" class="btn btn-primary d-flex align-items-center">
            <span>
                Informations
            </span>
            <i class="fas fa-user-edit ms-2"></i>
        </a>
        <a href="{{ route('admin.members.pfp', ['user' => $member]) }}" class="btn btn-outline-primary d-flex align-items-center">
            <span>
                Photo de profil
            </span>
            <i class="fas fa-portrait ms-2"></i>
        </a>
        <a href="{{ route('admin.members.documents', ['user' => $member]) }}" class="btn btn-outline-primary d-flex align-items-center">
            <span>
                Documents
            </span>
            <i class="fas fa-file-alt ms-2"></i>
        </a>
        <a href="{{ route('admin.members.workouts', ['user' => $member]) }}" class="btn btn-outline-primary d-flex align-items-center">
            <span>
                Séances et abonnements
            </span>
            <i class="fas fa-dumbbell ms-2"></i>
        </a>
        <a href="{{ route('admin.members.calendar', ['user' => $member]) }}" class="btn btn-outline-primary d-flex align-items-center">
            <span>
                Calendrier
            </span>
            <i class="fas fa-calendar-alt ms-2"></i>
        </a>
    </div>
    <div class="col-2 d-flex justify-content-end p-0">
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary ">
            <i class="fa fa-arrow-left me-2"></i>
            <span>
                Retour
            </span>
        </a>
    </div>

</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">


    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">

      

        <form action="{{ route('admin.members.update', ['user' => $member]) }}" method="post">
            @csrf
    
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Prénom</label>
                        <input 
                            type="text" 
                            class="form-control @error('firstname') is-invalid @enderror" 
                            id="firstname" 
                            name="firstname" 
                            placeholder="Entrez le prénom" 
                            autofocus 
                            required 
                            value="{{ $member->firstname }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nom</label>
                        <input 
                            type="text" 
                            class="form-control @error('lastname') is-invalid @enderror" 
                            id="lastname" 
                            name="lastname" 
                            placeholder="Entrez le nom"
                            required 
                            value="{{ $member->lastname }}"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input 
                            type="text" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            id="phone" 
                            name="phone" 
                            placeholder="Entrez le numéro de téléphone" 
                            required 
                            value="{{ $member->phone }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        placeholder="Entrez l'e-mail" 
                        required 
                        value="{{ $member->email }}"
                    >
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3 form-group position-relative">
                        <label for="address" class="form-label">Adresse</label>
                        <input 
                            type="text" 
                            class="form-control @error('address') is-invalid @enderror" 
                            id="address" 
                            name="address" 
                            placeholder="Entrez l'adresse" 
                            required 
                            value="{{ $member->address }}"
                        >
                        {{-- <div class="dropdown-menu w-100" id="search-results">
                            <li class="dropdown-item loading">Chargement...</li>
                        </div> --}}
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="city" class="form-label">Ville</label>
                        <input 
                            type="text" 
                            class="form-control @error('city') is-invalid @enderror" 
                            id="city" 
                            name="city" 
                            placeholder="Entrez la ville" 
                            required 
                            value="{{ $member->city }}"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Code postal</label>
                        <input 
                            type="text" 
                            class="form-control @error('postal_code') is-invalid @enderror" 
                            id="postal_code" 
                            name="postal_code" 
                            placeholder="Entrez le code postal" 
                            required 
                            value="{{ $member->postal_code }}"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="country" class="form-label">Pays</label>
                        <input 
                            type="text" 
                            class="form-control @error('pays') is-invalid @enderror" 
                            id="country" 
                            name="country" 
                            placeholder="Entrez le pays" 
                            required 
                            value="{{ $member->country }}"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="address_complement" class="form-label">Complément d'adresse (facultatif)</label>
                        <textarea 
                            class="form-control @error('address_complement') is-invalid @enderror" 
                            name="address_complement" 
                            id="address_complement" 
                            rows="2" 
                            style="resize: none;" 
                            placeholder="Entrez ou non un complément d'adresse"
                        >{{ $member->address_complement }}</textarea>
                    </div>
                </div> 
                <div class="col d-flex align-items-center">
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="email_verified" value="0">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="email_verified" 
                            name="email_verified"
                            value="1"
                            checked={{ $member->email_verified_at ? 'checked' : '' }}
                        >
                        <label class="custom-control-label" for="email_verified">Vérifier l'adresse e-mail ?</label>
                        <div class="text-muted font-weight-light">
                            En cochant cette case, le membre n'aura pas à vérifier son adresse e-mail.
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Modifier les informations
                    </span>
                    <i class="fas fa-user-edit ms-2"></i>
                </button>
            </div>
        </form>


            

    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}


@endsection

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

