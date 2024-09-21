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

        @php
            
            // 'trash_members' => $trash_members,
            //         'trash_admins' => $trash_admins,
            //         'trash_contacts' => $trash_contacts,
            //         'trash_faqs' => $trash_faqs,
            //         'trash_feedbacks' => $trash_feedbacks,
            //         'trash_medias' => $trash_medias,
            //         'trash_plans' => $trash_plans,
            //         'trash_pricings' => $trash_pricings,
            //         'trash_reductions' => $trash_reductions,
            //         'trash_workouts' => $trash_workouts,
        @endphp

        {{-- Membres --}}
        <a 
            href="{{ route('admin.trash.members.index') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.members.index') btn-primary @else btn-outline-primary @endif"
        >
            @if($trash_members > 0)
                <span class="badge badge-danger mr-2">{{ $trash_members }}</span>   
            @endif
            <span>
                Membres
            </span>
            <i class="fa fa-users ms-2"></i>
        </a>

        {{-- Administrateurs --}}
        <a 
            href="{{ route('admin.trash.admins.index') }}" 
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.admins.index') btn-primary @else btn-outline-primary @endif"
        >
            @if($trash_admins > 0)
                <span class="badge badge-danger mr-2">{{ $trash_admins }}</span>
            @endif
            <span>
                Administrateurs
            </span>
            <i class="fa fa-user-shield ms-2"></i>

        </a>
        

        {{-- Plans --}}
        <a 
            href="{{ route('admin.trash.plans.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.plans.index') btn-primary @else btn-outline-primary @endif"
        >
            @if($trash_plans > 0)
                <span class="badge badge-danger mr-2">{{ $trash_plans }}</span>
            @endif
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
            @if($trash_feedbacks > 0)
                <span class="badge badge-danger mr-2">{{ $trash_feedbacks }}</span>
            @endif
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
            @if($trash_contacts > 0)
                <span class="badge badge-danger mr-2">{{ $trash_contacts }}</span>
            @endif
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
            @if($trash_medias > 0)
                <span class="badge badge-danger mr-2">{{ $trash_medias }}</span>
            @endif
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
            @if($trash_faqs > 0)
                <span class="badge badge-danger mr-2">{{ $trash_faqs }}</span>
            @endif
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
            @if($trash_pricings > 0)
                <span class="badge badge-danger mr-2">{{ $trash_pricings }}</span>
            @endif
            <span>
                Tarifs
            </span>
            <i class="flaticon-381-price-tag ms-2"></i>
        </a>

        {{-- Reductions --}}
        <a 
            href="{{ route('admin.trash.reductions.index') }}"
            class="btn d-flex align-items-center @if(Route::currentRouteName() == 'admin.trash.reductions.index') btn-primary @else btn-outline-primary @endif"
        >
            @if($trash_reductions > 0)
                <span class="badge badge-danger mr-2">{{ $trash_reductions }}</span>
            @endif
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
            @if($trash_workouts > 0)
                <span class="badge badge-danger mr-2">{{ $trash_workouts }}</span>
            @endif
            <span>
                Séances
            </span>
            <i class="fas fa-dumbbell ms-2"></i>
        </a>

    </div>

</div>
{{-- /Breadcrumbs --}}