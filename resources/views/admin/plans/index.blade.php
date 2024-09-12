@extends('admin._elements.layout')

@section('title', 'Abonnements')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Abonnements</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les abonnements
            </h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez une vue d'ensemble sur les abonnements de votre application.
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
                    @foreach($plans->sortByDesc('id') as $plan)
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
                                <a href="{{ route('admin.members.plans.index', ['user' => $plan->user]) }}" class="text-decoration-underline">
                                    {{ $plan->user->firstname }} {{ $plan->user->lastname }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.pricings.edit', ['pricing' => $plan->pricing]) }}" class="text-decoration-underline">
                                    {{ $plan->pricing->title }}
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
                                <div class="d-flex gap-1">
                                    @if($plan->expiration_date < now())
                                        @if(!$plan->user->hasCurrentPlan())
                                            <a title="Restaurer l'abonnement" href="{{ route('admin.members.plans.unexpire', ['plan' => $plan, 'user' => $plan->user]) }}" class="btn btn-primary shadow btn-xs sharp"><i class="fas fa-redo-alt"></i></a>
                                        @endif
                                    @else
                                        <a title="Expirer l'abonnement" href="{{ route('admin.members.plans.expire', ['plan' => $plan, 'user' => $plan->user]) }}" class="btn btn-warning shadow btn-xs sharp"><i class="fas fa-exclamation-triangle"></i></a>
                                    @endif
                                    <a title="Mettre à la corbeille l'abonnement" href="{{ route('admin.plans.soft-delete', ['plan' => $plan]) }}" class="btn btn-outline-danger shadow btn-xs sharp warning-row"><i class="fa fa-trash"></i></a>
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

