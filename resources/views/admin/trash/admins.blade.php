@extends('admin._elements.layout')

@section('title', 'Corbeille - Administrateurs')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les administrateurs
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.admins.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer tous les membres"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.admins.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer tous les membres"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux administrateurs mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                        <th>Prénom</th>
                        <th>Adresse e-mail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>
                                @if($admin->pfp_path)
                                    <img class="rounded-circle" style="aspect-ratio: 1/1" width="35" src="{{ Storage::url($admin->pfp_path) }}" alt="">
                                @else 
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-title bg-primary text-black rounded-circle p-1" style="font-size: 1rem;">
                                                {{ substr($admin->firstname, 0, 1) }}{{ substr($admin->lastname, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <th>#{{ $admin->id }}</th>
                            <td>{{ $admin->lastname }}</td>
                            <td>{{ $admin->firstname }}</td>
                            <td>
                                <a href="mailto:{{ $admin->email }}">
                                    <i class="fa fa-envelope me-1"></i>
                                    {{ $admin->email }}
                                </a>
                            </td>
                            <td>											
                                <div class="d-flex">
                                    <a title="Restorer l'administrateur" href="{{ route('admin.admins.restore', ['id' => $admin->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer l'administrateur" href="{{ route('admin.admins.delete', ['id' => $admin->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

