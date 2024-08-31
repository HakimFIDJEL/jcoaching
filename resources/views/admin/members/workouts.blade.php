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
        <a href="{{ route('admin.members.workouts', ['user' => $member]) }}" class="btn btn-primary d-flex align-items-center">
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
    <div class="card-body mb-4">

      

        <div class="row mt-4 mb-5">
            <div class="col">
                @if($member->hasCurrentPlan())
    
                    <div class="alert alert-success text-center mb-0" role="alert">
                        <div>
                            Actuellement abonné, tarif 
                            <strong>
                                {{ $member->currentPlan()->first()->pricing->title }}
                            </strong>
                            , il reste
                            <strong>
                                {{ $member->currentPlan()->first()->getDaysLeft() }}
                            </strong> 
                            jours et 
                            <strong>
                                {{ $member->currentPlan()->first()->sessions_left }}
                            </strong> 
                            séances à effectuer avant expiration.
                        </div>
                        <div>
                            <a 
                                href="javascript:void(0);" 
                                class="alert-link text-decoration-underline me-3"
                                style="white-space: nowrap;"
                                data-bs-toggle="modal" 
                                data-bs-target="#updatePlan" 
                            >
                                Modifier l'abonnement
                            </a>                                    
                            <a 
                                href="{{ route('admin.members.plans.expire', ['user' => $member]) }}" 
                                class="alert-link text-decoration-underline warning-row" 
                                style="white-space: nowrap;"
                            >
                                Expirer l'abonnement
                            </a>                                    
                        </div>
                    </div>  
                @else 
                    <div class="alert alert-secondary text-center mb-0" role="alert">
                        Le membre n'a pas d'abonnement en cours.
                        <a href="javascript:void(0);" class="alert-link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#addPlan">
                            Ajouter un abonnement
                        </a>
                    </div>   
                @endif
            </div>
            <div class="col-3">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addWorkout" class="btn btn-outline-primary w-100 h-100 d-flex align-items-center justify-content-center">
                    <span>
                        Ajouter une séance
                    </span>
                    <i class="fas fa-plus ms-2"></i>
                </a>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="plan-tab" data-bs-toggle="tab" data-bs-target="#plan" type="button" role="tab" aria-controls="plan" aria-selected="true">Abonnements</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pfp-tab" data-bs-toggle="tab" data-bs-target="#workout" type="button" role="tab" aria-controls="workout" aria-selected="false">Séances</button>
            </li>
            
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="plan" role="tabpanel" aria-labelledby="plan-tab">
                    
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Séances restantes</th>
                            <th scope="col">Abonnement</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member->plans->where('expiration_date', '<', now())->sortByDesc('id') as $plan)
                            <tr>
                                <td>#{{ $plan->id }}</td>
                                <td>{{ $plan->created_at->format('d/m/Y') }}</td>
                                <td>{{ $plan->sessions_left }}</td>
                                <td>
                                    {{ $plan->pricing->title }} - {{ $plan->pricing->price }}€
                                </td>
                                <td>
                                    <a 
                                        href="{{ route('admin.members.plans.unexpire', ['plan' => $plan, 'user' => $member]) }}" 
                                        class="btn btn-primary btn-sm"
                                        title="Restaurer l'abonnement"
                                    >
                                        <i class="fas fa-redo-alt"></i>
                                    </a>
                                    <a 
                                        href="{{ route('admin.members.plans.soft-delete', ['plan' => $plan, 'user' => $member]) }}" 
                                        class="btn btn-danger btn-sm delete-row"
                                        title="Supprimer l'abonnement"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>

            <div class="tab-pane fade" id="workout" role="tabpanel" aria-labelledby="workout-tab">
                
              
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Date</th>
                            <th scope="col">Abonnement ?</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member->workouts->sortByDesc('id') as $workout)
                            <tr>
                                <td>#{{ $workout->id }}</td>
                                <td>
                                    @if($workout->date)
                                        @if($workout->status == true)
                                            <span class="badge bg-success">
                                                <span>
                                                    Terminée
                                                </span>
                                                <i class="fas fa-check ms-2"></i>
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <span>
                                                    A faire
                                                </span>
                                                <i class="fas fa-clock ms-2"></i>
                                            </span>
                                        @endif
                                    @else 
                                        <span class="badge bg-secondary">
                                            <span>
                                                A planifier
                                            </span>
                                            <i class="fas fa-calendar-alt ms-2"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($workout->date)
                                        {{ $workout->date->format('d/m/Y') }}
                                    @else
                                        Aucune date
                                    @endif
                                </td>
                                <td>
                                    @if($workout->plan)
                                        {{ $workout->plan->pricing->title }}
                                    @else
                                        Aucun
                                    @endif
                                </td>
                                <td>
                                    <a 
                                        href="" 
                                        class="btn btn-primary btn-sm"
                                        title="Planifier la séance"
                                    >
                                        <i class="fas fa-calendar-alt"></i>
                                    </a>

                                    <a 
                                        href="{{ route('admin.members.workouts.soft-delete', ['workout' => $workout]) }}" 
                                        class="btn btn-danger btn-sm warning-row"
                                        title="Supprimer la séance"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if($member->workouts->count() == 0)
                            <tr>
                                <td colspan="5" class="text-center">
                                    Aucune séance n'a été trouvée.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
             
            </div>

        </div>
            
       


            

    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}

@include('admin.members._elements.workout_modal')

@endsection

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

