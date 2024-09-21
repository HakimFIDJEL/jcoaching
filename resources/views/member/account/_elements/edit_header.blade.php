{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('member.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Mon profil</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}

{{-- Page Header --}}
<div class="page-header mb-3">
    <div class="d-flex align-items-center gap-1">
        @if($member->pfp_path)
            <a class="avatar avatar-sm me-3" style = "width: 3rem; height: 3rem;" href="{{ $member->getProfilePicture() }}" target= "_blank">
                <img src="{{ $member->getProfilePicture() }}" class="rounded-circle" style="width: 100%; height: 100%;">
            </a>
        @endif
        <h1 class="h3 mb-0" style="text-transform: none;">
            Bonjour {{ $member->firstname }} {{ $member->lastname }}
        </h1>
        <div class="badges ms-2 d-flex align-items-center gap-2 flex-wrap">
            @if($member->email_verified_at)
                <span class="badge bg-success me-2 p-1">
                    <span class="">Adresse e-mail vérifiée</span>
                    <i class="fas fa-check ms-1"></i>
                </span>
            @else 
                <span class="badge bg-danger me-2 p-1">
                    <span class="">Adresse e-mail non vérifiée</span>
                    <i class="fas fa-times ms-1"></i>
                </span>
            @endif
            @if($member->first_session)
                <span class="badge bg-success me-2 p-1">
                    <span class="">Première séance offerte</span>
                    <i class="fas fa-check ms-1"></i>
                </span>
            @endif
            @if($member->hasCurrentPlan())
                <span class="badge bg-success me-2 p-1">
                    <span class="">Abonnement actif</span>
                    <i class="fas fa-check ms-1"></i>
                </span>
            @endif
            <span class="badge bg-secondary me-2 p-1">
                <span class="">Membre depuis le {{ $member->created_at->format('d/m/Y') }}</span>
                <i class="fas fa-calendar-alt ms-1"></i>
            </span>
        </div>
    </div>
</div>
{{-- /Page Header --}}

{{-- Breadcrumbs --}}
    
<div class="d-flex align-items-center mb-5 gap-5 justify-content-between">
    <div class="col d-flex align-items-center gap-3 p-0 flex-wrap">

        <a 
            href="{{ route('member.account.index') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'member.account.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Informations
            </span>
            <i class="fas fa-user-edit ms-2"></i>
        </a>
        <a 
            href="{{ route('member.account.pfp') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'member.account.pfp') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Photo de profil
            </span>
            <i class="fas fa-portrait ms-2"></i>
        </a>
        <a 
            href="{{ route('member.account.security') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'member.account.security') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Sécurité
            </span>
            <i class="fas fa-key ms-2"></i>
        </a>
    </div>
    <div class="col-2 d-flex justify-content-end p-0">
        <a href="{{ route('member.index') }}" class="btn btn-secondary ">
            <i class="fa fa-arrow-left me-2"></i>
            <span>
                Retour
            </span>
        </a>
    </div>

</div>
{{-- /Breadcrumbs --}}