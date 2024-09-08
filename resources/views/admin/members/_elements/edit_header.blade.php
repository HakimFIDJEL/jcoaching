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
            href="{{ route('admin.members.edit', ['user' => $member]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.members.edit') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Informations
            </span>
            <i class="fas fa-user-edit ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.members.pfp', ['user' => $member]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.members.pfp') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Photo de profil
            </span>
            <i class="fas fa-portrait ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.members.documents', ['user' => $member]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.members.documents') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Documents
            </span>
            <i class="fas fa-file-alt ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.members.plans.index', ['user' => $member]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.members.plans.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Abonnements
            </span>
            <i class="fas fa-dumbbell ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.members.calendar', ['user' => $member]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.members.calendar' || Route::currentRouteName() == 'admin.members.calendar.notify') btn-primary @else btn-outline-primary @endif"
        >
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