@extends('admin._elements.layout')

@section('title', 'Contatcs')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Contacts</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">


    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les contacts
            </h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez consulter les messages envoyés par les visiteurs de votre site.
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
                        <th>ID</th>
                        <th>Statut</th>
                        <th>Sujet</th>
                        <th>Nom</th>
                        <th>Adresse e-mail</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>#{{ $contact->id }}</td>
                            <td>
                                @if($contact->read_at)
                                    <span class="badge bg-primary">
                                        <span class="me-1">
                                            Lu
                                        </span>
                                        <i class="fa fa-check"></i>
                                    </span>
                                    
                                @else 
                                    <span class="badge bg-secondary">
                                        <span class="me-1">
                                            Non lu
                                        </span>
                                        <i class="fa fa-times"></i>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->lastname }} {{$contact->firstname }}</td>
                            <td>
                                <a href="mailto:{{ $contact->email }}">
                                    <i class="fa fa-envelope me-1"></i>
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a title="Lire le message" href="{{ route('admin.contacts.show', ['contact' => $contact]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a title="Mettre à la corbeille le message" href="{{ route('admin.contacts.soft-delete', ['contact' => $contact]) }}" class="btn btn-outline-danger shadow btn-xs sharp warning-row"><i class="fa fa-trash"></i></a>
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

