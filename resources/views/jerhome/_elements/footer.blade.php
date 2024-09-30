{{-- Boostrap footer --}}
<footer class="bg-primary text-black">
    <div class="container">
        <div class="row d-flex justify-content-between align-items-center py-4">
            <div class="col-md col-sm-6">
                <ul class="d-flex gap-3 mb-0">
                    @if($company_facebook)
                        <li><a href="{{ $company_facebook }}" target="_blank" class="text-black fs-20"><i class="la la-facebook"></i></a></li>
                    @endif

                    @if($company_twitter)
                        <li><a href="{{ $company_twitter }}" target="_blank"  class="text-black fs-20"><i class="la la-twitter"></i></a></li>
                    @endif

                    @if($company_instagram)
                        <li><a href="{{ $company_instagram }}" target="_blank" class="text-black fs-20"><i class="la la-instagram"></i></a></li>
                    @endif

                    @if($company_youtube)
                        <li><a href="{{ $company_youtube }}" target="_blank" class="text-black fs-20"><i class="la la-youtube"></i></a></li>
                    @endif

                    @if($company_linkedin)
                        <li><a href="{{ $company_linkedin }}" target="_blank" class="text-black fs-20"><i class="la la-linkedin"></i></a></li>
                    @endif
                </ul>
            </div>
            <div class="col-md col-sm-6">
                <div class="cp d-flex justify-content-end">
                    <span>
                        {{ $company_name ?? env('APP_NAME') }}
                        © {{ date('Y') }} All Right Reserved 
                    </span>
                </div>
            </div>
        </div>

        {{-- TODO : Rajouter toutes les pages + mentions légales --}}
        <div class="row d-flex justify-content-between py-4">
            {{-- Logo --}}
            @if($company_logo)
                <div class="col-md col-sm-2 pr-5 pb-5">
                    <img 
                        src="{{ asset('storage/' . str_replace('public/', '', $company_logo)) }}"
                        alt="Logo"
                        title="{{ $company_name }}"
                        class="img-fluid"
                    >
                </div>
            @endif

            {{-- Links --}}
            <div class="col-md col-sm-5">

                {{-- Small title --}}
                <h6 class="text-black mb-4">Liens rapides</h6>

                {{-- Links --}}

                <ul class="d-flex gap-3 mb-0 flex-column">
                    <li><a href="{{ route('main.index') }}" class="text-black fw-light">Accueil</a></li>
                    <li><a href="{{ route('main.about') }}" class="text-black fw-light">À propos</a></li>
                    <li><a href="{{ route('main.media') }}" class="text-black fw-light">Galerie</a></li>
                    <li><a href="{{ route('main.pricings') }}" class="text-black fw-light">Tarifs</a></li>
                    <li><a href="{{ route('main.contact') }}" class="text-black fw-light">Contact</a></li>
                    <li><a href="{{ route('main.account') }}" class="text-black fw-light">Connexion</a></li>
                </ul>
            </div>

            {{-- Links --}}
            <div class="col-md col-sm-5">
                {{-- Small title --}}
                <h6 class="text-black mb-4">Mentions légales</h6>

                {{-- Links --}}
                <ul class="d-flex gap-3 mb-0 flex-column">
                    <li><a href="" class="text-black fw-light">Mentions légales</a></li>
                    <li><a href="" class="text-black fw-light">Politique de confidentialité</a></li>
                    <li><a href="" class="text-black fw-light">Conditions générales d'utilisation</a></li>
                    <li><a href="" class="text-black fw-light">Conditions générales de ventes</a></li>
                    <li><a href="" class="text-black fw-light">Politique de cookies</a></li>
                </ul>
            </div>





        </div>
    </div>
</footer>
