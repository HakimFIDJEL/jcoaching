@extends('member._elements.layout')

@section('title', 'Calendrier')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('member.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('member.calendar.index') }}">Calendrier</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifier</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


@php 
    $calendar_route = route('member.calendar.index');
@endphp


{{-- Calendar --}}
@include('_elements.calendar_notify')
{{-- /Calendar --}}


@endsection



