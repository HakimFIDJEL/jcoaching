@extends('admin._elements.layout')

@section('title', 'Corbeille - Abonnements')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les abonnements
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.plans.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer tous les témoignages"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.plans.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer tous les témoignages"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux abonnements mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <div class="table-responsive">
            <table style="min-width: 845px" class="datatable display mt-5 mb-5">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Statut</th>
                        <th>Membre</th>
                        <th>Tarif</th>
                        <th>Avancement</th>
                        <th>Nutrition</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                        <tr>
                            <td>{{ $plan->id }}</td>
                            <td>
                                @if($plan->expiration_date < now())
                                    <span class="badge bg-danger">
                                        <span>
                                            Expiré
                                        </span>
                                        <i class="fas fa-exclamation-triangle ms-1"></i>
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <span>
                                            Actif
                                        </span>
                                        <i class="fas fa-check ms-1"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($plan->user)
                                    {{ $plan->user->firstname }} {{ $plan->user->lastname }}
                                @else
                                    <span class="badge bg-danger">
                                        <span>
                                            Utilisateur supprimé
                                        </span>
                                        <i class="fas fa-user-slash ms-1"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($plan->pricing)
                                    {{ $plan->pricing->title }}
                                @else
                                    <span class="badge bg-danger">
                                        <span>
                                            Tarif supprimé
                                        </span>
                                        <i class="fas fa-euro-sign ms-1"></i>
                                    </span>
                                @endif
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
                                <div class="d-flex">
                                    <a title="Restorer l'abonnement" href="{{ route('admin.plans.restore', ['id' => $plan->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer l'abonnement" href="{{ route('admin.plans.delete', ['id' => $plan->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
                                </div>												
                            </td>
                        </tr>
                    @endforeach										
                </tbody>
            </table>
            
        </div>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection

