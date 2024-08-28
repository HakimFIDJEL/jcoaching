@extends('admin._elements.layout')

@section('title', 'Médias')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Médias</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary">
        <div class="form-head d-flex align-items-start justify-content-between gap-2 w-100">    
            <div class="me-auto flex-shrink-0">
                <h2 class="mb-0">Les médias</h2>
                <p class="text-light">Liste des différentes images et vidéos à exposer dans la galerie</p>
            </div>	
            <span>
                <a href="{{ route('admin.medias.create') }}" class="btn btn-primary ">+ Ajouter un média</a>
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
                        <th>ID</th>
                        <th>Statut</th>
                        <th>Libellé</th>
                        <th>Aperçu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medias as $media)
                        <tr>
                            <td>#{{ $media->id }}</td>
                            <td>
                                @if($media->online)
                                    <span class="badge bg-primary">En ligne</span>
                                @else 
                                    <span class="badge bg-secondary">Hors ligne</span>
                                @endif
                            </td>
                            <td>{{ $media->label }}</td>
                            <td>
                                @if($media->type == 'image/jpeg' || $media->type == 'image/png' || $media->type == 'image/jpg')
                                    <img src="{{ asset('storage/' . str_replace('public/', '', $media->path) ) }}" alt="{{ $media->label }}" class="img-fluid" style="max-width: 75px;">
                                @else
                                    <video src="{{ asset('storage/' . str_replace('public/', '', $media->path) ) }}" alt="{{ $media->label }}" class="img-fluid" style="max-width: 75px;"></video>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a title="Modifier le média" href="{{ route('admin.medias.edit', ['media' => $media]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    <a title="Mettre à la corbeille le média" href="{{ route('admin.medias.soft-delete', ['media' => $media]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

