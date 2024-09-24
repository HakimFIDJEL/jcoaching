@extends('admin._elements.layout')

@section('title', 'Les utilisateurs ayant utilisé le code de réduction')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.reductions.index') }}">Réductions</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Les membres associés</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}

@include('admin.reductions._elements.edit_header')


{{-- Page content --}}
<div class="card border border-4 border-primary">

   

     {{-- Content Header --}}
     <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Liste des utilisateurs
            </h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez modifier les membres ayant utilisé le code de réduction.
            </p>
        </div>
    </div>
    {{-- /Content Header --}}


    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">
        <table class="datatable">
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Nom
                    </th>
                    <th>
                        Associé
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>
                            #{{ $member->id }}
                        </td>
                        <td>
                            <a href="{{ route('admin.members.edit', ['user' => $member]) }}" class="text-decoration-underline">
                                {{ $member->firstname }} {{ $member->lastname }}
                            </a>
                        </td>
                        <td>
                            @if($member->hasUsedReduction($reduction->id))
                                <span class="badge bg-success">
                                    <span>
                                        Oui
                                    </span>
                                    <i class="fas fa-check ms-2"></i>
                                </span>
                            @else 
                                <span class="badge bg-danger">
                                    <span>
                                        Non
                                    </span>
                                    <i class="fas fa-times ms-2"></i>
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($member->hasUsedReduction($reduction->id))
                                {{ $member->getDateOfUsageReduction($reduction->id) }}
                            @else 
                                <span class="badge bg-secondary">
                                    <span>
                                        Pas de date
                                    </span>
                                    <i class="fas fa-times ms-2"></i>
                                </span>
                            @endif

                        </td>
                        <td>
                            @if($member->hasUsedReduction($reduction->id))
                                <a 
                                    href="{{ route('admin.reductions.unlink', ['reduction' => $reduction, 'user' => $member]) }}" 
                                    class="btn btn-danger btn-sm"
                                >
                                    <span>
                                        Dissocier
                                    </span>
                                    <i class="fas fa-unlink ms-2"></i>
                                </a>
                            @else
                                <a 
                                    href="{{ route('admin.reductions.link', ['reduction' => $reduction, 'user' => $member]) }}" 
                                    class="btn btn-primary btn-sm"
                                >
                                    <span>
                                        Associer
                                    </span>
                                    <i class="fas fa-link ms-2"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}
@endsection

