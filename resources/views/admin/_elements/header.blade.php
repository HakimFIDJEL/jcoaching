<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                </div>


                <ul class="navbar-nav header-right">


                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell bell-link" href="#">
                         <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M27 7.88883C27 5.18897 24.6717 3 21.8 3C17.4723 3 10.5277 3 6.2 3C3.3283 3 1 5.18897 1 7.88883V23.7776C1 24.2726 1.31721 24.7174 1.80211 24.9069C2.28831 25.0963 2.8473 24.9912 3.2191 24.6417C3.2191 24.6417 5.74629 22.2657 7.27769 20.8272C7.76519 20.3688 8.42561 20.1109 9.11591 20.1109H21.8C24.6717 20.1109 27 17.922 27 15.2221V7.88883ZM24.4 7.88883C24.4 6.53951 23.2365 5.44441 21.8 5.44441C17.4723 5.44441 10.5277 5.44441 6.2 5.44441C4.7648 5.44441 3.6 6.53951 3.6 7.88883V20.8272L5.4382 19.0989C6.4132 18.1823 7.73661 17.6665 9.11591 17.6665H21.8C23.2365 17.6665 24.4 16.5726 24.4 15.2221V7.88883ZM7.5 15.2221H17.9C18.6176 15.2221 19.2 14.6745 19.2 13.9999C19.2 13.3252 18.6176 12.7777 17.9 12.7777H7.5C6.7824 12.7777 6.2 13.3252 6.2 13.9999C6.2 14.6745 6.7824 15.2221 7.5 15.2221ZM7.5 10.3333H20.5C21.2176 10.3333 21.8 9.7857 21.8 9.11104C21.8 8.43638 21.2176 7.88883 20.5 7.88883H7.5C6.7824 7.88883 6.2 8.43638 6.2 9.11104C6.2 9.7857 6.7824 10.3333 7.5 10.3333Z" fill="var(--bs-body-color)"/>
                            </svg>
                            <span 
                                class="badge light rounded-circle" 
                                @if($unread_messages_view == 0) style="display:none;" @endif
                                id="unread-messages-count"
                            >
                                {{ $unread_messages_view }}
                            </span>
                        </a>
                    </li>

                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="header-info me-3">
                                <span class="fs-16 font-w600 text-white">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </span>
                                <small class="text-end fs-14 font-w400 d-flex align-items-center gap-1 justify-content-end">
                                    Administrateur
                                    <i class="fa fa-shield"></i>
                                </small>
                            </div>
                            @if(Auth::user()->pfp_path)
                                {{-- <img class="rounded-circle" style="aspect-ratio: 1/1" width="35"  alt=""> --}}
                                <img src="{{ asset('storage/' . str_replace('public/', '', Auth::user()->pfp_path)) }}" width="20" alt="{{ Auth::user()->lastname }}" />
                            @else 
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <span class="avatar-title bg-primary text-black rounded-circle p-1" style="font-size: 1rem;">
                                            {{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </a>

                        
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item ai-icon" href="{{ route('admin.admins.edit') }}">
                                <i class="fa fa-user me-2"></i>
                                <span>
                                    Profil
                                </span>
                            </a>
                            <a class="dropdown-item ai-icon" href="{{ route('admin.settings.index') }}">
                                <i class="fa fa-cog me-2"></i>
                                <span>
                                    Paramètres
                                </span>
                            </a>
                            <a class="dropdown-item ai-icon" href="{{ route('auth.logout') }}">
                                <i class="fa fa-power-off me-2"></i>
                                <span>
                                    Déconnexion
                                </span>
                            </a>
                        </div>
                    </li>



                </ul>
            </div>
        </nav>
    </div>
</div>