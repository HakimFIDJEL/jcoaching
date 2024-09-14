<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                </div>


                <ul class="navbar-nav header-right">




                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="header-info me-3">
                                <span class="fs-16 font-w600 text-white">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </span>
                                <small class="text-end fs-14 font-w400">
                                    {{ Str::title(Auth::user()->role) }}
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