@extends('admin._elements.layout')

@section('title', 'Membres')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Membres</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">



    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les membres
            </h4>
            <a 
                href="{{ route('admin.members.create') }}"
                class="btn btn-primary"
            >
                <span>
                    Ajouter un membre
                </span>
                <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez gérer les membres de votre application.
            </p>
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
                        <th>Adresse e-mail</th>
                        <th>Vérifié</th>
                        <th>Abonné</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $user)
                        <tr>
                            <td>
                                @if($user->pfp_path)
                                    <img class="rounded-circle" style="aspect-ratio: 1/1" width="35" src="{{ $user->getProfilePicture() }}" alt="">
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
                            <td>{{ $user->lastname }} {{ $user->firstname }}</td>
                            <td>
                                <a href="mailto:{{ $user->email }}">
                                    <i class="fa fa-envelope me-1"></i>
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">
                                        <span>
                                            Oui
                                        </span>
                                        <i class="fa fa-check ms-1"></i>
                                    </span>
                                @else 
                                    <span class="badge bg-secondary">
                                        <span>
                                            Non
                                        </span>
                                        <i class="fa fa-times ms-1"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->hasCurrentPlan())
                                    <span class="badge bg-success">
                                        <span>
                                            Oui
                                        </span>
                                        <i class="fa fa-check ms-1"></i>
                                    </span>
                                @else 
                                    <span class="badge bg-secondary">
                                        <span>
                                            Non
                                        </span>
                                        <i class="fa fa-times ms-1"></i>
                                    </span>
                                @endif
                            <td>
                                <div class="d-flex">
                                    <a title="Voir le membre" href="{{ route('admin.members.calendar', ['user' => $user]) }}" class="btn btn-outline-success shadow btn-xs sharp me-1"><i class="fa fa-calendar"></i></a>
                                    <a title="Modifier le membre" href="{{ route('admin.members.edit', ['user' => $user]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    <a title="Mettre à la corbeille le membre" href="{{ route('admin.members.soft-delete', ['user' => $user]) }}" class="btn btn-outline-danger shadow btn-xs sharp  warning-row"><i class="fa fa-trash"></i></a>
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

