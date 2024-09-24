{{-- Breadcrumbs --}}
    
<div class="d-flex align-items-center mb-5 gap-5 justify-content-between">
    <div class="col d-flex align-items-center gap-3 p-0 flex-wrap">

        <a 
            href="{{ route('admin.reductions.edit', ['reduction' => $reduction]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.reductions.edit') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Informations
            </span>
            <i class="fas fa-info-circle ms-2"></i>
        </a>
        <a 
            href="{{ route('admin.reductions.members', ['reduction' => $reduction]) }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.reductions.members') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Membres
            </span>
            <i class="fas fa-users ms-2"></i>
        </a>
    </div>
    <div class="col-2 d-flex justify-content-end p-0">
        <a href="{{ route('admin.reductions.index') }}" class="btn btn-secondary ">
            <i class="fa fa-arrow-left me-2"></i>
            <span>
                Retour
            </span>
        </a>
    </div>

</div>
{{-- /Breadcrumbs --}}