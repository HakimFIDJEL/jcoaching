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
    
<div class="d-flex align-items-center mb-5 gap-5 justify-content-between">
    <div class="col d-flex align-items-center gap-3 p-0 flex-wrap">

        <a href="{{ route('admin.members.edit', ['user' => $member]) }}" class="btn btn-outline-primary d-flex align-items-center">
            <span>
                Informations
            </span>
            <i class="fas fa-user-edit ms-2"></i>
        </a>
        <a href="{{ route('admin.members.pfp', ['user' => $member]) }}" class="btn btn-primary d-flex align-items-center">
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

      

        <form action="{{ route('admin.members.update-pfp', ['user' => $member]) }}" method="post" enctype="multipart/form-data">
            @csrf
    
            <div class="row">
                <div class="col">
                    <label for="pfp" class="form-label">Photo de profil</label>
                    <input 
                        type="file"
                        class="filepond"
                        id="pfp"
                        name="pfp"
                        accept="image/*, video/*"
                        data-max-files="1"
                        @if($member->pfp_path)
                            data-documents="{{ json_encode([[
                                'source' => asset('storage/' . str_replace('public/', '', $member->pfp_path)),
                            ]]) }}"
                        @endif                                
                    >
                </div>
            </div>
            
    
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <span>
                            Modifier la photo de profil
                        </span>
                        <i class="fas fa-upload ms-2"></i>
                    </button>
                </div>
                @if($member->pfp_path)
                    <div class="col-4">
                        <a href="{{ route('admin.members.download-pfp', ['user' => $member]) }}" class="btn btn-secondary w-100">
                            <span>
                                Télécharger la photo de profil
                            </span>
                            <i class="fas fa-download ms-2"></i>
                        </a>
                    </div>
                @endif
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

