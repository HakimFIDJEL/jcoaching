<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ Request::is('admin') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.index') }}" 
                    class="ai-icon {{ Request::is('admin') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Tableau de bord"
                >
                    <i class="flaticon-381-network"></i>
                    <span class="nav-text">Tableau de bord</span>
                </a>                
            </li>
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
                    <li><a href="{{ route('admin.members.index') }}">Membres</a></li>
                    <li><a href="{{ route('admin.admins.index') }}">Administrateurs</a></li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/feedbacks*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.feedbacks.index') }}" 
                    class="ai-icon {{ Request::is('admin/feedbacks*') ? 'mm-active' : '' }}" 
                    aria-expanded="false" 
                    title="Témoignages"
                >
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Témoignages</span>
                </a>                
            </li>
            <li class="{{ Request::is('admin/contacts*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.contacts.index') }}" 
                    class="ai-icon {{ Request::is('admin/contacts*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Contacts"
                >
                    <i class="flaticon-381-tab"></i>
                    <span class="nav-text">Contacts</span>
                </a>                
            </li>
            <li class="{{ Request::is('admin/medias*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.medias.index') }}" 
                    class="ai-icon {{ Request::is('admin/medias*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Médias"
                >
                    <i class="flaticon-381-photo"></i>
                    <span class="nav-text">Médias</span>
                </a>                
            </li>
            <li class="{{ Request::is('admin/faqs*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.faqs.index') }}" 
                    class="ai-icon {{ Request::is('admin/faqs*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Faqs"
                >
                    <i class="flaticon-381-notepad"></i>
                    <span class="nav-text">Faqs</span>
                </a>                
            </li>
            <li class="{{ Request::is('admin/pricings*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('admin.pricings.index') }}" 
                    class="ai-icon {{ Request::is('admin/pricings*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Tarifs"
                >
                    <i class="flaticon-381-price-tag"></i>
                    <span class="nav-text">Tarifs</span>
                </a>                
            </li>
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
        </ul>

        <hr>

        <div class="copyright">
            <p><strong> {{  env('APP_NAME')  }}  </strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>