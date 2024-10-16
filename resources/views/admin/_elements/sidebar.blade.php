<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            {{-- Tableau de bord --}}
            <li class="{{ Request::is('admin') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.index') }}" 
                    class="ai-icon {{ Request::is('admin') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Tableau de bord"
                >
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Tableau de bord</span>
                </a>                
            </li>

            {{-- Utilisateurs --}}
            <li class="{{ Request::is('admin/admins*') || Request::is('admin/members*') ? 'mm-active' : '' }}">
                <a 
                    class="has-arrow ai-icon" 
                    href="javascript:void()" 
                    aria-expanded="false"
                    title="Utilisateurs"
                >
                    <i class="flaticon-381-user-9"></i>
                    <span class="nav-text">Utilisateurs</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.members.index') }}" class="{{ Request::is('admin/members*') ? 'mm-active' : '' }}">
                            Membres
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.admins.index') }}" class="{{ Request::is('admin/admins*') ? 'mm-active' : '' }}">
                            Administrateurs
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Abonnements --}}
            <li class="{{ Request::is('admin/plans*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.plans.index') }}" 
                    class="ai-icon {{ Request::is('admin/plans*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Abonnements"
                >
                    <i class="fa fa-credit-card"></i>
                    <span class="nav-text">Abonnements</span>
                </a>                
            </li>

            {{-- Témoignages --}}
            {{-- <li class="{{ Request::is('admin/feedbacks*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.feedbacks.index') }}" 
                    class="ai-icon {{ Request::is('admin/feedbacks*') ? 'mm-active' : '' }}" 
                    aria-expanded="false" 
                    title="Témoignages"
                >
                    <i class="fas fa-comment-dots "></i>
                    <span class="nav-text">Témoignages</span>
                </a>                
            </li> --}}

            {{-- Contact --}}
            <li class="{{ Request::is('admin/contacts*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.contacts.index') }}" 
                    class="ai-icon {{ Request::is('admin/contacts*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Contacts"
                >
                    <i class="fas fa-envelope"></i>
                    <span class="nav-text">Contacts</span>
                </a>                
            </li>

            {{-- Médias --}}
            {{-- <li class="{{ Request::is('admin/medias*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.medias.index') }}" 
                    class="ai-icon {{ Request::is('admin/medias*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Médias"
                >
                    <i class="fas fa-photo-video"></i>
                    <span class="nav-text">Médias</span>
                </a>                
            </li> --}}

            {{-- Faqs --}}
            {{-- <li class="{{ Request::is('admin/faqs*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.faqs.index') }}" 
                    class="ai-icon {{ Request::is('admin/faqs*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Faqs"
                >
                    <i class="fas fa-question-circle"></i>
                    <span class="nav-text">Faqs</span>
                </a>                
            </li> --}}

            {{-- Tarifs --}}
            {{-- <li class="{{ Request::is('admin/pricings*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.pricings.index') }}" 
                    class="ai-icon {{ Request::is('admin/pricings*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Tarifs"
                >
                    <i class="flaticon-381-price-tag"></i>
                    <span class="nav-text">Tarifs</span>
                </a>                
            </li> --}}

            {{-- Code de réduction --}}
            <li class="{{ Request::is('admin/reductions*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.reductions.index') }}" 
                    class="ai-icon {{ Request::is('admin/reductions*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Réductions"
                >
                    <i class="fa fa-percent"></i>
                    <span class="nav-text">Réductions</span>
                </a>                
            </li>

            

            {{-- Site internet --}}
            <li class="{{ Request::is('admin/feedbacks*') || Request::is('admin/medias*') || Request::is('admin/faqs*') || Request::is('admin/pricings*') ? 'mm-active' : '' }}">
                <a 
                    class="has-arrow ai-icon" 
                    href="javascript:void()" 
                    aria-expanded="false"
                    title="Site internet"
                >
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Site internet</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.feedbacks.index') }}" class="{{ Request::is('admin/feedbacks*') ? 'mm-active' : '' }}">
                            Témoignages
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.medias.index') }}" class="{{ Request::is('admin/medias*') ? 'mm-active' : '' }}">
                            Médias
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faqs.index') }}" class="{{ Request::is('admin/faqs*') ? 'mm-active' : '' }}">
                            Faqs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pricings.index') }}" class="{{ Request::is('admin/pricings*') ? 'mm-active' : '' }}">
                            Tarifs
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Ordres d'achats --}}
            <li class="{{ Request::is('admin/orders*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.orders.index') }}" 
                    class="ai-icon {{ Request::is('admin/orders*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Ordres d'achats"
                >
                    <i class="flaticon-381-price-tag"></i>
                    <span class="nav-text">Ordres d'achats</span>
                </a>
            </li>

            {{-- Calendrier --}}
            <li class="{{ Request::is('admin/calendar*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.calendar.index') }}" 
                    class="ai-icon {{ Request::is('admin/calendar*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Calendrier"
                >
                    <i class="fa fa-calendar-alt"></i>
                    <span class="nav-text">Calendrier</span>
                </a>                
            </li>

            <hr>

            @php
                $total_trash = 0;
                    
                $total_trash += $trash_members;
                $total_trash += $trash_admins;
                $total_trash += $trash_contacts;
                $total_trash += $trash_faqs;
                $total_trash += $trash_feedbacks;
                $total_trash += $trash_medias;
                $total_trash += $trash_plans;
                $total_trash += $trash_pricings;
                $total_trash += $trash_reductions;
                $total_trash += $trash_workouts;


            @endphp

            {{-- Corbeille --}}
            <li class="{{ Request::is('admin/trash*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.trash.members.index') }}" 
                    class="ai-icon {{ Request::is('admin/trash*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Corbeille"
                >
                    <i class="fa fa-trash-alt"></i>
                    <span class="nav-text">
                        Corbeille
                        @if ($total_trash > 0)
                            <span class="badge badge-danger ml-2">{{ $total_trash }}</span>
                        @endif
                    </span>
                </a>
            </li>
        </ul>

        <hr>

        <div class="copyright">
            <p><strong> {{  env('APP_NAME')  }}  </strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>