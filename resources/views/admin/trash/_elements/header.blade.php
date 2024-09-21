{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Corbeille</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}

{{-- Breadcrumbs --}}    
<div class="d-flex align-items-center mb-5 gap-5 justify-content-between">
    <div class="col d-flex align-items-center gap-3 p-0 flex-wrap">

        {{-- Utilisateurs --}}
        <a 
            href="{{ route('admin.trash.users.index') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.users.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Utilisateurs
            </span>
            <i class="flaticon-381-user-9 ms-2"></i>
        </a>

        

        {{-- Plans --}}
        <a 
            href="{{ route('admin.trash.plans.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.plans.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Abonnements
            </span>
            <i class="fas fa-credit-card ms-2"></i>
        </a>

         {{-- Témoignages --}}
         <a 
            href="{{ route('admin.trash.feedbacks.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.feedbacks.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Témoignages
            </span>
            <i class="fas fa-comment-dots ms-2"></i>
        </a>

        {{-- Contacts --}}
        <a 
            href="{{ route('admin.trash.contacts.index') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.contacts.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Contacts
            </span>
            <i class="fas fa-envelope ms-2"></i>
        </a>

        {{-- Médias --}}
        <a 
            href="{{ route('admin.trash.medias.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.medias.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Médias
            </span>
            <i class="fas fa-photo-video ms-2"></i>
        </a>

        {{-- Faqs --}}
        <a 
            href="{{ route('admin.trash.faqs.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.faqs.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Faqs
            </span>
            <i class="fas fa-question-circle ms-2"></i>
        </a>

        

        {{-- Tarifs --}}
        <a 
            href="{{ route('admin.trash.pricings.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.pricings.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Tarifs
            </span>
            <i class="fas fa-euro-sign ms-2"></i>
        </a>

        {{-- Reductions --}}
        <a 
            href="{{ route('admin.trash.reductions.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.reductions.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Réductions
            </span>
            <i class="fas fa-percent ms-2"></i>
        </a>

        {{-- Séances --}}
        <a 
            href="{{ route('admin.trash.workouts.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.workouts.index') btn-primary @else btn-outline-primary @endif"
        >
            <span>
                Séances
            </span>
            <i class="fas fa-dumbbell ms-2"></i>
        </a>

    </div>

</div>
{{-- /Breadcrumbs --}}