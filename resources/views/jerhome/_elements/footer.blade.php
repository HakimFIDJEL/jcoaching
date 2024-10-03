{{-- Boostrap footer --}}
<footer class="bg-primary text-black py-5">
    <div class="container d-flex flex-column gap-5 w-100">
        <div class="row d-flex justify-content-between align-items-center gap-2">
            <div class="col-md col-sm-6">
                <ul class="d-flex gap-3 mb-0 justify-content-lg-start justify-content-center">
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
                <div class="cp d-flex justify-content-lg-end justify-content-center">
                    {{-- center when responsive --}}
                    <span>
                        {{ $company_name ?? env('APP_NAME') }}
                        © {{ date('Y') }} Tous droits réservés
                    </span>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-between flex-column gap-4">
            

            {{-- Links --}}
            <div class="col-md col-sm-5 d-flex flex-column">

                {{-- Small title --}}
                <h6 class="text-black mb-1">Liens rapides</h6>

                {{-- Links --}}

                <ul class="d-flex gap-4 mb-0 flex-row flex-wrap" style="row-gap: 0.5rem !important;">
                    <li><a href="{{ route('main.index') }}" class="text-black fw-light">Accueil</a></li>
                    <li><a href="{{ route('main.about') }}" class="text-black fw-light">À propos</a></li>
                    <li><a href="{{ route('main.galerie') }}" class="text-black fw-light">Galerie</a></li>
                    <li><a href="{{ route('main.pricings') }}" class="text-black fw-light">Tarifs</a></li>
                    <li><a href="{{ route('main.contact') }}" class="text-black fw-light">Contact</a></li>
                    <li><a href="{{ route('main.account') }}" class="text-black fw-light">Connexion</a></li>
                </ul>
            </div>

            {{-- Links --}}
            <div class="col-md col-sm-5 d-flex flex-column">
                {{-- Small title --}}
                <h6 class="text-black mb-1">Mentions légales</h6>

                {{-- Links --}}
                <ul class="d-flex gap-4 mb-0 flex-row flex-wrap" style="row-gap: 0.5rem !important;">
                    <li><a href="{{ route('main.legal.mentions') }}" class="text-black fw-light">Mentions légales</a></li>
                    <li><a href="{{ route('main.legal.privacy') }}" class="text-black fw-light">Politique de confidentialité</a></li>
                    <li><a href="{{ route('main.legal.terms') }}" class="text-black fw-light">Conditions générales d'utilisation</a></li>
                    <li><a href="{{ route('main.legal.sales') }}" class="text-black fw-light">Conditions générales de ventes</a></li>
                    <li><a href="{{ route('main.legal.cookies') }}" class="text-black fw-light">Politique de cookies</a></li>
                </ul>
            </div>





        </div>
    </div>
</footer>
