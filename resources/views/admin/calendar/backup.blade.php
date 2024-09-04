@extends('admin._elements.layout')

@section('title', 'Calendrier')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        @if($user)
            <li class="breadcrumb-item"><a href="{{ route('admin.members.edit', ['user' => $user]) }}">{{ $user->firstname }} {{ $user->lastname }}</a></li>
        @endif
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Calendrier</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
    {{-- Calendrier --}}
    <div class="row">

        <div class="col-xl-3 col-xxl-4">
            <div class="card border border-primary">
                <div class="card-body">
                    <h4 class="card-intro-title">
                        <span>
                            Calendrier
                        </span>
                        <i class="fa fa-calendar-alt float-end"></i>
                    </h4>

                    <hr>

                    <form action="{{ route('admin.calendar.search') }}" method="POST">
                        @csrf
                    
                        <div class="mb-3">
                            <label for="user" class="form-label">Sélectionner un utilisateur</label>
                            <select class="default-select form-control wide mb-3" name="user" id="user">
                                <option value="" @if(!$user) selected @endif>Tous</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" @if($user && $user->id == $member->id) selected @endif>
                                        {{ $member->firstname }} {{ $member->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <span>Voir les séances</span>
                            <i class="fa fa-eye ms-2"></i>
                        </button>
                    </form>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Séances à planifier</label>
                            {{-- Un utilisateur est sélectionné --}}
                            @if($user)
                                <ul class="list-group gap-2">
                                    @foreach ($user->workouts->where('date', null)->sortByDesc('id') as $workout)
                                        <li 
                                            class="list-group border border-primary p-2 draggable" 
                                            style="border-radius: 0; cursor: move;" 
                                            data-user="{{ $user->id }}" 
                                            data-workout="{{ $workout->id }}"
                                        >
                                            Séance #{{ $workout->id }}
                                        </li>
                                    @endforeach

                                    @if($user->workouts->where('date', null)->count() == 0)
                                        <li class="list-group border border-primary p-2" style="border-radius: 0">
                                            Aucune séance à planifier
                                        </li>
                                    @endif

                                </ul>
                            {{-- Tous les membres --}}
                            @else 
                                <ul class="list-group gap-2">
                                    @foreach($members as $member)
                                        @foreach ($member->workouts->where('date', null)->sortByDesc('id') as $workout)
                                            <li 
                                                class="list-group border border-primary p-2 draggable" 
                                                style="border-radius: 0; cursor: move;" 
                                                data-user="{{ $member->id }}" 
                                                data-workout="{{ $workout->id }}"
                                            >
                                                Séance #{{ $workout->id }} - {{ $member->firstname }} {{ $member->lastname }}
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            @endif
                    </div>

                    <hr>

                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addWorkout" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                        <span>
                            Ajouter une séance
                        </span>
                        <i class="fas fa-plus ms-2"></i>
                    </a>
                </div>
            </div>
        </div>


        <div class="col-xl-9 col-xxl-8">
            <div class="card p-0">
                <div class="card-body">
                    <div id="calendar" class="app-fullcalendar"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- /Calendrier --}}

    <hr>

    @if($user)
        {{-- Tableau of user--}}
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type de séance</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($user->workouts->where('date', '!=', null)->sortByDesc('id') as $workout)
                        <tr>
                            <td>#{{ $workout->id }}</td>
                            <td>
                                {{-- Séance terminée --}}
                                @if($workout->status == 1)
                                    <span class="badge bg-success">
                                        <span>
                                            Terminée
                                        </span>
                                        <i class="fas fa-check ms-2"></i>
                                    </span>
                                @else
                                    {{-- Séance terminée ou non, il faut définir comme terminé ou replanifier la séance --}}
                                    @if($workout->date > now())
                                        <span class="badge bg-warning">
                                            <span>
                                                A définir
                                            </span>
                                            <i class="fas fa-clock ms-2"></i>
                                        </span>
                                    {{-- Séance pas encore faite --}}
                                    @else 
                                        <span class="badge bg-warning">
                                            <span>
                                                En attente
                                            </span>
                                            <i class="fas fa-clock ms-2"></i>
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($workout->date)->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($workout->plan_id)
                                    <span class="badge bg-success">
                                        <a href="{{ route('admin.pricings.edit', ['pricing' => $workout->plan->pricing]) }}">
                                            Abonnement - {{ $workout->plan->pricing->title }} 
                                        </a >
                                        <i class="fas fa-check ms-2"></i>
                                    </span>
                                @else 
                                    <span class="badge bg-secondary">
                                        <span>
                                            Indépendant
                                        </span>
                                        <i class="fas fa-times ms-2"></i>
                                    </span>
                                @endif
                            </td>
                            <td>

                                <a 
                                    href="javascript:void(0);" 
                                    class="btn btn-primary btn-sm"
                                    title="Modifier la séance"
                                    data-bs-toggle="modal" data-bs-target="#updateWorkout"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>


                                <a 
                                    href="{{ route('admin.calendar.workouts.refuse-date', ['user' => $user, 'workout' => $workout]) }}" 
                                    class="btn btn-secondary btn-sm warning-row"
                                    title="Refuser la date"
                                >
                                    <i class="fas fa-times"></i>
                                </a>
                                <a 
                                    href="{{ route('admin.calendar.workouts.soft-delete', ['user' => $user, 'workout' => $workout]) }}"
                                    class="btn btn-danger btn-sm warning-row"
                                    title="Supprimer la séance"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                
            </tbody>
        </table>
        {{-- /Tableau --}}
    @else 
        {{-- Tableau of members--}}
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Membre</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type de séance</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $user)
                    @foreach($user->workouts->where('date', '!=', null)->sortByDesc('id') as $workout)
                        <tr>
                            <td>#{{ $workout->id }}</td>
                            <td>
                                <a href="{{ route('admin.members.edit', ['user' => $user]) }}">
                                    {{ $user->firstname }} {{ $user->lastname }}
                                </a>
                            </td>
                            <td>
                                @if($workout->status == 1)
                                    <span class="badge bg-success">
                                        <span>
                                            Terminée
                                        </span>
                                        <i class="fas fa-check ms-2"></i>
                                    </span>
                                @else
                                    @if($workout->date > now())
                                        <span class="badge bg-warning">
                                            <span>
                                                A définir
                                            </span>
                                            <i class="fas fa-clock ms-2"></i>
                                        </span>
                                    @else 
                                        <span class="badge bg-warning">
                                            <span>
                                                En attente
                                            </span>
                                            <i class="fas fa-clock ms-2"></i>
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($workout->date)->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($workout->plan_id)
                                    <span class="badge bg-success">
                                        <a href="{{ route('admin.pricings.edit', ['pricing' => $workout->plan->pricing]) }}">
                                            Abonnement - {{ $workout->plan->pricing->title }} 
                                        </a >
                                        <i class="fas fa-check ms-2"></i>
                                    </span>
                                @else 
                                    <span class="badge bg-secondary">
                                        <span>
                                            Indépendant
                                        </span>
                                        <i class="fas fa-times ms-2"></i>
                                    </span>
                                @endif
                            </td>
                            <td>

                                <a 
                                    href="javascript:void(0);" 
                                    class="btn btn-primary btn-sm"
                                    title="Modifier la séance"
                                    data-bs-toggle="modal" data-bs-target="#updateWorkout"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>


                                <a 
                                    href="{{ route('admin.calendar.workouts.refuse-date', ['user' => $user, 'workout' => $workout]) }}" 
                                    class="btn btn-secondary btn-sm warning-row"
                                    title="Refuser la date"
                                >
                                    <i class="fas fa-times"></i>
                                </a>
                                <a 
                                    href="{{ route('admin.calendar.workouts.soft-delete', ['user' => $user, 'workout' => $workout]) }}"
                                    class="btn btn-danger btn-sm warning-row"
                                    title="Supprimer la séance"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        {{-- /Tableau --}}
    @endif
{{-- /Page content --}}

@include("admin.calendar._elements.calendar_modal")
@include("admin.calendar._elements.workouts_modal")


@endsection



@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection
