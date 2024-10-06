<header class="bg-transparent py-4 mb-5">
    <div class="container d-flex justify-content-between align-items-center" style="max-width: 100%;">
        <a 
            href="{{ route('main.index') }}" 
            class="navbar-brand"
        >
            @if($company_logo)
                <img 
                    src="{{ Storage::url($company_logo) }}"
                    alt="Logo"
                    style="max-height: 50px;"
                >
            @else
                {{ $company_name }}
            @endif
        </a>
        <a href="{{ route('main.index') }}" class="button btn">Retour au site</a>
    </div>
</header>