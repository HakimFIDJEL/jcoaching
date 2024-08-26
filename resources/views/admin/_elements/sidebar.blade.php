<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Utilisateurs</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.members.index') }}">Membres</a></li>
                    <li><a href="{{ route('admin.admins.index') }}">Administrateurs</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.feedbacks.index') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Témoignages</span>
                </a>
            </li>
        </ul>

        <hr>

        <div class="copyright">
            <p><strong> {{  env('APP_NAME')  }}  </strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>