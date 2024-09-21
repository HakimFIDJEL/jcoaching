@extends('admin._elements.layout')

@section('title', 'Corbeille - Séances')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les séances
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.workouts.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer toutes les séances"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.workouts.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer toutes les séances"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux séances mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                        <th scope="col">
                            ID
                        </th>
                        <th scope="col">
                            Statut
                        </th>
                        <th scope="col">
                            Membre
                        </th>
                        <th scope="col">
                            Obtention
                        </th>
                        <th scope="col">
                            Date
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workouts as $workout)
                        <tr>

                            {{-- ID - DONE --}}
                            <td>
                                #{{ $workout->id }}
                            </td>

                            {{-- Status - DONE --}}
                            <td>
                                @if($workout->date)
                                    @if($workout->status == 1)
                                        <span class="badge bg-success">
                                            <span>
                                                Faite
                                            </span>
                                            <i class="fas fa-check ms-2"></i>
                                        </span>
                                    @else 
                                        <span class="badge bg-warning">
                                            <span>
                                                Non faite
                                            </span>
                                            <i class="fas fa-close ms-2"></i>
                                        </span>
                                    @endif
                                @else 
                                    <span class="badge bg-danger">
                                        <span>
                                            A planifier
                                        </span>
                                        <i class="fas fa-exclamation-triangle ms-2"></i>
                                    </span> 
                                @endif
                            </td>

                            {{-- Membre - DONE --}}
                            <td>
                                @if($workout->user)
                                    {{ $workout->user->firstname }} {{ $workout->user->lastname }}
                                @else
                                    <span class="badge bg-danger">
                                        <span>
                                            Membre supprimé
                                        </span>
                                        <i class="fas fa-exclamation-triangle ms-2"></i>
                                    </span>
                                @endif
                            </td>

                            {{-- Obtention - DONE --}}
                            <td>
                                @if($workout->plan_id)
                                    <span class="badge bg-primary">
                                        Abonnement
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        A l'unité
                                    </span>
                                @endif
                            </td>

                            {{-- Date - DONE --}}
                            <td>
                                @if($workout->date)
                                    {{ Carbon\Carbon::parse($workout->date)->format('d/m/y - H:i') }}
                                @else 
                                    <span class="badge bg-danger">
                                        <span>
                                            A planifier
                                        </span>
                                        <i class="fas fa-exclamation-triangle ms-2"></i>
                                    </span>
                                @endif
                            </td>

                            {{-- Actions - DONE --}}
                            <td>
                                <div class="d-flex">
                                    @if($workout->user)
                                        <a title="Restorer la séance" href="{{ route('admin.calendar.workouts.restore', ['id' => $workout->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    @endif
                                    <a title="Supprimer la séance" href="{{ route('admin.calendar.workouts.delete', ['id' => $workout->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

