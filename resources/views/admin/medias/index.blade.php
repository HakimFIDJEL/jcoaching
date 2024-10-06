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
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les médias
            </h4>
            <a 
                href="{{ route('admin.medias.create') }}"
                class="btn btn-primary"
            >
                <span>
                    Ajouter un média
                </span>
                <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez gérer les médias de votre application, photos et vidéos.
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
                                    <span class="badge bg-success">
                                        <span>
                                            En ligne
                                        </span>
                                        <i class="fas fa-check ms-1"></i>
                                    </span>
                                @else 
                                    <span class="badge bg-secondary">
                                        <span>
                                            Hors ligne
                                        </span>
                                        <i class="fas fa-times ms-1"></i>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $media->label }}</td>
                            <td>
                                @if($media->type == 'image/jpeg' || $media->type == 'image/png' || $media->type == 'image/jpg')
                                    <img src="{{ Storage::url($media->path) }}" alt="{{ $media->label }}" class="img-fluid" style="max-width: 75px;">
                                @else
                                    <video src="{{ Storage::url($media->path) }}" alt="{{ $media->label }}" class="img-fluid" style="max-width: 75px;"></video>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a title="Modifier le média" href="{{ route('admin.medias.edit', ['media' => $media]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                    <a title="Mettre à la corbeille le média" href="{{ route('admin.medias.soft-delete', ['media' => $media]) }}" class="btn btn-outline-danger shadow btn-xs sharp warning-row"><i class="fa fa-trash"></i></a>
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

