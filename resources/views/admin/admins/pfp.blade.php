@extends('admin._elements.layout')

@section('title', 'Modifier ' . $admin->firstname . ' ' . $admin->lastname)


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Administrateurs</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Modifier vos informations</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}

@include('admin.admins._elements.edit_header')

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

        <form action="{{ route('admin.admins.update-pfp') }}" method="post" enctype="multipart/form-data">
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
                        @if($admin->pfp_path)
                            data-documents="{{ json_encode([[
                                'source' => asset('storage/' . str_replace('public/', '', $admin->pfp_path)),
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
                @if($admin->pfp_path)
                    <div class="col-4">
                        <a href="{{ route('admin.admins.download-pfp', ['user' => $admin]) }}" class="btn btn-secondary w-100">
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

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

