@extends('admin._elements.layout')

@section('title', 'Corbeille - Réductions')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les tarifs
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.reductions.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer toutes les réductions"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.reductions.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer toutes les réductions"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux réductions mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reductions as $reduction)
                        <tr>
                            {{-- ID --}}
                            <td>
                                #{{ $reduction->id }}
                            </td>
                            {{-- Statut --}}
                            <td>
                                @if($reduction->online == 1)
                                    <span class="badge bg-success">
                                        <span>
                                            En ligne
                                        </span>
                                        <i class="fas fa-check ms-1"></i>
                                    </span>
                                @else
                                    <span class="badge bg-danger">
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
                                <div class="progress">
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
                            {{-- Action --}}
                            <td>											
                                <div class="d-flex">
                                    <a title="Restorer la réduction" href="{{ route('admin.reductions.restore', ['id' => $reduction->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer la réduction" href="{{ route('admin.reductions.delete', ['id' => $reduction->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

