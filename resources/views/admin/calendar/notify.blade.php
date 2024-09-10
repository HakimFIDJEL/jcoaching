@extends('admin._elements.layout')

@section('title', 'Notifier les utilisateurs')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.calendar.index') }}">Calendrier</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifier</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}



{{-- Calendar --}}
@include('_elements.calendar.notify')
{{-- /Calendar --}}


@endsection



@section('scripts')
    @vite('resources/js/pages/calendar.js')
@endsection