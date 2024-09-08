@extends('member._elements.layout')

@section('title', 'Mes abonnements')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('member.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Abonnements</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}

{{-- Page content --}}
<div class="card border border-4 border-primary">


    {{-- Content Body --}}
    <div class="card-body mb-4">

      

        <div class="row mt-4 mb-5">
            <div class="col">
                @if(Auth::user()->hasCurrentPlan())
    
                    <div class="alert alert-success text-center mb-0" role="alert">
                        <div>
                            Actuellement abonné, tarif 
                            <strong>
                                {{ Auth::user()->currentPlan()->first()->pricing->title }}
                            </strong>
                            , il reste
                            <strong>
                                {{ Auth::user()->currentPlan()->first()->getDaysLeft() }}
                            </strong> 
                            jours et 
                            <strong>
                                {{ Auth::user()->currentPlan()->first()->sessions_left }}
                            </strong> 
                            séances à effectuer avant expiration.
                        </div>
                    </div>  
                @else 
                    <div class="alert alert-secondary text-center mb-0" role="alert">
                        Vous n'avez pas d'abonnement en cours.
                        <a href="javascript:void(0);" class="alert-link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#addPlan">
                            Ajouter un abonnement
                        </a>
                    </div>   
                @endif
            </div>
            <div class="col-3">
                <a 
                    href="javascript:void(0);" 
                    class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center gap-2"
                >
                    <i class="fas fa-shopping-cart"></i>
                    Acheter des séances
                </a>
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
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->plans->where('expiration_date', '<', now())->sortByDesc('id') as $plan)
                    <tr>
                        <td>#{{ $plan->id }}</td>
                        <td>{{ $plan->created_at->format('d/m/y') }}</td>
                        <td>
                            {{ $plan->sessions_left }} / {{ $plan->pricing->nbr_sessions }}
                        </td>
                        <td>
                            {{ $plan->pricing->title }} - {{ $plan->pricing->price }}€
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
                    </tr>
                @endforeach
            </tbody>
        </table>
            
       


            

    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}


@endsection

