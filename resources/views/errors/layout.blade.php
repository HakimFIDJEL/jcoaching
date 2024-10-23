<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
            {{ env('APP_NAME') }} - @yield('title')
        </title>
        
        {{-- Import CSS --}}
        {{-- @vite('resources/css/bootstrap.css')
        @vite('resources/css/line-awesome.min.css')
        @vite('resources/css/swiper.min.css')
        @vite('resources/css/magnific-popup.css')
        @vite('resources/css/style.css') --}}

    
        <link rel="stylesheet" href="{{ asset('backoffice/css/style.css') }}">
        @vite('resources/css/bootstrap.css')

        @yield('styles')


    </head>
    <body class="vh-100">
        

        <div class="authincation h-100">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-md-7">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    



        @yield('scripts')
    </body>
    
</html>