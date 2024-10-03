@extends('jerhome._elements.layout')

@section('title', 'Galerie')

@section('meta_title', 'Galerie Photos/Vidéos - JerHomeCoaching')
@section('meta_description', 'Découvre en images mes séances de coaching. Inspire-toi de mes clients motivés et
    rejoins-nous pour transformer ta vie !')

@section('content')

    <div class="container my-5 gallery pb-5" id="gallery">
        <div class="mb-5">
            <hr>
            <h1 class="text-center text-primary fw-bold">
                Galerie
            </h1>
            <p class="fw-light mb-0 text-center">
                Découvrez les photos et vidéos des séances
            </p>
            <hr>
        </div>
        <div class="row pt-4" data-masonry='{"percentPosition": true }'>

            @foreach ($medias as $media)
                @if ($media->type == 'image/jpeg' || $media->type == 'image/png' || $media->type == 'image/jpg')
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <a href="{{ asset('storage/' . str_replace('public/', '', $media->path)) }}" class="popup-image">
                            <img src="{{ asset('storage/' . str_replace('public/', '', $media->path)) }}"
                                class="img-fluid rounded" alt="{{ $media->name }}" title="{{ $media->label }}"
                                alt="{{ $media->label }}">
                        </a>
                    </div>
                @elseif($media->type == 'video/mp4' || $media->type == 'video/webm')
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <a href="{{ asset('storage/' . str_replace('public/', '', $media->path)) }}" class="popup-image">
                            <video width="320" height="240" controls>
                                <source src="{{ asset('storage/' . str_replace('public/', '', $media->path)) }}"
                                    type="{{ $media->type }}" title="{{ $media->label }}" alt="{{ $media->label }}">
                                Your browser does not support the video tag.
                            </video>
                        </a>
                    </div>
                @else
                @endif
            @endforeach


        </div>
    </div>



@endsection


@section('scripts')
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
@endsection
