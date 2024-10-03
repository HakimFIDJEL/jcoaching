@extends('jerhome._elements.layout')

@section('title', 'Politique de confidentialité')

@section('content')

    <div class="container my-5">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                Politique de confidentialité
            </h1>
            <hr>
        </div>
    </div>

    <section class="my-5 pb-5">
        Chez {{ $company_name }}, on accorde une grande importance à la protection de tes données personnelles. Voici comment on les collecte, les utilise et les protège.

        <br><br>

        <h5 class="my-4 text-primary fw-bold">
            1. Données collectées
        </h5>
        <hr>

        Lors de ton inscription et utilisation du site, on peut collecter les informations suivantes :

            Nom et prénom
            Adresse e-mail
            Numéro de téléphone
            Adresse postale (adresse, ville, code postal, pays, complément d'adresse)
            Photo de profil (optionnelle)
            Mot de passe (chiffré)
            Confirmation de l'adresse e-mail
            Adresse IP

        Lors de tes achats, on collecte aussi :

            Détails de la commande (produit acheté, quantité, prix)
            Statut du paiement (validé ou non)
            Informations nécessaires pour la facturation

        <h5 class="my-4 text-primary fw-bold">
            2. Méthodes de collecte
        </h5>
        <hr>

            Formulaire d'inscription : pour créer ton compte utilisateur.
            Espace membre : quand tu mets à jour ton profil.
            Cookies : on utilise un cookie "remember me" (optionnel) pour faciliter ta connexion.

        <h5 class="my-4 text-primary fw-bold">
            3. Utilisation des données
        </h5>
        <hr>

        Tes données nous permettent de :

            Gérer ton compte et ton accès à l'espace membre.
            Te contacter pour des informations liées au service.
            Traiter tes commandes et paiements.
            Personnaliser et améliorer ton expérience utilisateur.

        <h5 class="my-4 text-primary fw-bold">
            4. Partage des données
        </h5>
        <hr>

        On ne partage pas tes données personnelles avec des tiers, sauf dans les cas suivants :

            Paiements en ligne : on utilise Stripe pour traiter les paiements. Seules les informations nécessaires sont transmises.
            Obligations légales : si la loi nous y oblige.

        <h5 class="my-4 text-primary fw-bold">
            5. Cookies
        </h5>
        <hr>

            On utilise un cookie "remember me" pour te garder connecté si tu le souhaites.
            Aucun autre cookie n'est utilisé pour suivre ou collecter des informations.

        <h5 class="my-4 text-primary fw-bold">
            6. Tes droits
        </h5>
        <hr>

            Accès et rectification : tu peux consulter et modifier tes infos depuis ton espace membre.
            Suppression : tu peux demander la suppression de ton compte à tout moment.
            Opposition : si tu as des inquiétudes sur l'utilisation de tes données, contacte-nous.

        <h5 class="my-4 text-primary fw-bold">
            7. Durée de conservation
        </h5>
        <hr>

            Tes données sont conservées tant que ton compte est actif.
            En cas de suppression de compte, tes données sont définitivement effacées.

        <h5 class="my-4 text-primary fw-bold">
            8. Sécurité des données
        </h5>
        <hr>

        On met en place diverses mesures pour protéger tes données :

            Accès restreint à l'espace admin, protégé par mot de passe.
            Mots de passe utilisateurs sécurisés (minimum 8 caractères).
            Vérifications côté serveur et client sur les formulaires.
            Protection contre les attaques XSS et injections SQL grâce à Laravel.

        <h5 class="my-4 text-primary fw-bold">
            9. Mineurs
        </h5>
        <hr>

        Le site n'est pas destiné aux personnes de moins de 16 ans.

        <h5 class="my-4 text-primary fw-bold">
            10. Contact
        </h5>
        <hr>

        Pour toute question sur la protection de tes données, utilise le formulaire de contact sur le site.

        <h5 class="my-4 text-primary fw-bold">
            11. Modifications de la politique
        </h5>
        <hr>

        Cette politique peut être mise à jour. On t'invite à la consulter régulièrement.
    </section>



@endsection

