<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ Request::is('member') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('member.index') }}" 
                    class="ai-icon {{ Request::is('member') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Tableau de bord"
                >
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Tableau de bord</span>
                </a>                
            </li>

            <li class="{{ Request::is('member/plans*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('member.plans.index') }}" 
                    class="ai-icon {{ Request::is('member/plans*') ? 'mm-active' : '' }}" 
                    aria-expanded="false"
                    title="Abonnements"
                >
                    <i class="fa fa-credit-card"></i>
                    <span class="nav-text">Abonnements</span>
                </a>                
            </li>

            <li class="{{ Request::is('member/calendar*') ? 'mm-active' : '' }}">
                <a 
                    href="{{ route('member.calendar.index') }}" 
                    class="ai-icon {{ Request::is('member/calendar*') ? 'mm-active' : '' }}" 
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