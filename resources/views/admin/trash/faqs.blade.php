@extends('admin._elements.layout')

@section('title', 'Corbeille - Faqs')


@section('content')



@include('admin.trash._elements.header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les faqs
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a 
                    href="{{ route('admin.trash.faqs.restore-all') }}" 
                    class="btn btn-outline-primary warning-row"
                    title="Restorer toutes les faqs"
                >
                        <i class="fa fa-undo me-1"></i> Restorer tout
                </a>
                <a 
                    href="{{ route('admin.trash.faqs.delete-all') }}" 
                    class="btn btn-outline-danger delete-row"
                    title="Supprimer toutes les faqs"
                >
                        <i class="fa fa-trash me-1"></i> Supprimer tout
                </a>
            </div>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez accès aux faqs mis à la corbeille. Vous pouvez les restaurer ou les supprimer définitivement.
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
                        <th>Question</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr>
                            <td>#{{ $faq->id }}</td>
                            <td>
                                @if($faq->online)
                                    <span class="badge bg-primary">En ligne</span>
                                @else 
                                    <span class="badge bg-secondary">Hors ligne</span>
                                @endif
                            </td>
                            <td>{{ $faq->question }}</td>
                            <td>											
                                <div class="d-flex">
                                    <a title="Restorer la faq" href="{{ route('admin.faqs.restore', ['id' => $faq->id]) }}" class="btn btn-outline-primary shadow btn-xs sharp me-1 warning-row"><i class="fa fa-undo"></i></a>
                                    <a title="Supprimer la faq" href="{{ route('admin.faqs.delete', ['id' => $faq->id]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

