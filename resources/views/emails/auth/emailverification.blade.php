@component('mail::message')
# Confirmez votre adresse e-mail, {{ $user->firstname }} {{ $user->lastname }}

Merci de vous être inscrit(e) sur **{{ env('APP_NAME') }}**. Pour finaliser votre inscription et activer votre compte, nous avons besoin de vérifier que cette adresse e-mail vous appartient.

## Votre code de vérification 🔑

Veuillez utiliser le code de vérification ci-dessous pour confirmer votre adresse e-mail :

@component('mail::panel')
**{{ $user->email_token }}**
@endcomponent

Ce code de vérification expirera dans 24 heures. Si vous ne l'avez pas utilisé d'ici là, vous devrez en demander un nouveau.

Cliquez sur le lien suivant pour vérifier votre e-mail et activer votre compte :

@component('mail::button', ['url' => route('auth.email-verification', ['user_token' => $user->user_token])])
Vérifier Mon E-mail
@endcomponent

Si vous n'avez pas initié cette demande, veuillez ignorer cet e-mail.

@component('mail::subcopy')
Merci de votre confiance,

**L'équipe {{ env('APP_NAME') }}**
@endcomponent


@endcomponent
