@component('mail::message')

@if($user->isAdmin())
# Des séances ont été mises à jour !
@else 
# Bonjour, {{ $user->firstname }} {{ $user->lastname }}, vos séances ont été mises à jour !
@endif

@component('mail::panel')

## Voici le détail des changements :

@component('mail::table')

| ID | Membre | Date | Statut |
|:--:|:------:|:----:|:------:|
@foreach($workouts as $workout)
| #{{ $workout->id }} | {{ $workout->user?->firstname }} {{ $workout->user?->lastname }} | @if($workout->date) {{ \Carbon\Carbon::parse($workout->date)->format('d/m/y - H:i') }} @else À planifier @endif | @if($workout->status) Terminée @else À faire @endif |
@endforeach

@endcomponent

@endcomponent

@component('mail::button', ['url' => route('auth.login')])
Voir sur mon calendrier
@endcomponent

@component('mail::subcopy')
À très bientôt dans votre espace !

Sportivement,

**L'équipe {{ env('APP_NAME') }}**
@endcomponent

@endcomponent
