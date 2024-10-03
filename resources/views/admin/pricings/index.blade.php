@extends('admin._elements.layout')

@section('title', 'Tarifs')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tarifs</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    
    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les tarifs
            </h4>
            <a 
                href="{{ route('admin.pricings.create') }}"
                class="btn btn-primary"
            >
                <span>
                    Ajouter un tarif
                </span>
                <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez gérer les tarifs de votre application, abonnements et coûts d'une séance à l'unité.
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
                        <th>Titre</th>
                        <th>Nombre de sessions</th>
                        <th>Adhérents actifs</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pricings as $pricing)
                        <tr>
                            <td>#{{ $pricing->id }}</td>
                            <td>
                                @if($pricing->online)
                                    <span class="badge bg-success">
                                        <span>
                                            En ligne
                                        </span>
                                        <i class="fas fa-check ms-1"></i>
                                    </span>
                                @else 
                                    <span class="badge bg-secondary">
                                        <span>
                                            Hors ligne
                                        </span>
                                        <i class="fas fa-times ms-1"></i>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $pricing->title }}</td>
                            <td>{{ $pricing->nbr_sessions }}</td>
                            <td>{{ $pricing->nbrOfUsers() }}</td>
                            <td>{{ $pricing->price }}</td>
                            <td>
                                <div class="d-flex">
                                    <a title="Modifier le tarif" href="{{ route('admin.pricings.edit', ['pricing' => $pricing]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    <a title="Mettre à la corbeille le tarif" href="{{ route('admin.pricings.soft-delete', ['pricing' => $pricing]) }}" class="btn btn-outline-danger shadow btn-xs sharp warning-row"><i class="fa fa-trash"></i></a>
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

