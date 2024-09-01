@extends('admin._elements.layout')

@section('title', 'Modifier ' . $member->firstname . ' ' . $member->lastname)


@section('content')

{{-- Page Header --}}
@include('admin.members._elements.edit_header')
{{-- /Page Header --}}




{{-- Page content --}}
{{-- <div class="card border border-4 border-primary"> --}}
<div class="card">


    {{-- Content Body --}}
    <div class="card-body mb-4 mt-4">

      <div class="row">
        <div class="col-3">

            <div class="row d-flex flex-column gap-2">

                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addWorkout" class="btn btn-outline-primary w-100 h-100 d-flex align-items-center justify-content-center">
                    <span>
                        Ajouter une séance
                    </span>
                    <i class="fas fa-plus ms-2"></i>
                </a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addOffDays" class="btn btn-secondary w-100 h-100 d-flex align-items-center justify-content-center">
                    <span>
                        Ajouter des jours off
                    </span>
                    <i class="fas fa-plus ms-2"></i>
                </a>
            </div>


        </div>
        <div class="col">

        </div>
      </div>


            

    </div>
    {{-- /Content Body --}}
</div>
{{-- /Page content --}}

@include('admin.members._elements.workouts_modal')

@endsection

@section('scripts')
    @vite('resources/js/plugins/fullcalendar.js')
@endsection

