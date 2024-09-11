{{-- Page Header --}}
<div class="page-header mb-3">
    <div class="d-flex align-items-center gap-1">
        @if($admin->pfp_path)
            <a class="avatar avatar-sm me-3" style = "width: 3rem; height: 3rem;" href="{{ $admin->getProfilePicture() }}" target= "_blank">
                <img src="{{ $admin->getProfilePicture() }}" class="rounded-circle" style="width: 100%; height: 100%;">
            </a>
        @endif
        <h1 class="h3 mb-0" style="text-transform: none;">
            Bonjour {{ $admin->firstname }} {{ $admin->lastname }}
        </h1>
        <div class="badges ms-2 d-flex align-items-center gap-2 flex-wrap">
            <span class="badge bg-secondary me-2 p-1">
                <span class="">Membre depuis le {{ $admin->created_at->format('d/m/Y') }}</span>
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
            href="{{ route('admin.admins.edit') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.admins.edit') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Informations
            </span>
            <i class="fas fa-user-edit ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.admins.pfp') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.admins.pfp') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Photo de profil
            </span>
            <i class="fas fa-portrait ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.admins.security') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.admins.security') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Sécurité
            </span>
            <i class="fas fa-key ms-2"></i>
        </a>
    </div>
    <div class="col-2 d-flex justify-content-end p-0">
        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary ">
            <i class="fa fa-arrow-left me-2"></i>
            <span>
                Retour
            </span>
        </a>
    </div>

</div>
{{-- /Breadcrumbs --}}