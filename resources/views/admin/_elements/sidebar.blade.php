<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ Request::is('admin/admins*') ? 'mm-active' : '' }}">
                <a 
                    class="has-arrow ai-icon" 
                    href="javascript:void()" 
                    aria-expanded="false"
                    title="Utilisateurs"
                >
                    <i class="flaticon-381-networking"></i>
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
        </ul>

        <hr>

        <div class="copyright">
            <p><strong> {{  env('APP_NAME')  }}  </strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>