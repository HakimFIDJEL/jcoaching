@extends('admin._elements.layout')

@section('title', 'Témoignages')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Témoignages</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les témoignages
            </h4>
            <a 
                href="{{ route('admin.feedbacks.create') }}"
                class="btn btn-primary btn-sm"
            >
                <span>
                    Ajouter un témoignage
                </span>
                <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez gérer les témoignages de votre application.
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
                        <th>Nom</th>
                        <th>Emploi / Métier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td>#{{ $feedback->id }}</td>
                            <td>
                                @if($feedback->online)
                                    <span class="badge bg-primary">En ligne</span>
                                @else 
                                    <span class="badge bg-secondary">Hors ligne</span>
                                @endif
                            </td>
                            <td>{{ $feedback->name }}</td>
                            <td>{{ $feedback->job }}</td>
                            <td>
                                <div class="d-flex">
                                    <a title="Modifier le témoignage" href="{{ route('admin.feedbacks.edit', ['feedback' => $feedback]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    <a title="Mettre à la corbeille le témoignage" href="{{ route('admin.feedbacks.soft-delete', ['feedback' => $feedback]) }}" class="btn btn-outline-danger shadow btn-xs sharp warning-row"><i class="fa fa-trash"></i></a>
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

