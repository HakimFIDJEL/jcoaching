@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}


@php 
    $fullcalendar_users          = collect([$member]);
    $fullcalendar_workouts       = $workouts;
    $fullcalendar_rest_periods   = $rest_periods;
    $update_workout_route        = route('admin.calendar.workouts.update');
@endphp


{{-- Calendar --}}
@include('_elements.calendar')
{{-- /Calendar --}}



@endsection

@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection

