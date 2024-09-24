@extends('admin._elements.layout')

@section('title', 'Réductions')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Réductions</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les codes de réduction
            </h4>
            <a 
                href="{{ route('admin.reductions.create') }}"
                class="btn btn-primary btn-sm"
            >
                <span>
                    Ajouter un code de réduction
                </span>
                <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez gérer les codes de réduction pour des événements spécifiques.
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
                        <th>Code</th>
                        <th>Réduction</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Utilisateurs</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reductions as $reduction)
                        <tr>
                            {{-- ID --}}
                            <td>
                                {{ $reduction->id }}
                            </td>
                            {{-- Statut --}}
                            <td>
                                @if($reduction->online)
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
                            {{-- Code --}}
                            <td>
                                {{ $reduction->code }}
                            </td>
                            {{-- Pourcentage --}}
                            <td>
                                <div 
                                    class="progress"
                                    title="{{ $reduction->percentage }}% de réduction"
                                >
                                    <div 
                                        class="progress-bar bg-primary" 
                                        role="progressbar" 
                                        style="width: {{ $reduction->percentage }}%" 
                                        aria-valuenow="{{ $reduction->percentage }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100"
                                    >
                                        {{ $reduction->percentage }}%
                                    </div>
                                </div>
                            </td>
                            {{-- Date de début --}}
                            <td>
                                {{ Carbon\Carbon::parse($reduction->start_date)->format('d/m/y') }}
                            </td>
                            {{-- Date de fin --}}
                            <td>
                                {{ Carbon\Carbon::parse($reduction->end_date)->format('d/m/y') }}
                            </td>
                            {{-- Nombre d'utilisateurs --}}
                            <td>
                                {{ $reduction->users->count() }}
                            </td>
                            {{-- Action --}}
                            <td>
                                <div class="d-flex">

                                    <a title="Voir les membres associés au code de réduction" href="{{ route('admin.reductions.members', ['reduction' => $reduction]) }}" class="btn btn-outline-success shadow btn-xs sharp me-1"><i class="fa fa-users"></i></a>
                                    <a title="Modifier le code de réduction" href="{{ route('admin.reductions.edit', ['reduction' => $reduction]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    <a title="Mettre à la corbeille le code de réduction" href="{{ route('admin.reductions.soft-delete', ['reduction' => $reduction]) }}" class="btn btn-outline-danger shadow btn-xs sharp warning-row"><i class="fa fa-trash"></i></a>
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

