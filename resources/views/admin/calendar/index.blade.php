@extends('admin._elements.layout')

@section('title', 'Calendrier')


@section('content')

{{-- Breadcrumbs --}}
<div class="row page-titles mb-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        @if($user)
            <li class="breadcrumb-item"><a href="{{ route('admin.members.edit', ['user' => $user]) }}">{{ $user->firstname }} {{ $user->lastname }}</a></li>
        @endif
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Calendrier</a></li>
    </ol>
</div>
{{-- /Breadcrumbs --}}




{{-- Calendar --}}
@include('_elements.calendar.index')
{{-- /Calendar --}}


@endsection


@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection

