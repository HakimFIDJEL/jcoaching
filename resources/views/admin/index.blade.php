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
                        <h4 class="mb-0">1,235</h4>
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
                            89,000 &euro;
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
                        <h4 class="mb-0">84</h4>
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
    <div class="col-xl-8 col-xxl-8 col-lg-8 col-md-12">
        <div class="card border border-primary">
            {{-- Content Header --}}
            <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                <div class="card-title d-flex w-100 align-items-center justify-content-between">
                    <h4 class="mb-0">
                        Les séances
                    </h4>
                    <i class="fas fa-chart-line ms-3 bg-dark p-2 text-primary rounded-circle"></i>
                </div>
                <div class="card-description">
                    <p class="text-muted  mb-0 font-weight-light">
                        Consultez les statistiques des séances de votre application.
                    </p>
                </div>
            </div>
            {{-- /Content Header --}}

            {{-- Content body --}}
            <div class="card-body">
                <div id="chartSeances"></div>
            </div>
            {{-- /Content body --}}
        </div>
    </div>
    {{-- /Chart --}}
    
    {{-- Calendar --}}  
    <div class="col-xl-4 col-xxl-4 col-lg-4 col-md-12">
        <div class="card border border-primary">
            {{-- Content Header --}}
            <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                <div class="card-title d-flex w-100 align-items-center justify-content-between">
                    <h4 class="mb-0">
                        Le calendrier
                    </h4>
                    <i class="fas fa-calendar-alt ms-3 bg-dark p-2 text-primary rounded-circle"></i>
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
                <div id="calendar"></div>
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
                    {{-- @foreach($contacts as $contact)
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
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    {{-- /Content Body --}}
</div>


@endsection
