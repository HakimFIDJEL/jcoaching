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
        <link href="{{ asset('backoffice/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        @vite('resources/css/bootstrap.css')

        @yield('styles')


    </head>
    <body >
        {{-- Import Loader --}} @include('member._elements.preloader')

        <div id="main-wrapper">
            {{-- Import Nav Header --}} @include('member._elements.navheader')
    
            {{-- Import Header --}} @include('member._elements.header')
        
            {{-- Import Sidebar --}} @include('member._elements.sidebar')
        
            {{-- Content  --}}
            <div class="content-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            
            {{-- Import Footer --}} @include('member._elements.footer')
        
            {{-- Import packages --}} @include('member._elements.notyf')
        </div>
    

        {{-- Import JS --}}
        @vite('resources/js/jquery.min.js')
        <script src="{{ asset('backoffice/vendor/global/global.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/js/custom.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/js/deznav-init.js') }}" defer></script>
        <script src="{{ asset('backoffice/vendor/datatables/js/jquery.dataTables.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/js/plugins-init/datatables.init.js') }}" defer></script>
        @vite('resources/js/app.js')

        @vite('resources/js/plugins/notyf.js')
        @vite('resources/js/plugins/swal.js')


        @yield('scripts')
    </body>
    
</html>