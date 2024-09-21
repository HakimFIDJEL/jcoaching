@extends('admin._elements.layout')

@section('title', 'Corbeille - Membres')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les membres
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.members.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer tous les membres"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.members.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer tous les membres"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux membres mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                    @foreach($members as $member)
                        <tr>
                            <td>
                                @if($member->pfp_path)
                                    <img class="rounded-circle" style="aspect-ratio: 1/1" width="35" src="{{ $member->getProfilePicture() }}" alt="">
                                @else 
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-title bg-primary text-black rounded-circle p-1" style="font-size: 1rem;">
                                                {{ substr($member->firstname, 0, 1) }}{{ substr($member->lastname, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <th>#{{ $member->id }}</th>
                            <td>{{ $member->lastname }} {{ $member->firstname }}</td>
                            <td>
                                <a href="mailto:{{ $member->email }}">
                                    <i class="fa fa-envelope me-1"></i>
                                    {{ $member->email }}
                                </a>
                            </td>
                            <td>
                                @if($member->email_verified_at)
                                    <span class="badge bg-primary">
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
                                @if($member->hasCurrentPlan())
                                    <span class="badge bg-primary">
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
                                    <a title="Restorer le membre" href="{{ route('admin.members.restore', ['id' => $member->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer le membre" href="{{ route('admin.members.delete', ['id' => $member->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

