@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}



{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title">
            <h4 class="mb-0">Espace documents de {{ $member->firstname }} {{ $member->lastname }}</h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez la possibilité de modifier les documents du membre et de les télécharger.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body">
        <form action="{{ route('admin.members.update-documents', ['user' => $member]) }}" method="post" enctype="multipart/form-data">
            @csrf
    
            <div class="row">
                <div class="col">
                    <label for="documents[]" class="form-label">Documents (5 maximum)</label>
                    <input 
                        type="file"
                        class="filepond"
                        id="documents[]"
                        name="documents[]"
                        data-max-files="5"
                        accept="application/pdf"     
                        @if($member->documents->count() > 0)
                            data-documents="{{ json_encode($member->documents->map(function($doc) {
                                return [
                                    'source' => asset('storage/' . str_replace('public/', '', $doc->path)),
                                ];
                            })) }}"
                        @endif       
                    >
                </div>
            </div>
            
    
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <span>
                            Modifier les documents
                        </span>
                        <i class="fas fa-upload ms-2"></i>
                    </button>
                </div>
                @if($member->documents->count() > 0)
                    <div class="col-4">
                        <a href="{{ route('admin.members.download-documents', ['user' => $member]) }}" class="btn btn-secondary w-100">
                            <span>
                                Zipper les documents
                            </span>
                            <i class="fas fa-download ms-2"></i>
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}


@endsection

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

