@extends('admin._elements.layout')

@section('title', 'Corbeille - Médias')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les médias
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.medias.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer tous les médias"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.medias.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer tous les médias"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux médias mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                                    <a title="Restorer le média" href="{{ route('admin.medias.restore', ['id' => $media->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer le média" href="{{ route('admin.medias.delete', ['id' => $media->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

