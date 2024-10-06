@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}



{{-- Page content --}}
<div class="card border border-4 border-primary">


    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title">
            <h4 class="mb-0">Photo de profil de {{ $member->firstname }} {{ $member->lastname }}</h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez la possibilité de modifier la photo de profil du membre et de la télécharger.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body">
        <form action="{{ route('admin.members.update-pfp', ['user' => $member]) }}" method="post" enctype="multipart/form-data">
            @csrf
    
            <div class="row">
                <div class="col">
                    <label for="pfp" class="form-label">
                        Photo de profil
                        <span class="text-muted">
                            (1 fichier maximum - formats jpg, jpeg et png acceptés)
                        </span>
                    </label>
                    <input 
                        type="file"
                        class="filepond"
                        id="pfp"
                        name="pfp"
                        accept="image/*"
                        data-max-files="1"
                        @if($member->pfp_path)
                            data-documents="{{ json_encode([[
                                'source' => Storage::url($member->pfp_path),
                            ]]) }}"
                        @endif                                
                    >
                </div>
            </div>
            
    
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <span>
                            Modifier la photo de profil
                        </span>
                        <i class="fas fa-upload ms-2"></i>
                    </button>
                </div>
                @if($member->pfp_path)
                    <div class="col-4">
                        <a href="{{ route('admin.members.download-pfp', ['user' => $member]) }}" class="btn btn-secondary w-100">
                            <span>
                                Télécharger la photo de profil
                            </span>
                            <i class="fas fa-download ms-2"></i>
                        </a>
                    </div>
                @endif
            </div>
        </form>


            

    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}


@endsection
