@component('mail::message')

# Bonjour, {{ $user->firstname }} {{ $user->lastname }}, merci pour votre commande ! 

@component('mail::panel')

Veuillez trouver ci-joint votre facture numéro **{{ $invoice->invoice_number }}**.

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
