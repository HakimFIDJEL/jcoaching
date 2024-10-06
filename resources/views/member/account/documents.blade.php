@extends('member._elements.layout')

@section('title', 'Mon profil')


@section('content')

{{-- Page Header --}}
@include('member.account._elements.edit_header')
{{-- /Page Header --}}



{{-- Page content --}}
<div class="card border border-4 border-primary">

    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title">
            <h4 class="mb-0">Votre espace documents</h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous avez la possibilité de télécharger les documents associés à votre compte, renseignés par les administrateurs.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}

    {{-- Content Body --}}
    <div class="card-body">
    
            <div class="row">
                <div class="col">
                    <label for="documents[]" class="form-label">Documents (5 maximum)</label>
                    <input 
                        type="file"
                        disabled
                        class="filepond"
                        id="documents[]"
                        name="documents[]"
                        data-max-files="5"
                        accept="application/pdf"     
                        @if(Auth::user()->documents->count() > 0)
                            data-documents="{{ json_encode($member->documents->map(function($doc) {
                                return [
                                    'source' => Storage::url($doc->path),
                                ];
                            })) }}"
                        @endif       
                    >
                </div>
            </div>
            
            <div class="row">
                @if($member->documents->count() > 0)
                    <div class="col">
                        <a href="{{ route('member.account.download-documents') }}" class="btn btn-secondary w-100">
                            <span>
                                Zipper les documents
                            </span>
                            <i class="fas fa-download ms-2"></i>
                        </a>
                    </div>
                @endif
            </div>

    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}


@endsection

@section('scripts')
    @vite('resources/js/plugins/filepond.js')
@endsection

