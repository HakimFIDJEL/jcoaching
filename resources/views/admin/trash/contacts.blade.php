@extends('admin._elements.layout')

@section('title', 'Corbeille - Contacts')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les contacts
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.contacts.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer tous les témoignages"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.contacts.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer tous les témoignages"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux contacts mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                                    <a title="Restorer le contact" href="{{ route('admin.contacts.restore', ['id' => $contact->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer le contact" href="{{ route('admin.contacts.delete', ['id' => $contact->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

