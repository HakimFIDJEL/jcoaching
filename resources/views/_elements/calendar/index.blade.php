@php 
    $fullcalendar_workouts_visible = $workouts_visible;
    $fullcalendar_workouts_locked  = $workouts_locked;
    $fullcalendar_rest_periods   = $rest_periods;

    if(Auth::user()->isAdmin()) {
        $update_workout_route        = route('admin.calendar.workouts.update');
    } else {
        $update_workout_route        = route('member.calendar.workouts.update');
    }
    $update_rest_period_route    = route('admin.calendar.rest-periods.update');
    $delete_rest_period_route    = route('admin.calendar.rest-periods.delete');

    if(Auth::user()->isAdmin()) {
        if($user) {
            $fullcalendar_users          = collect([$user]);
            $notify_route                = route('admin.members.calendar.notify', ['user' => $user->id]);
        } else {
            $fullcalendar_users          = $users;
            $notify_route                = route('admin.calendar.notify');
        }
    } else {
        $fullcalendar_users          = collect([Auth::user()]);
        $notify_route                = route('member.calendar.notify');
    }
@endphp




<div class="card border border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Calendrier
            </h4>
            <a 
                href="{{ $notify_route }}"
                class="btn btn-primary btn-sm"
            >
                <span>
                    Notifier les utilisateurs
                </span>
                <i class="fas fa-bell ms-2"></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez une vue d'ensemble sur les séances planifiées, les jours de repos et les séances à planifier.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content body --}}
    <div class="card-body">
        <div class="row mb-5">
            {{-- Actions --}}
            <div class="col-xl-3 col-xxl-4">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Séances à planifier</label>
                            <hr>
                            <ul class="list-group gap-2 draggable-container">
                                @foreach($fullcalendar_workouts_visible->where('date', null)->sortByDesc('id') as $workout)
                                    <li 
                                        class="list-group border border-primary p-2 draggable" 
                                        style="border-radius: 0; cursor: move;" 
                                        data-user="{{ $workout->user->id }}" 
                                        data-workout="{{ $workout->id }}"
                                        data-title="{{ $workout->user->lastname }} {{ $workout->user->firstname }}"
                                    >
                                        Séance #{{ $workout->id }} - {{ $workout->user->firstname }} {{ $workout->user->lastname }}
                                    </li>
                                @endforeach
        
                                <li 
                                    class="list-group no-draggable border border-primary p-2 align-items-center flex-row "
                                    style="border-radius: 0; display: @if($fullcalendar_workouts_visible->where('date', null)->count() == 0) flex @else none @endif;"                            
                                >
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <span>
                                        Aucune séance
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <hr>
        
                        @if(Auth::user()->isAdmin())
                            <a 
                                href="javascript:void(0);" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addWorkout" 
                                class="btn btn-primary w-100 d-flex align-items-center justify-content-center mb-3"
                                title="Ajouter une séance"
                            >
                                <span>
                                    Ajouter une séance
                                </span>
                                <i class="fas fa-plus ms-2"></i>
                            </a>
                            <a 
                                href="javascript:void(0);" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addRestPeriod" 
                                class="btn btn-secondary w-100 d-flex align-items-center justify-content-center "
                                title="Ajouter des repos"
                            >
                                <span>
                                    Ajouter des repos
                                </span>
                                <i class="fas fa-plus ms-2"></i>
                            </a>
                        @else 
                            @php    
                                $nbr_sessions = 0;
                                if(Auth::user()->hasCurrentPlan()) {
                                    $nbr_sessions += Auth::user()->currentPlan->sessions_left;
                                }
                                if(Auth::user()->first_session) {
                                    $nbr_sessions++;
                                }
                            @endphp
        
                            @if($nbr_sessions > 0)
                                <div class="alert alert-success">
                                    Actuellement vous avez {{ $nbr_sessions }} séances restantes à planifier.
                                </div>
                                <hr/>
                                <a 
                                    href="{{ route('member.calendar.workouts.add') }}" 
                                    class="btn btn-primary w-100 d-flex align-items-center justify-content-center mb-3"
                                    title="Ajouter une séance"
                                >
                                    <span>
                                        Ajouter une séance
                                    </span>
                                    <i class="fas fa-plus ms-2"></i>
                                </a>
                            @else 
                                <div class="alert alert-secondary">
                                    Vous n'avez plus de séances restantes à planifier, n'hésitez pas à renouveler votre abonnement ou à prendre des séances à l'unité.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            {{-- /Actions --}}
        
            {{-- Calendrier --}}
            <div class="col">
                <div 
                    id="calendar" 
                    class="app-fullcalendar"

                    data-update_workout_route="{{ $update_workout_route }}"
                    data-update_rest_period_route="{{ $update_rest_period_route }}"
                    data-delete_rest_period_route="{{ $delete_rest_period_route }}"

                    data-fullcalendar_workouts_visible="{{ $fullcalendar_workouts_visible }}"
                    data-fullcalendar_workouts_locked="{{ $fullcalendar_workouts_locked }}"
                    data-fullcalendar_rest_periods="{{ $fullcalendar_rest_periods }}"

                    data-fullcalendar_users="{{ $fullcalendar_users }}"
                    data-is_administrator = "{{ Auth::user()->isAdmin() }}"
                    data-user_id = "{{ Auth::user()->id }}"
                >
                </div>
            </div>
            {{-- /Calendrier --}}
        </div>
    </div>
    {{-- /Content body --}}


    {{-- Card Datatable --}}
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <div class="card border border-primary">
                    {{-- Content Header --}}
                    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
                        <div class="card-title d-flex justify-content-between w-100 align-items-center">
                            <h4 class="mb-0">
                                Liste des séances
                            </h4>
                        </div>
                        <div class="card-description">
                            <p class="text-muted  mb-0 font-weight-light">
                                Retrouvez ici la liste des séances planifiées et non planifiées.
                            </p>
                        </div>
                    </div>
                    {{-- /Content Header --}}

                    {{-- Content Body --}}
                    <div class="card-body">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        ID
                                    </th>
                                    <th scope="col">
                                        Statut
                                    </th>
                                    @if(Auth::user()->isAdmin())
                                        <th scope="col">
                                            <span>
                                                Membre
                                            </span>
                                            <i class="fas fa-user  ms-2"></i>
                                        </th>
                                    @endif
                                    <th scope="col">
                                        Obtention
                                    </th>
                                    <th scope="col">
                                        <span>
                                            Date
                                        </span>
                                        <i class="fas fa-calendar-alt ms-2"></i>
                                    </th>
                                    @if(Auth::user()->isAdmin())
                                        <th>
                                            Actions
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workouts_visible->sortByDesc('id') as $workout)
                                    <tr data-workout-id="{{ $workout->id }}">

                                        {{-- ID - DONE --}}
                                        <td>
                                            <strong>
                                                {{ $workout->id }}
                                            </strong>
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
                                        @if(Auth::user()->isAdmin())
                                            <td>
                                                <a href="{{ route('admin.members.edit', $workout->user) }}" class="text-decoration-underline">
                                                    {{ $workout->user->firstname }} {{ $workout->user->lastname }}
                                                </a>
                                            
                                            </td>
                                        @endif

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
                                        @if(Auth::user()->isAdmin())
                                            <td>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <a 
                                                        href="{{ route('admin.calendar.workouts.soft-delete', ['user' => $workout->user->id, 'workout' => $workout->id]) }}"
                                                        class="btn btn-danger btn-sm warning-row"
                                                        title="Supprimer la séance"
                                                    >
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                    
                                                    @if($workout->date && $workout->date < Carbon\Carbon::now())
                                                        @if($workout->status == 1)
                                                            <a 
                                                                href="{{ route('admin.calendar.workouts.undone', ['user' => $workout->user->id, 'workout' => $workout->id]) }}"
                                                                class="btn btn-warning btn-sm"
                                                                title="Marquer comme non faite"
                                                            >
                                                                <i class="fas fa-undo"></i>
                                                            </a>
                                                        @else 
                                                            
                                                            <a 
                                                                href="{{ route('admin.calendar.workouts.done', ['user' => $workout->user->id, 'workout' => $workout->id]) }}"
                                                                class="btn btn-success btn-sm"
                                                                title="Marquer comme faite"
                                                            >
                                                                <i class="fas fa-check"></i>
                                                            </a>
                    
                                                        @endif
                                                        
                                                    @endif
                                                </div>
                                            </td>
                                        @endif


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- /Content Body --}}
                </div>
            </div>
        </div>
    </div>
    {{-- /Card Datatable --}}
</div>





@if(Auth::user()->isAdmin())
    @include("admin.calendar._elements.workouts_modal")
    @include("admin.calendar._elements.rest_periods_modal")
@else 

@endif





