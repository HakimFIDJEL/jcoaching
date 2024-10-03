@component('mail::message')

# Bonjour, un message de {{ $contact->firstname }} {{ $contact->lastname }}

@component('mail::panel')

## Sujet: {{ $contact->subject }}

{!! $contact->message !!}

@endcomponent

@component('mail::button', ['url' => route('auth.login')])
Voir mon espace
@endcomponent

@component('mail::subcopy')
À très bientôt dans votre espace !

Sportivement,

**L'équipe {{ env('APP_NAME') }}**
@endcomponent

@endcomponent