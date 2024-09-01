@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}



{{-- Page content --}}
<div class="card border border-4 border-primary">


    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">

      

        <form action="{{ route('admin.members.update-pfp', ['user' => $member]) }}" method="post" enctype="multipart/form-data">
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

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

