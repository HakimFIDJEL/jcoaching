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


 {{-- <form action="{{ route('admin.calendar.search') }}" method="POST">
        @csrf
    
        <div class="mb-3">
            <label for="user" class="form-label">Sélectionner un utilisateur</label>
            <select class="default-select form-control wide mb-3" name="user" id="user">
                <option value="" @if(!$user) selected @endif>Tous</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @if($user && $user->id == $member->id) selected @endif>
                        {{ $member->firstname }} {{ $member->lastname }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">
            <span>Voir les séances</span>
            <i class="fa fa-eye ms-2"></i>
        </button>
    </form>

    <hr> --}}



{{-- Calendar --}}
@include('_elements.calendar.index')
{{-- /Calendar --}}


@endsection


@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection

