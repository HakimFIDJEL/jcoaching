@extends('member._elements.layout')

@section('title', 'Idée repas')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header border border-primary flex-column align-items-start p-4">
                    <div class="card-title d-flex justify-content-between w-100 align-items-center">
                        <h4 class="mb-0">
                            L'idée repas de la semaine
                        </h4>
                    </div>
                    <div class="card-description">
                        <p class="text-muted  mb-0 font-weight-light">
                            Merci d'avoir souscris au suivi nutritionnel sur votre abonnement. Voici une idée de repas préparée par notre coach sportif spécialisé dans la nutrition du sport pour vous aider à atteindre vos objectifs.
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <p class="lead">{!! $nutrition_idea !!}</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('member.index') }}" class="btn btn-outline-primary w-100"> 
                        Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
