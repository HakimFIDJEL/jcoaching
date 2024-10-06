<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Favicon with company_logo --}}

        <link rel="icon" href="{{ Storage::url($company_icon) }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ Storage::url($company_icon) }}" type="image/x-icon" />

         {{-- Meta title & meta description --}}
        <meta name="title" content="@yield('meta_title', $meta_title)">
        <meta name="description" content="@yield('meta_description', $meta_description)">

        {{-- Title --}}

        <title>
            {{ $company_name ?? env('APP_NAME') }} - @yield('title')
        </title>
        
        {{-- Import CSS --}}
        {{-- @vite('resources/css/bootstrap.css')
        @vite('resources/css/line-awesome.min.css')
        @vite('resources/css/swiper.min.css')
        @vite('resources/css/magnific-popup.css')
        @vite('resources/css/style.css') --}}

    
        <link href="{{ asset('backoffice/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('backoffice/vendor/jquery-nice-select/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('backoffice/css/style.css') }}">
        @vite('resources/css/bootstrap.css')

        @yield('styles')

        @include('_elements.color')


    </head>
    <body >
        {{-- Import Loader --}} @include('admin._elements.preloader')

        <div id="main-wrapper">
            {{-- Import Nav Header --}} @include('admin._elements.navheader')

            {{-- Import Chatbox --}} @include('_elements.chatbox')

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
        <script src="{{ asset('backoffice/vendor/datatables/js/jquery.dataTables.min.js') }}" defer></script>
        <script src="{{ asset('backoffice/js/plugins-init/datatables.init.js') }}" defer></script>
        @vite('resources/js/app.js')
        
        @vite('resources/js/plugins/chatbox.js')
        @vite('resources/js/plugins/filepond.js')
        @vite('resources/js/plugins/notyf.js')
        @vite('resources/js/plugins/swal.js')


        @yield('scripts')

        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "LocalBusiness",
              "name": "{{ $company_name }}",
              "image": "{{ Storage::url($company_icon) }}",
              "@id": "{{ url('/') }}",
              "url": "{{ url('/') }}",
              "telephone": "{{ $company_phone }}",
              "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ $company_address }}",
                "addressLocality": "Villeneuve d'Ascq",
                "postalCode": "59650",
                "addressCountry": "FR"
              },
              "openingHours": "Mo-Su 10:00-19:00",
              "sameAs": [
                "{{ $company_facebook }}",
                "{{ $company_twitter }}",
                "{{ $company_instagram }}",
                "{{ $company_linkedin }}",
                "{{ $company_youtube }}",
              ]
            }
        </script>
    </body>
    
</html>