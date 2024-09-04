

{{-- Calendrier --}}
<div class="row mb-5">

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

               

                
                    <div class="mb-3">
                        <label class="form-label">Séances à planifier</label>

                        <ul class="list-group gap-2 draggable-container">
                            @foreach($fullcalendar_workouts->where('date', null)->sortByDesc('id') as $workout)
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
                                style="border-radius: 0; display: @if($fullcalendar_workouts->where('date', null)->count() == 0) flex @else none @endif;"
                                
                            >
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <span>
                                    Aucune séance
                                </span>
                            </li>
                        </ul>


                    </div>
                    <hr>


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
            </div>
        </div>
    </div>

    <div class="col">
        <div 
            id="calendar" 
            class="app-fullcalendar"
            data-update_workout_route="{{ route('admin.calendar.workouts.update') }}"
            data-update_rest_period_route="{{ route('admin.calendar.rest-periods.update') }}"
            data-delete_rest_period_route="{{ route('admin.calendar.rest-periods.delete') }}"
            data-fullcalendar_workouts="{{ $fullcalendar_workouts }}"
            data-fullcalendar_rest_periods="{{ $fullcalendar_rest_periods }}"
        >

    
        </div>
    </div>
</div>
{{-- /Calendrier --}}

@if(Auth::user()->isAdmin())
<hr>

<div class="row mt-5">
    <div class="col">


        <div class="card border border-primary">
            <div class="card-header d-flex flex-column align-items-start border-bottom border-primary">
                <div class="card-title d-flex justify-content-between align-items-center w-100">
                    <h4>
                        <span>
                            Liste des séances
                        </span>
                        <i class="fas fa-dumbbell ms-2"></i>
                    </h4>
                    <a href="" class="btn btn-primary mb-3" >
                        Actualiser le tableau
                    </a>
                </div>
                <div class="card-description">

                    <div class="mb-3 custom-control custom-switch">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="filter"
                        />
                        <label for="filter" class="custom-control-label">
                            Masquer les séances faites
                        </label>

                    </div>
                </div>
            </div>
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
                            <th scope="col">
                                <span>
                                    Membre
                                </span>
                                <i class="fas fa-user  ms-2"></i>
                            </th>
                            <th scope="col">
                                Obtention
                            </th>
                            <th scope="col">
                                <span>
                                    Date
                                </span>
                                <i class="fas fa-calendar-alt ms-2"></i>
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workouts->sortByDesc('id') as $workout)
                            <tr data-status="{{ $workout->status }}">
                                <td>
                                    <strong>
                                        {{ $workout->id }}
                                    </strong>
                                </td>
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
                                <td>
                                    <a href="{{ route('admin.members.edit', $workout->user) }}" class="text-decoration-underline">
                                        {{ $workout->user->firstname }} {{ $workout->user->lastname }}
                                    </a>
                                </td>
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
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <a 
                                            href="{{ route('admin.calendar.workouts.soft-delete', ['user' => $workout->user->id, 'workout' => $workout->id]) }}"
                                            class="btn btn-danger btn-sm warning-row"
                                            title="Supprimer la séance"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
        
                                        @if($workout->date)
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


@endif




@include("admin.calendar._elements.calendar_modal")
@include("admin.calendar._elements.workouts_modal")
@include("admin.calendar._elements.rest_periods_modal")





