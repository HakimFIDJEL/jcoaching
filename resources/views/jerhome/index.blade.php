@extends('jerhome._elements.layout')

@section('title', 'Accueil')

@section('styles')
    @vite('resources/css/style.css')
@endsection

@section('content')

    {{-- Hero --}}
    <div id="home" class="intro border-0 mt-5 pt-5">
        <div class="container">
            <div class="content">
                <div class="row align-items-center">
                    <div class="col-md">
                        <div class="content-text">
                            <span>Coaching sportif à domicile</span>
                            <h1>Améliorez votre forme physique et votre santé</h1>
                            <div class="entry">
                                <p class="fw-light text-light">
                                    Profitez d'un coaching personnalisé à domicile, adapté à vos objectifs. Que ce soit pour
                                    perdre du poids, gagner en muscle ou améliorer votre bien-être global, JerHomeCoaching
                                    est là pour vous accompagner.
                                </p>

                                <a href="{{ route('auth.register') }}" class="btn button">Je m'inscris !</a>
                            </div>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="content-image">
                            <img src="{{ asset('media/img1.png') }}" alt="Photo Hero">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- About --}}
    <div id="about" class="about">
        <div class="container">
            <h2 class="text-center" style="word-break: break-word; hyphens: auto;">
                Votre allié pour une meilleure santé et des entraînements adaptés à vos besoins et à votre condition physique.
            </h2>
            <div class="row g-5">
                <div class="col-md-7">
                    <div class="content-left">
                        <img src="{{ asset('media/img2.png') }}" alt="Photo 1">
                    </div>
                </div>
                <div class="col-md">
                    <div class="content-right">
                        <img src="{{ asset('media/img3.png') }}" alt="Photo 2">
                        <p class="fw-light">Que vous soyez débutant ou confirmé, je vous propose des séances sur-mesure à domicile, pour vous
                            permettre de progresser à votre rythme. Grâce à une expertise en fitness et en nutrition,
                            bénéficiez d'un accompagnement global pour atteindre vos objectifs de santé et de forme
                            physique.</p>
                        <a href="{{ route('main.contact') }}" class="btn button">Contactez-moi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- gallery -->
    <div id="gallery" class="gallery">
        <div class="container">
            <h2>Découvrez notre <br> galerie de coaching</h2>
            <div class="divider"></div>
            <div class="row g-5">

                @foreach ($medias as $media)
                    @if ($media->type == 'image/jpeg' || $media->type == 'image/png' || $media->type == 'image/jpg')
                        <div class="col-md-4">
                            <a href="{{ Storage::url($media->path) }}"
                                class="popup-image">
                                <img src="{{ Storage::url($media->path) }}"
                                    alt="{{ $media->label }}" title="{{ $media->label }}" class="h-100"
                                    style="object-fit: cover;" />
                            </a>
                        </div>
                    @elseif($media->type == 'video/mp4' || $media->type == 'video/webm')
                        <div class="col-md-4">
                            <a href="{{ Storage::url($media->path) }}"
                                class="popup-image">
                                <video src="{{ Storage::url($media->path) }}"
                                    alt="{{ $media->label }}" title="{{ $media->label }}" class="h-100" controls></video>
                            </a>
                        </div>
                    @else
                    @endif
                @endforeach

                {{-- 
				<div class="col-md-4">
					<a href="img/gallery1.png" class="popup-image"><img src="img/gallery1.png"></a>
				</div>
				<div class="col-md-4">
					<a href="img/gallery2.png" class="popup-image"><img src="img/gallery2.png"></a>
				</div>
				<div class="col-md-4">
					<a href="img/gallery3.png" class="popup-image"><img src="img/gallery3.png"></a>
				</div>
				<div class="col-md-4">
					<a href="img/gallery4.png" class="popup-image"><img src="img/gallery4.png"></a>
				</div>
				<div class="col-md-4">
					<a href="img/gallery6.png" class="popup-image"><img src="img/gallery6.png"></a>
				</div>
				<div class="col-md-4">
					<a href="img/gallery5.png" class="popup-image"><img src="img/gallery5.png"></a>
				</div> --}}
            </div>
        </div>
    </div>
    <!-- end gallery -->

    <!-- pricing -->
    <div id="pricing" class="pricing">
        <div class="container">
            <div class="row g-5">
                <div class="col-md col-md-left">
                    <div class="content-left">
                        <h2>Choisissez votre formule</h2>
                        <p>Optez pour la formule qui vous convient. En complément du coaching sportif à domicile, vous pouvez ajouter un suivi nutritionnel personnalisé pour optimiser vos résultats. Avec la certification 'Service à la personne', vous bénéficiez d'une <strong>réduction fiscale de 50%</strong> sur le coût de vos séances et formules, rendant votre programme encore plus attractif.</p>
                    </div>
                </div>

                @foreach ($pricings as $pricing)
                    <div class="col-md">
                        <div class="content h-100">
                            <h4>{{ $pricing->title }}</h4>
                            <p class="fw-light">{{ $pricing->subtitle }}</p>
                            <ul>
                                <li><i class="la la-check-circle"></i>{{ $pricing->nbr_sessions }} séances</li>
                                @foreach ($pricing->features as $feature)
                                    <li><i class="la la-check-circle"></i> {{ $feature->label }}</li>
                                @endforeach
                            </ul>
                            <h2>
                                {{ $pricing->price }} &euro;
                                <span class="text-muted fw-light fs-16" style="text-transform: none;">
                                    / 30 jours
                                </span>
                            </h2>
                            <a href="{{ route('main.pricings') }}" class="btn button">En savoir plus</a>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="col-md">
					<div class="content">
						<h4>Annual</h4>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing</p>
						<ul>
							<li><i class="la la-check-circle"></i> Instructor</li>
							<li><i class="la la-check-circle"></i> Free Drink</li>
							<li><i class="la la-check-circle"></i> Get Supplement</li>
							<li><i class="la la-check-circle"></i> Free Support</li>
						</ul>
						<h2>$350</h2>
						<button class="button">Choose Now</button>
					</div>
				</div> --}}
            </div>
        </div>
    </div>
    <!-- end pricing -->

    <!-- contact -->
    <div id="contact" class="contact">
        <div class="container">
            <div class="content-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d40488.106056416924!2d3.120675916717373!3d50.636281474880235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2d7ca41d2e233%3A0xeda8ebce54d68759!2sVilleneuve-d&#39;Ascq%2C%20France!5e0!3m2!1sfr!2ses!4v1727976441346!5m2!1sfr!2ses"
                    height="510" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                   
            </div>
            <div class="row g-5">
                <div class="col-md col-sm-12">
                    <h2>Contactez-moi</h2>
                    <p>Pour toute question ou demande de renseignements, n'hésitez pas à me contacter. Vous pouvez également
                        consulter notre page dédiée pour plus de détails sur mes services et coordonnées.</p>

                    @if ($company_phone)
                        <div class="row">
                            <div class="col">
                                <div class="icon"><i class="la la-phone"></i></div>
                                <div class="text">
                                    <h5>Téléphone</h5>
                                    <span>
                                        <a href="tel:{{ $company_phone }}" class="text-muted btn-link">
                                            {{ $company_phone }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($company_email)
                        <div class="row">
                            <div class="col">
                                <div class="icon"><i class="la la-envelope"></i></div>
                                <div class="text">
                                    <h5>Email</h5>
                                    <span>
                                        <a href="mailto:{{ $company_email }}" class="text-muted btn-link">
                                            {{ $company_email }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($company_address)
                        <div class="row">
                            <div class="col">
                                <div class="icon"><i class="la la-university"></i></div>
                                <div class="text">
                                    <h5>Localisation</h5>
                                    <span class="text-muted d-block" style="max-width: 300px;">
                                        {{ $company_address }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md col-sm-12">
                    <div class="open">
                        <h3>Lundi - Dimanche</h3>
                        <span>10:00 - 19:00</span>
                        <h3 class="mb-5">Sauf jours fériés !</h3>
                        {{-- <span>Sauf jours fériés !</span> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end contact -->


    <!-- testimonial -->
    <div id="testimonial" class="testimonial">
        <div class="container">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    @foreach ($feedbacks as $feedback)
                        <div class="swiper-slide">
                            <div class="content">
                                <p>{!! $feedback->message !!}</p>
                                <div class="text">
                                    <h5>{{ $feedback->name }}</h5>
                                    <span>{{ $feedback->job }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev prev-slide"></div>
                <div class="swiper-button-next next-slide"></div>
            </div>
        </div>
    </div>
    <!-- end testimonial -->

@endsection
