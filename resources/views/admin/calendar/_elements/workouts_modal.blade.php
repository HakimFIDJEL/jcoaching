{{-- Add Workout Modal --}}
<div class="modal fade" id="addWorkout">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une séance à {{ $member->firstname }} {{ $member->lastname }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form action="{{ route('admin.calendar.workouts.add', ['user' => $member]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nbr_sessions" class="form-label">
                            Nombre de séances
                        </label>
                        <input 
                            type="number" 
                            class="form-control" 
                            name="nbr_sessions" 
                            id="nbr_sessions"
                            required 
                            autofocus
                            value="1"
                        >
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>
                                    Ajouter
                                </span>
                                <i class="fas fa-plus ms-2"></i>
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">
                                <span>
                                    Fermer
                                </span>
                                <i class="fas fa-times ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Add Plan Modal --}}
<div class="modal fade" id="updateWorkout">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la séance {{-- ID de la séance --}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form action="">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Input
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="" 
                            id=""
                            required
                        >
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>
                                    Modifier
                                </span>
                                <i class="fas fa-edit ms-2"></i>
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">
                                <span>
                                    Fermer
                                </span>
                                <i class="fas fa-times ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>