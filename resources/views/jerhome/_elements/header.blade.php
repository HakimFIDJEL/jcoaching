{{-- Bootstrap header --}}

<nav class="navbar navbar-expand-lg navbar-dark border-bottom border-primary pb-3">
    {{-- Home Link --}}
    <a class="navbar-brand" href="{{ route('main.index') }}">
        @if($company_logo)
            <img 
                src="{{ asset('storage/' . str_replace('public/', '', $company_logo)) }}"
                alt="Logo"
                style="max-height: 50px; max-width: 50px;"
                title="{{ $company_name }}"
            >
        @else
            {{ $company_name }}
        @endif
    </a>

    {{-- Toggler --}}
    <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" 
        aria-expanded="false" 
        aria-label="Toggle navigation"
    >
        {{-- Toggler Icon --}}
        <i class="la la-bars"></i>
    </button>

    {{-- Navbar Collapse --}}
    <div class="collapse navbar-collapse  d-flex justify-content-center align-items-center" id="navbarSupportedContent">
        {{-- Navbar Links --}}
        <ul class="navbar-nav nav d-flex justify-content-center align-items-center gap-3">

            <li class="nav-item">
                <a 
                    href="{{ route('main.index') }}" 
                    style="text-transform: uppercase;"
                    @if(Route::currentRouteName() == 'main.index') 
                        class="btn btn-link fw-bold text-primary"   
                    @else
                        class="btn btn-link fw-bold" 
                    @endif
                >
                    Accueil
                </a>
            </li>

            <li class="nav-item">
                <a 
                    href="{{ route('main.about') }}" 
                    style="text-transform: uppercase;"
                    @if(Route::currentRouteName() == 'main.about') 
                        class="btn btn-link fw-bold text-primary"
                    @else
                        class="btn btn-link fw-bold"
                    @endif
                >
                    À propos
                </a>
            </li>

            <li class="nav-item">
                <a 
                    href="{{ route('main.media') }}" 
                    style="text-transform: uppercase;"
                    @if(Route::currentRouteName() == 'main.media') 
                        class="btn btn-link fw-bold text-primary"
                    @else
                        class="btn btn-link fw-bold"
                    @endif
                >
                    Galerie
                </a>
            </li>

            <li class="nav-item">
                <a 
                    class="btn btn-link fw-bold" 
                    href="{{ route('main.pricings') }}" 
                    style="text-transform: uppercase;"
                    @if(Route::currentRouteName() == 'main.pricings') 
                        class="btn btn-link fw-bold text-primary"
                    @else
                        class="btn btn-link fw-bold"
                    @endif
                >
                    Tarifs
                </a>
            </li>

            <li class="nav-item">
                <a 
                    href="{{ route('main.contact') }}" 
                    style="text-transform: uppercase;"
                    @if(Route::currentRouteName() == 'main.contact') 
                        class="btn btn-link fw-bold text-primary"
                    @else
                        class="btn btn-link fw-bold"    
                    @endif    
                >
                    Contact
                </a>
            </li>
        </ul>
    </div>

    {{-- Button Navbar --}}
    <ul class="button-navbar mb-0">
        <li>
            <a 
                href="{{ route('auth.login') }}" 
                class="button text-decoration-none"
                title="Connexion"    
            >
                Connexion
            </a>
        </li>
    </ul>
</nav>
