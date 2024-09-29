@extends('admin._elements.layout')

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

{{-- Cards --}}
<div class="row">

    {{-- Membres inscrits --}}
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card border border-primary">
            <div class="card-body p-4">
                <div class="media ai-icon">
                    <span class="me-3 bg-dark text-primary">
                        <i class="ti-user"></i>
                    </span>
                    <div class="media-body">
                        <p class="mb-1">Membres</p>
                        <h4 class="mb-0">
                            {{ $members->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenues totaux --}}
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card border border-primary">
            <div class="card-body p-4">
                <div class="media ai-icon">
                    <span class="me-3 bg-dark text-primary">
                        <i class="ti-wallet"></i>
                    </span>
                    <div class="media-body">
                        <p class="mb-1">Revenues</p>
                        <h4 class="mb-0" style="white-space: nowrap">
                            {{ number_format($revenues, 2, ',', ' ') }} €
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Séances --}}
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
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
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
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

{{-- Chart & small Calendar --}}
<div class="row">
    {{-- Chart --}}
    <div class="col-xl-7 col-xxl-7 col-lg-7 col-md-12">

        <div class="card border border-primary">
            <div class="card-header border-bottom border-primary  flex-wrap p-4">
                {{-- Title --}}
                <div class="flex-wrap d-flex  w-100 align-items-center justify-content-between">
                    <div class="card-title d-flex gap-3 align-items-center">
                        <i class="fas fa-chart-line bg-dark p-2 text-primary rounded-circle"></i>
                        <h4 class="mb-0 ">
                            Revenues
                        </h4>
                    </div>
                    <div class="card-action coin-tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#Yearly">
                                    Cette année
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Monthly">
                                    Ce mois-ci
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-bs-toggle="tab" href="#Weekly">
                                    Cette semaine
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-description">
                    <p class="text-muted  mb-0 font-weight-light">
                        Consultez les revenues de votre application.
                    </p>
                </div>
            </div>

            <div class="card-body pt-2">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="Yearly">
                        <canvas id="year-chart"></canvas>
                    </div>
                    <div class="tab-pane fade" id="Monthly">
                        <canvas id="month-chart"></canvas>
                    </div>
                    <div class="tab-pane fade" id="Weekly">
                        <canvas id="week-chart"></canvas>
                    </div>
                </div>
            </div>
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

{{-- Table of contacts message --}}
<div class="card border border-4 border-primary">
    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les messages
            </h4>
            <a 
                href="{{ route('admin.contacts.index') }}"
                class="btn btn-primary btn rounded-circle"
                title="Voir tous les messages"
            >
                <i class="fa fa-arrow-right "></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Consultez les messages soumis par les visiteurs de votre application.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Statut</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>#{{ $contact->id }}</td>
                            <td>
                                @if($contact->read)
                                    <span class="badge bg-primary">Lu</span>
                                @else 
                                    <span class="badge bg-secondary">Non lu</span>
                                @endif
                            </td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>
                                <div class="d-flex">
                                    <a 
                                        href="{{ route('admin.contacts.show', $contact->id) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if($contacts->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center">
                                Aucun message n'a été trouvé.
                            </td>
                        </tr>
                    @endif  
                </tbody>
            </table>
        </div>
    </div>
    {{-- /Content Body --}}
</div>


@endsection


@section('scripts')

    <script defer>
        // Data - charts
        window.yearChartData = @json($yearChartData);
        window.monthChartData = @json($monthChartData);
        window.weekChartData = @json($weekChartData);

        // Data - calendar
        window.workoutsData = @json($workouts);
    </script>

    @vite('resources/js/pages/admin/dashboard.js')
@endsection