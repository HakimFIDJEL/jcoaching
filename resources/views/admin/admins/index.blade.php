@extends('admin._elements.layout')

@section('title', 'Administrateurs')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Administrateurs</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Les administrateurs</h2>
                <p class="text-light">Liste des administrateurs</p>
            </div>	
            <span>
                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary ">+ Ajouter un administrateur</a>
            </span>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <div class="table-responsive">
            <table style="min-width: 845px" class="datatable display mt-5 mb-5">
                <thead>
                    <tr>
                        <th>
                            {{-- Photo de profil --}}
                        </th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Adresse e-mail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $user)
                        <tr>
                            <td>
                                @if($user->pfp_path)
                                    <img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt="">
                                @else 
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-title bg-primary text-black rounded-circle p-1" style="font-size: 1rem;">
                                                {{ substr($user->firstname, 0, 1) }}{{ substr($user->lastname, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <th>#{{ $user->id }}</th>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->firstname }}</td>
                            <td>
                                <a href="mailto:{{ $user->email }}">
                                    <i class="fa fa-envelope me-1"></i>
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if(Auth::user() == $user)
                                        <a title="Modifier l'administrateur" href="{{ route('admin.admins.edit') }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    @else 
                                        <a title="Mettre à la corbeille l'administrateur" href="{{ route('admin.admins.soft-delete', ['user' => $user]) }}" class="btn btn-outline-danger shadow btn-xs sharp  delete-row"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>												
                            </td>
                        </tr>
                    @endforeach										
                </tbody>
            </table>
        </div>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection
