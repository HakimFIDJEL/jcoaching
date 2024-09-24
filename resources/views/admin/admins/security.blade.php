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
                Modifiez votre mot de passe
            </h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez modifier votre mot de passe.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body">

        <form action="{{ route('admin.admins.updatePassword') }}" method="post">
            @csrf
    
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">
                            Mot de passe actuel
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <div class="input-group">
                            <input 
                                type="password" 
                                class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" 
                                name="current_password" 
                                placeholder="Entrez votre mot de passe actuel" 
                                autofocus 
                                required
                            >
                            <button type="button" class="input-group-text show-pass btn btn-primary">
                                <i class="fa fa-eye-slash"></i>
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Nouveau mot de passe
                            <span class="text-muted">
                                *
                            </span>
                        </label>
                        <div class="input-group">
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Entrez votre nouveau mot de passe" 
                                required 
                            >
                            <button type="button" class="input-group-text show-pass btn btn-primary">
                                <i class="fa fa-eye-slash"></i>
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="password_confirmation" class="form-label">
                        Confirmez votre nouveau mot de passe
                        <span class="text-muted">
                            *
                        </span>
                    </label>
                    <input 
                        type="password" 
                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirmez votre nouveau mot de passe" 
                        required
                    >
                </div>
            </div>

            
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <span>
                        Modifier votre mot de passe
                    </span>
                    <i class="fas fa-key ms-2"></i>
                </button>
            </div>
        </form>


    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection

