@component('mail::message')
# Bienvenue, {{ $user->firstname }} {{ $user->lastname }} !

Nous sommes ravis de vous accueillir parmi notre communauté chez **{{ env('APP_NAME') }}**.

## Votre Bienvenue Exclusive 🎉

En tant que nouveau membre, nous avons le plaisir de vous offrir **votre première séance de sport gratuitement** ! Nous croyons en votre potentiel et voulons vous aider à atteindre vos objectifs de fitness.

@component('mail::button', ['url' => route('auth.login')])
Voir mon espace membre
@endcomponent

Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Nous sommes là pour vous aider à atteindre vos objectifs.

Encore une fois, bienvenue chez **{{ env('APP_NAME') }}** ! Nous sommes impatients de vous voir réussir.

@component('mail::subcopy')
À très bientôt dans votre première séance !

Sportivement,

**L'équipe {{ env('APP_NAME') }}**
@endcomponent

@endcomponent
