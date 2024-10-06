@extends('admin._elements.layout')

@section('title', 'Ordres d\'achats')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Ordres d'achats</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


{{-- Page content --}}
<div class="card border border-4 border-primary">


    {{-- Content Header --}}
    <div class="card-header border-bottom border-primary flex-column align-items-start p-4">
        <div class="card-title d-flex justify-content-between w-100 align-items-center">
            <h4 class="mb-0">
                Les ordres d'achats
            </h4>
        </div>
        <div class="card-description">
            <p class="text-muted  mb-0 font-weight-light">
                Depuis cet espace, vous pouvez consulter les ordres d'achats des clients.
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
                        <th>Utilisateur</th>
                        <th>Relation - Type</th>
                        <th>Relation - ID</th>
                        <th>Prix HT</th>
                        <th>Prix TTC</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                @switch($order->status)
                                    @case(0)
                                        <span class="badge badge-warning">
                                            <span>
                                                En attente
                                            </span>
                                            <i class="fa fa-spinner fa-spin ms-1"></i>
                                        </span>
                                        @break
                                    @case(1)
                                        <span class="badge badge-success">
                                            <span>
                                                Terminé
                                            </span>
                                            <i class="fa fa-check ms-1"></i>
                                        </span>
                                        @break
                                    @case(-1)
                                        <span class="badge badge-danger">
                                            <span>
                                                Annulé
                                            </span>
                                            <i class="fa fa-times ms-1"></i>
                                        </span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">
                                            <span>
                                                Inconnu
                                            </span>
                                            <i class="fa fa-question ms-1"></i>
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.members.edit', ['user' => $order->user]) }}" class="text-decoration-underline">
                                    {{ $order->user->firstname }} {{ $order->user->lastname }}
                                </a>
                            </td>
                            <td>
                                @if($order->product_type == 'workout')
                                    <span class="badge bg-secondary">
                                        <span>
                                            Séance (s)
                                        </span>
                                        <i class="fas fa-dumbbell ms-1"></i>
                                    </span>
                                @elseif($order->product_type == 'plan')
                                    <span class="badge bg-primary">
                                        <span>
                                            Abonnement
                                        </span>
                                        <i class="fas fa-file-alt ms-1"></i>
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <span>
                                            Inconnu
                                        </span>
                                        <i class="fas fa-question ms-1"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($order->product_type == 'workout')
                                    [
                                        @foreach($order->workouts as $workout)
                                            #{{ $workout->id ?? 'Inconnu' }} 
                                        @endforeach
                                    ]
                                @elseif($order->product_type == 'plan')
                                    #{{ $order->plan->id ?? 'Inconnu' }}
                                @else
                                    Inconnu
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary text-black">

                                    {{ $order->price_ht }} &euro;
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary text-black">

                                    {{ $order->price_ttc }} &euro;
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/y - H:i') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a title="Lire la description de l'ordre d'achat" href="javascript:void(0);" class="btn btn-outline-primary shadow btn-xs sharp mr-1 read-description" data-description="{{ $order->description }}"><i class="fa fa-eye"></i></a>
                                    @if($order->invoice)
                                        <a title="Visualiser la facture" href="{{ Storage::url($order->invoice->path) }}" target="_blank" class="btn btn-outline-secondary shadow btn-xs sharp mr-1"><i class="fa fa-file-pdf"></i></a>
                                    @endif
                                    <a title="Supprimer l'ordre d'achat" href="{{ route('admin.orders.delete', ['order' => $order]) }}" class="btn btn-outline-danger shadow btn-xs sharp delete-row"><i class="fa fa-trash"></i></a>
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

