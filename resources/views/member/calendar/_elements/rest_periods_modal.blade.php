{{-- Add Workout Modal --}}
<div class="modal fade" id="addRestPeriod">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une période de repos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form action="{{ route('admin.calendar.rest-periods.add') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nbr_sessions" class="form-label">
                            Début de la période de repos
                        </label>
                        <input 
                            type="datetime-local" 
                            class="form-control" 
                            name="start_date" 
                            id="start_date"
                            required 
                            autofocus
                        >
                    </div>
                    <div class="mb-3">
                        <label for="nbr_sessions" class="form-label">
                            Fin de la période de repos
                        </label>
                        <input 
                            type="datetime-local" 
                            class="form-control" 
                            name="end_date" 
                            id="end_date"
                            required 
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

