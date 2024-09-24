@extends('member._elements.layout')

@section('title', 'Mon profil')


@section('content')


@include('member.account._elements.edit_header')

{{-- Page content --}}
<div class="card border border-4 border-primary">

    

     {{-- Content Header --}}
     <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Modifiez votre photo de profil
            </h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez modifier votre photo de profil et même la télécharger.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body">

        <form action="{{ route('member.account.update-pfp') }}" method="post" enctype="multipart/form-data">
            @csrf
    
            <div class="row">
                <div class="col">
                    <label for="pfp" class="form-label">Photo de profil</label>
                    <input 
                        type="file"
                        class="filepond"
                        id="pfp"
                        name="pfp"
                        accept="image/*, video/*"
                        data-max-files="1"
                        @if($member->pfp_path)
                            data-documents="{{ json_encode([[
                                'source' => asset('storage/' . str_replace('public/', '', $member->pfp_path)),
                            ]]) }}"
                        @endif
                    >
                </div>
            </div>
            

            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <span>
                            Modifier votre photo de profil
                        </span>
                        <i class="fas fa-upload ms-2"></i>
                    </button>
                </div>
                @if($member->pfp_path)
                    <div class="col-4">
                        <a href="{{ route('member.account.download-pfp') }}" class="btn btn-secondary w-100">
                            <span>
                                Télécharger votre photo de profil
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

