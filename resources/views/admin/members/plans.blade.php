@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}



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
        </div>

       

                    
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Séances restantes</th>
                    <th scope="col">Abonnement</th>
                    <th scope="col">Option Nutrition</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member->plans->where('expiration_date', '<', now())->sortByDesc('id') as $plan)
                    <tr>
                        <td>#{{ $plan->id }}</td>
                        <td>{{ $plan->created_at->format('d/m/Y') }}</td>
                        <td>
                            {{ $plan->sessions_left }} / {{ $plan->pricing->nbr_sessions }}
                        </td>
                        <td>
                            <a href="{{ route('admin.pricings.edit', ['pricing' => $plan->pricing]) }}" class="alert-link text-decoration-underline">
                                {{ $plan->pricing->title }} - {{ $plan->pricing->price }}€
                            </a>
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

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

