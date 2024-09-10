
<div class="card border border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Notifier les utilisateurs
            </h4>
            <a 
                @if(Auth::user()->isAdmin())
                    @if($member)
                        href="{{ route('admin.members.calendar', ['user' => $member]) }}"
                    @else 
                        href="{{ route('admin.calendar.index') }}"
                    @endif
                @else
                    href="{{ route('member.calendar.index') }}"
                @endif
                class="btn btn-primary btn-sm"
            >
                <i class="fas fa-arrow-left me-2"></i>
                <span>
                    Retour au calendrier
                </span>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis ce tableau, sélectionnez les séances pour lesquelles vous souhaitez notifier les utilisateurs, à noter qu'une fois le formulaire soumis, les séances affichées (sélectionnées ou non) ne pourront plus être notifiées à nouveau.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    <div class="card-body">
        {{-- Table --}}
        <div class="row mb-5">

            <form 
                @if(Auth::user()->isAdmin())
                    action="{{ route('admin.calendar.notify-post') }}"
                @else
                    action="{{ route('member.calendar.notify-post') }}"
                @endif
                method="POST"
                class="w-100"
            >

            @csrf

                <table class="table">
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
                            <th>
                                <div class="custom-control custom-switch">
                                    <input 
                                        class="custom-control-input"
                                        type="checkbox"
                                        id="workout-all"
                                    />
                                    <label 
                                        for="workout-all"
                                        class="custom-control-label"
                                    >
                                    Notifier
                                    </label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workouts_not_notified->sortByDesc('id') as $workout)
                            <tr>
                                <td>
                                    <strong>
                                        #{{ $workout->id }}
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
                                @if(Auth::user()->isAdmin())
                                    <td>
                                        <a href="{{ route('admin.members.edit', $workout->user) }}" class="text-decoration-underline">
                                            {{ $workout->user->firstname }} {{ $workout->user->lastname }}
                                        </a>
                                    
                                    </td>
                                @endif
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
                                    <div class="custom-control custom-switch">
                                        <input 
                                            class="custom-control-input workout"
                                            type="checkbox"
                                            name="workouts[]"
                                            value="{{ $workout->id }}"
                                            id="workout-{{ $workout->id }}"
                                        />
                                        <label 
                                            for="workout-{{ $workout->id }}"
                                            class="custom-control-label"
                                        >
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($workouts_not_notified->count() == 0)
                            <tr>
                                <td colspan="6" class="text-center">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <span>
                                            Aucune séance n'est disponible pour notification.
                                        </span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <button 
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    <span>
                        Notifier les utilisateurs
                    </span>
                    <i class="fas fa-bell ms-2"></i>
                </button>

            </form>


        </div>
        {{-- /Table --}}
    </div>


</div>







