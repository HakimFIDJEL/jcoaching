@extends('member._elements.layout')

@section('title', 'Tableau de bord')

@section('content')

{{-- Title --}}
<div class="form-head mb-4 d-flex flex-wrap align-items-center">
    <div class="me-auto">
        <h2 class="font-w600 mb-0">
            Tableau de bord
        </h2>
        <p class="text-muted">
            Bienvenue sur votre tableau de bord {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}.
        </p>
    </div>
</div>



{{-- Cards & small Calendar --}}
<div class="row">
    {{-- Cards --}}
    <div class="col-xl-7 col-xxl-7 col-lg-7 col-md-12">

        {{-- Cards --}}
        <div class="row">

            {{-- Séances --}}
            <div class="col">
                <div class="widget-stat card border border-primary">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bg-dark text-primary">
                                <i class="ti-agenda"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Séances</p>
                                <h4 class="mb-0">
                                    {{ $workouts->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Date actuelle --}}
            <div class="col">
                <div class="widget-stat card border border-secondary">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bg-dark text-secondary">
                                <i class="ti-calendar"></i>
                            </span>
                            <div class="media-body
                            ">
                                <p class="mb-1">Date
                                </p>
                                <h4 class="mb-0">
                                    {{ date('d/m/y') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">

            {{-- Plan --}}
            @if(Auth::user()->hasCurrentPlan())
                <div class="col">
                    <div class="widget-stat card border border-success">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                                <span class="me-3 bg-dark text-success">
                                    <i class="ti-package"></i>
                                </span>
                                <div class="media-body
                                ">
                                    <p class="mb-1">
                                        Vous avez un abonnement actif associé au tarif <span class="text-decoration-underline">{{ Auth::user()->currentPlan->pricing->title }}</span>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col">
                    <div class="widget-stat card border border-warning">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                                <span class="me-3 bg-dark text-warning">
                                    <i class="ti-package"></i>
                                </span>
                                <div class="media-body
                                ">
                                    <p class="mb-1">
                                        Vous n'avez pas d'abonnement actif.
                                    </p>
                                        <a 
                                            href="{{ route('member.payment.plan.index') }}"
                                            class="btn btn-outline-warning"
                                        >
                                            Souscrire un abonnement
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        

    </div>
    {{-- /Chart --}}
    
    {{-- Calendar --}}  
    <div class="col-xl-5 col-xxl-5 col-lg-5 col-md-12">
        <div class="card border border-primary">
            {{-- Content Header --}}
            <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                <div class="card-title d-flex w-100 align-items-center gap-3">
                    <i class="fas fa-calendar-alt bg-dark p-2 text-primary rounded-circle"></i>
                    <h4 class="mb-0">
                        Le calendrier
                    </h4>
                </div>
                <div class="card-description">
                    <p class="text-muted  mb-0 font-weight-light">
                        Consultez les séances de votre application.
                    </p>
                </div>
            </div>
            {{-- /Content Header --}}

            {{-- Content body --}}
            <div class="card-body">
                <div id="calendar" class="dashboard overflow-hidden"></div>
            </div>
            {{-- /Content body --}}
        </div>
    </div>
    {{-- /Calendar --}}
</div>

{{-- Idée nutrition --}}
@if(Auth::user()->hasCurrentPlan())
    @if(Auth::user()->currentPlan->nutrition_option)
        <div class="row">
            <div class="col">
                <div class="card shadow-lg border-0">
                    <div class="card-header border border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                L'idée repas de la semaine
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Consultez l'idée de repas de la semaine préparée par notre coach sportif !
                            </p>
                        </div>
                    </div>
                    <div class="card-body ">
                        <p class="lead">{!! $nutrition_idea !!}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif


@endsection


@section('scripts')

    <script defer>

        // Data - calendar
        window.workoutsData = @json($workouts);
    </script>

    @vite('resources/js/pages/member/dashboard.js')
@endsection