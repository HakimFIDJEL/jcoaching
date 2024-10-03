@extends('admin._elements.layout')

@section('title', 'Contatcs')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $contact->subject }}</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
               <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="right-box-padding">
                                        <div class="read-content">
                                            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary px-3 my-1 me-2">
                                                <i class="fa fa-arrow-left me-2"></i>
                                                <span>
                                                    Retour
                                                </span>
                                            </a>
                                            <div class="media pt-3 d-sm-flex d-block justify-content-between">
                                                
                                                <div class="clearfix mb-3 d-flex">
                                                    <div class="media-body me-2">
                                                        <h5 class="text-primary mb-0 mt-1">{{ $contact->lastname }} {{ $contact->firstname }}</h5>
                                                        <p class="mb-0">
                                                            {{ $contact->created_at->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="clearfix mb-3">

                                                    <a href="mailto:{{ $contact->email }}" class="btn btn-primary px-3 my-1 me-2">
                                                        <span class="d-none d-sm-inline mr-2">Répondre</span>
                                                        <i class="fa fa-reply"></i> 
                                                    </a>
                                                    <a href="{{ route('admin.contacts.soft-delete', ['contact' => $contact]) }}" class="btn btn-danger px-3 my-1 me-2 warning-row">
                                                        <span class="d-none d-sm-inline mr-2">Mettre à la corbeille</span>
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="media mb-2 mt-3">
                                                <div class="media-body"><span class="pull-end">{{ $contact->created_at->format('H:i') }}</span>
                                                    <h5 class="my-1 text-primary">{{ $contact->subject }}</h5>
                                                </div>
                                            </div>
                                            <div class="read-content-body">
                                                <p>{!! $contact->message !!}</p>
                                            </div>
                                            <hr>
                                            
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
                
            </div>
        </div>
    </div>
</div>
{{-- /Page content --}}
@endsection

