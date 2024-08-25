<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>
            {{ env('APP_NAME') }} - @yield('title')
        </title>
        
        {{-- Import CSS --}}
        {{-- @vite('resources/css/bootstrap.css')
        @vite('resources/css/line-awesome.min.css')
        @vite('resources/css/swiper.min.css')
        @vite('resources/css/magnific-popup.css')
        @vite('resources/css/style.css') --}}

    
        <link rel="stylesheet" href="{{ asset('backoffice/vendor/jquery-nice-select/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('backoffice/css/style.css') }}">
        @vite('resources/css/bootstrap.css')

        @yield('styles')


    </head>
    <body >
        {{-- Import Loader --}} @include('admin._elements.preloader')

        <div id="main-wrapper">
            {{-- Import Nav Header --}} @include('admin._elements.navheader')
    
            {{-- Import Header --}} @include('admin._elements.header')
        
            {{-- Import Sidebar --}} @include('admin._elements.sidebar')
        
            {{-- Content  --}}
            <div class="content-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            
            {{-- Import Footer --}} @include('admin._elements.footer')
        
            {{-- Import packages --}} @include('admin._elements.notyf')
        </div>
    

        {{-- Import JS --}}
        @vite('resources/js/jquery.min.js')
        <script src="{{ asset('backoffice/vendor/global/global.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/js/custom.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/js/deznav-init.js') }}" defer></script>
        @vite('resources/js/app.js')



        @yield('scripts')
    </body>
    
</html>