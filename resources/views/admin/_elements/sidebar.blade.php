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
                <a href="widget-basic.html" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Lien non déroulant</span>
                </a>
            </li>
        </ul>

        <hr>

        <div class="copyright">
            <p><strong> {{  env('APP_NAME')  }}  </strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>