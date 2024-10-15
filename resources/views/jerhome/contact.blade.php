@extends('jerhome._elements.layout')

@section('title', 'Contact')

@section('meta_title', 'Contactez-moi - JerHomeCoaching')
@section('meta_description', "Une question ou besoin d'infos ? N'hésite pas à me contacter ! Je suis dispo pour t'aider à atteindre tes objectifs sportifs.")

@section('content')


    <div class="container my-5">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                Contact
            </h1>
            <p class="fw-light mb-0 text-center">
                Vous pouvez me contacter pour toute demande
            </p>
            <hr>
        </div>
    </div>

    <div class="container">
        <div class="w-100">
            <iframe class="w-100"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d40488.106056416924!2d3.120675916717373!3d50.636281474880235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2d7ca41d2e233%3A0xeda8ebce54d68759!2sVilleneuve-d&#39;Ascq%2C%20France!5e0!3m2!1sfr!2ses!4v1727976441346!5m2!1sfr!2ses"
                height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <div class="container my-5 py-5">
        <h5 class="mb-4 text-primary fw-bold">
            Questions fréquentes
        </h5>
        <hr>

        <div class="accordion mt-4 pt-4" id="faqAccordion">

            @foreach ($faqs as $faq)
                <div class="card border border-primary">
                    <div class="card-header border-bottom border-primary" id="headingOne">
                        <h5 class="mb-0 ">
                            {{ $faq->question }}
                        </h5>
                        <button class="btn btn-link" type="button" data-toggle="collapse"
                            data-target="#faq-{{ $faq->id }}" aria-expanded="true"
                            aria-controls="faq-{{ $faq->id }}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="faq-{{ $faq->id }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                        aria-labelledby="headingOne" data-parent="#faqAccordion">
                        <div class="card-body">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="container my-5 pb-5">
        <h5 class="mb-4 text-primary fw-bold">
            Formulaire de contact
        </h5>
        <hr>

        <form action="{{ route('main.contact-post') }}" method="POST" class="mt-4 pt-2" id="contactForm">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">
                            Prénom
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname"
                            name="firstname" placeholder="Entrez votre prénom" required value="{{ old('firstname') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">
                            Nom
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                            name="lastname" placeholder="Entrez votre nom" required value="{{ old('lastname') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            Téléphone
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" placeholder="Entrez votre numéro de téléphone" required
                            value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Adresse e-mail
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Entrez votre e-mail" required value="{{ old('email') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="subject" class="form-label">
                            Sujet
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                            name="subject" placeholder="Entrez le sujet du message" required value="{{ old('subject') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="message" class="form-label">
                            Message
                            <span class="text-muted">
                                *
                            </span>
                        </label>

                        <textarea class="form-control editor @error('message') is-invalid @enderror" name="message" id="message"
                            rows="1" style="resize: none;" placeholder="Entrez votre message">{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>
            {{-- Checkboxes --}}
            <div class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" value="1" id="terms" name="terms"
                        required>
                    <label class="custom-control-label
                    @error('terms') is-invalid @enderror"
                        for="terms">
                        J'ai lu et j'accepte les
                        <a href="{{ route('main.legal.terms') }}" target="_blank" class="text-decoration-underline">
                            conditions générales d'utilisation
                        </a>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100">
                        <span id="btnText">
                            <span>
                                Envoyer
                            </span>
                            <i class="fas fa-paper-plane ms-2"></i>
                        </span>
                        {{-- Spinner --}}
                        <span class="spinner-border spinner-border-sm" style="display: none;" role="status"
                            aria-hidden="true" id="btnSpinner"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @vite('resources/js/plugins/ckeditor.js')
    @vite('resources/js/pages/jerhome/contact.js')
@endsection
