@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}


{{-- Calendar --}}
@include('_elements.calendar.notify')
{{-- /Calendar --}}



@endsection

@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection

