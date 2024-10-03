@extends('jerhome._elements.layout')

@section('title', 'À propos')

@section('meta_title', "À propos de moi - JerHomeCoaching")
@section('meta_description', "Salut, moi c'est Jérôme ! Coach sportif passionné. Apprends-en plus sur mon parcours et ma méthode pour t'aider à progresser.")

@section('content')


    <div class="container my-5">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                À propos
            </h1>
            <p class="fw-light mb-0 text-center">
                Découvrez qui je suis et ce que je vous propose
            </p>
            <hr>
        </div>


        <div class="row align-items-center pt-4">
            <div class="col-md-6 pb-lg-0 pb-4">
                <img src="{{ asset('media/img3.png') }}" class="img-fluid rounded" alt="Photo de Jérôme">
            </div>
            <div class="col-md-6">
                <h5 class="text-primary fw-bold mb-4">
                    Bonjour à tous !
                </h5>
                <p>
                    Je m'appelle Jérôme, préparateur physique passionné, diplômé et expérimenté. Mon objectif est de vous
                    aider à progresser grâce à des séances personnalisées et un suivi adapté.
                </p>
                <a href="{{ route('main.pricings') }}" class="btn btn-primary mt-2">
                    Découvrir mes services
                </a>
            </div>
        </div>
    </div>

    <!-- Avantages sous forme de bento boxes -->
    <div class="container my-5 py-5">
        <h5 class="text-primary fw-bold">
            Pourquoi choisir mes services ?
        </h5>
        {{-- Delimiter --}}
        <hr>
        <div class="row text-center mt-4 pt-4">
            <div class="col-md-3 mb-4">
                <div class="card h-100 border border-primary">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-2x mb-3 text-primary bg-dark rounded-circle p-2"></i>
                        <h6 class="card-title fw-bold">Progrès Personnalisés</h6>
                        <p class="card-text">Des séances adaptées à votre profil pour une progression optimale.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 border border-primary">
                    <div class="card-body">
                        <i class="fas fa-piggy-bank fa-2x mb-3 text-primary bg-dark rounded-circle p-2"></i>
                        <h6 class="card-title fw-bold">Économies Financières</h6>
                        <p class="card-text">Économisez 50% grâce à la certification "Services à la Personne".</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 border border-primary">
                    <div class="card-body">
                        <i class="fas fa-apple-alt fa-2x mb-3 text-primary bg-dark rounded-circle p-2"></i>
                        <h6 class="card-title fw-bold">Suivi Nutritionnel</h6>
                        <p class="card-text">Option de suivi nutritionnel pour maximiser vos résultats.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 border border-primary">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x mb-3 text-primary bg-dark rounded-circle p-2"></i>
                        <h6 class="card-title fw-bold">Gain de Temps</h6>
                        <p class="card-text">Coaching à domicile ou programmes complets selon vos disponibilités.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accordéon pour le parcours -->
    <div class="container my-5">
        <h5 class=" text-primary fw-bold">
            Mon Parcours
        </h5>
        <hr>

        <div class="accordion mt-4 pt-4" id="parcoursAccordion">
            <div class="card border border-primary">
                <div class="card-header border-bottom border-primary" id="headingOne">
                    <h5 class="mb-0 ">
                        Diplômes et Formations
                    </h5>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#diplomes"
                        aria-expanded="true" aria-controls="diplomes">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="diplomes" class="collapse show" aria-labelledby="headingOne" data-parent="#parcoursAccordion">
                    <div class="card-body">
                        <p>
                            Diplômé d'une licence en Entraînement Sportif (STAPS) et d'un master EOPS spécialisé en
                            préparations physique, mentale et nutritionnelle, je mets mes compétences à votre service pour
                            un accompagnement complet.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card border border-primary">
                <div class="card-header border-bottom border-primary" id="headingTwo">
                    <h5 class="mb-0 ">
                        Expériences Professionnelles
                    </h5>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#experience"
                        aria-expanded="true" aria-controls="experience">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="experience" class="collapse" aria-labelledby="headingTwo" data-parent="#parcoursAccordion">
                    <div class="card-body">
                        <p>
                            J'ai réalisé des stages dans des structures prestigieuses comme le Pôle Espoir Judo de
                            Tourcoing, des clubs d'escalade, et auprès de publics variés, y compris des personnes en
                            situation de handicap.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card border border-primary">
                <div class="card-header border-bottom border-primary" id="headingThree">
                    <h5 class="mb-0 ">
                        Parcours Sportif
                    </h5>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sport"
                        aria-expanded="true" aria-controls="sport">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="sport" class="collapse" aria-labelledby="headingThree" data-parent="#parcoursAccordion">
                    <div class="card-body">
                        <p>
                            Avec plus de 15 ans de judo en club et 2 ans d'escalade, je pratique également la musculation
                            depuis 5 ans, toujours animé par la recherche de performance.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Section Avantages du Coaching à Domicile -->
    <section class="py-5">
        <div class="container">
            <h5 class="text-primary fw-bold">
                Les avantages du coaching à domicile
            </h5>
            <hr>
            <div class="row align-items-center my-4 py-4">
                <div class="col-md-6">
                    <p class="mb-4">Il n'est pas toujours facile de trouver le temps ou la motivation pour aller en salle
                        de sport ou débuter une nouvelle activité. C'est là qu'intervient le <strong>coaching à
                            domicile</strong>, offrant de nombreux avantages :</p>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-dumbbell text-primary mr-2"></i>
                            <strong>Aucun matériel nécessaire :</strong> J'apporte tout ce qu'il faut pour vos séances :
                            tapis, haltères, banc, kettlebell, corde à sauter...
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-bullseye text-primary mr-2"></i>
                            <strong>Adapté à tous les objectifs :</strong> Perte de poids, prise de masse, bien-être ou
                            recherche de performance. Tout est possible sans bouger de chez vous.
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-chart-line text-primary mr-2"></i>
                            <strong>Suivi personnalisé :</strong> Un contenu qui s'adapte à votre niveau et à votre
                            évolution pour un suivi optimal de votre progression.
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('media/img7.png') }}" class="img-fluid rounded"
                        alt="Coaching à domicile">
                </div>
            </div>

            <!-- Section Coaching Personnalisé -->
            <div class="mt-5">
                <h5 class="text-primary fw-bold">
                    Un Coaching Totalement Personnalisé
                </h5>
                <hr>
                <div class="my-4 py-4">
                    <p>Au-delà de l'aspect sportif, la santé est primordiale. Les coachings que je propose prennent en
                        compte ce paramètre pour renforcer les muscles profonds, améliorer la mobilité et travailler sur les
                        détails qui vous permettront de progresser durablement.</p>
                    <p>Chaque exercice est abordé de la manière la plus saine et efficace possible. Par exemple, si vous
                        avez des difficultés à réaliser des squats, nous décomposerons le mouvement pour identifier ce qu'il
                        serait intéressant de corriger ou de renforcer.</p>
                    <p class="text-primary">
                        Différentes méthodes sont utilisées lors des séances :
                    </p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4 border border-primary py-2">
                                <div class="card-body text-center">
                                    <i class="fas fa-child fa-2x text-primary mb-3 bg-dark rounded-circle p-2"></i>
                                    <h5 class="card-title">Stretching</h5>
                                    <p class="card-text">Améliorez votre souplesse et prévenez les blessures.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4 border border-primary py-2">
                                <div class="card-body text-center">
                                    <i class="fas fa-dumbbell fa-2x text-primary mb-3 bg-dark rounded-circle p-2"></i>
                                    <h5 class="card-title">Renforcement Musculaire</h5>
                                    <p class="card-text">Développez votre force et tonifiez votre corps.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="card mb-4 border border-primary py-2">
                                <div class="card-body text-center">
                                    <i class="fas fa-running fa-2x text-primary mb-3 bg-dark rounded-circle p-2"></i>
                                    <h5 class="card-title">HIIT</h5>
                                    <p class="card-text">Entraînement à haute intensité pour brûler des calories
                                        efficacement.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Selon vos besoins et vos attentes, une ou plusieurs de ces méthodes seront employées. Par exemple, si
                        vous souhaitez perdre du poids et améliorer votre équilibre, nous pouvons intégrer des exercices
                        spécifiques au sein d'un programme HIIT.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section vidéo améliorée -->
    {{-- <section class="pb-5">
        <div class="container">
            <h5 class="text-primary fw-bold">
                Découvrez en plus sur moi
            </h5>
            <hr>
            <div class="row justify-content-center my-4 py-4">
                <div class="col-md-10">
                    <div class="ratio ratio-16x9">
                        <iframe src="URL_DE_VOTRE_VIDÉO" title="Présentation JerHomeCoaching" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}



@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@endsection
