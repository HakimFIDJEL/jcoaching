@extends('member._elements.layout')

@section('title', 'Abonnements')

@section('content')


    <div class="row">
        <div class="col">
            @if(Auth::user()->hasCurrentPlan())
                <div class="alert alert-success text-center" role="alert">
                    Félicitations, vous avez un abonnement en cours, il vous reste 
                    <strong>
                        {{ Auth::user()->currentPlan->getDaysLeft() }}
                    </strong> 
                    jours et 
                    <strong>
                        {{ Auth::user()->currentPlan->sessions_left }}
                    </strong> 
                    séances à effectuer.
                </div>            
            @else 
                <div class="alert alert-secondary text-center" role="alert">
                    Vous n'avez pas d'abonnement en cours. N'hésitez plus, 
                    <a href="" class="alert-link text-decoration-underline">
                        inscrivez-vous !
                    </a>
                </div>   
            @endif
        </div>
    </div>

@endsection
