@component('mail::message')

# Bonjour, {{ $user->firstname }} {{ $user->lastname }}, une nouvelle idée repas viens d'arriver !

@component('mail::panel')

{!! $nutrition_idea !!}

@endcomponent

@component('mail::button', ['url' => route('auth.login')])
Voir mon espace
@endcomponent

@component('mail::subcopy')
À très bientôt dans votre espace et encore merci de votre confiance !

Sportivement,

**L'équipe {{ env('APP_NAME') }}**
@endcomponent

@endcomponent
