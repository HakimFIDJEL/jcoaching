@component('mail::message')
# Bienvenue, {{ $user->firstname }} {{ $user->lastname }} !

Nous sommes ravis de vous accueillir en tant qu'administrateur parmi notre équipe chez **{{ env('APP_NAME') }}**.

## Votre Bienvenue Exclusive 🎉

En tant que nouvel administrateur, vous avez désormais accès à un tableau de bord exclusif pour gérer les membres, les séances et les abonnements.

Vous allez pouvoir choisir votre mot de passe en cliquant sur le bouton ci-dessous :

@component('mail::button', ['url' => route('auth.login')])
Voir mon espace administrateur
@endcomponent

Utilisez le mot de passe temporaire suivant pour votre première connexion :

@component('mail::panel')
**{{ $temporary_password }}**
@endcomponent

Encore une fois, bienvenue chez **{{ env('APP_NAME') }}** !

@component('mail::subcopy')
À très bientôt dans votre espace administrateur !

Sportivement,

**L'équipe {{ env('APP_NAME') }}**
@endcomponent

@endcomponent
