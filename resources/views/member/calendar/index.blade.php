@extends('member._elements.layout')

@section('title', 'Calendrier')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('member.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Calendrier</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}


@php 
    $fullcalendar_users          = collect([Auth::user()]);
    $fullcalendar_workouts       = $workouts;
    $fullcalendar_rest_periods   = $rest_periods;
    $update_workout_route        = route('member.calendar.workouts.update');
@endphp


{{-- Calendar --}}
@include('_elements.calendar')
{{-- /Calendar --}}


@endsection


@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection

