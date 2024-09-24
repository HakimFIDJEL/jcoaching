{{-- Add Plan Modal --}}
<div class="modal fade" id="addPlan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un abonnement à {{ $member->firstname }} {{ $member->lastname }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form action="{{ route('admin.members.plans.add', ['user' => $member]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pricing_id" class="form-label">
                            Tarif
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <select 
                            class="default-select form-control wide mb-3" 
                            name="pricing_id" 
                            id="pricing_id"
                            required 
                            autofocus
                        >
                            @foreach($pricings as $pricing)
                                <option value="{{ $pricing->id }}">
                                    {{ $pricing->title }} - {{ $pricing->price }} € - {{ $pricing->nbr_sessions }} séances
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nutrition_option" class="form-label">
                            Option nutrition ?
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <select 
                            class="default-select form-control wide mb-3" 
                            name="nutrition_option" 
                            id="nutrition_option"
                            required
                        >
                            <option value="0">
                                Non
                            </option>
                            <option value="1">
                                Oui
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">
                            Date de début
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input 
                            type="date" 
                            class="form-control" 
                            name="start_date" 
                            id="start_date"
                            required
                        />
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

{{-- Update Plan Modal --}}
@if($member->hasCurrentPlan())
    <div class="modal fade" id="updatePlan">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'abonnement de {{ $member->firstname }} {{ $member->lastname }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form action="{{ route('admin.members.plans.update', ['user' => $member]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pricing_id" class="form-label">
                                Tarif
                            </label>
                            <select 
                                class="default-select form-control wide mb-3" 
                                name="pricing_id" 
                                id="pricing_id"
                                required 
                                autofocus
                            >
                                @foreach($pricings as $pricing)
                                    <option value="{{ $pricing->id }}" @if($pricing->id == $member->currentPlan->pricing_id) selected @endif>
                                        {{ $pricing->title }} - {{ $pricing->price }} € - {{ $pricing->nbr_sessions }} séances
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nutrition_option" class="form-label">
                                Option nutrition ?
                            </label>
                            <select 
                                class="default-select form-control wide mb-3" 
                                name="nutrition_option" 
                                id="nutrition_option"
                                required
                            >
                                <option value="0" @if($member->currentPlan->nutrition_option == 0) selected @endif>
                                    Non
                                </option>
                                <option value="1" @if($member->currentPlan->nutrition_option == 1) selected @endif>
                                    Oui
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="expiration_date" class="form-label">
                                Date d'expiration
                            </label>
                            <input 
                                type="date" 
                                class="form-control" 
                                name="expiration_date" 
                                id="expiration_date"
                                required
                                value="{{ \Carbon\Carbon::parse($member->currentPlan->expiration_date)->format('Y-m-d') }}"
                            >
                        </div>
                        <div class="mb-3">
                            <label for="sessions_left" class="form-label">
                                Nombre de séances restantes
                            </label>
                            <input 
                                type="number" 
                                class="form-control" 
                                name="sessions_left" 
                                id="sessions_left"
                                required
                                value="{{ $member->currentPlan->sessions_left }}"
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
@endif
