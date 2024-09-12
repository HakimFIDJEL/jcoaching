@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}




{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title">
            <h4 class="mb-0">Les abonnements de {{ $member->firstname }} {{ $member->lastname }}</h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez la possibilité de gérer les abonnements du membre.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body">
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
        </div>
                    
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tarif</th>
                    <th scope="col">Avancement</th>
                    <th scope="col">Nutrition</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member->plans->where('expiration_date', '<', now())->sortByDesc('id') as $plan)
                    <tr>
                        <td>{{ $plan->id }}</td>
                        <td>
                            <a href="{{ route('admin.pricings.edit', ['pricing' => $plan->pricing]) }}" class="alert-link text-decoration-underline">
                                {{ $plan->pricing->title }} - {{ $plan->pricing->price }}€
                            </a>
                        </td>
                        <td>
                            @php
                                $nbr_sessions = $plan->pricing->nbr_sessions;
                                $sessions_left = $plan->sessions_left;
                                $progress = (($sessions_left - $nbr_sessions) * -1) / $nbr_sessions * 100;
                                @endphp
                            <div 
                                class="progress"    
                                title="{{ $sessions_left }} sessions restantes - {{ $progress }}%"
                                >
                                <div 
                                class="progress-bar bg-primary" 
                                role="progressbar" 
                                style="width: {{ $progress }}%" 
                                aria-valuenow="{{ $progress }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100" 
                                >
                                {{ $progress }}%
                            </div>
                            </div>
                        </td>
                        <td>
                            @if($plan->nutrition_option)
                            <span class="badge bg-success">
                                    <span>
                                        Oui
                                    </span>
                                    <i class="fas fa-check ms-2"></i>
                                </span>
                                @else 
                                <span class="badge bg-danger">
                                    <span>
                                        Non
                                    </span>
                                    <i class="fas fa-times ms-2"></i>
                                </span>
                                @endif
                            </td>
                        <td>{{ $plan->created_at->format('d/m/y') }}</td>
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
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}

@include('admin.members._elements.plans_modal')

@endsection


