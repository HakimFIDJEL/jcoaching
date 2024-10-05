<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- Favicon with company_logo --}}
        <link rel="icon" href="{{ asset('storage/' . str_replace('public/', '', $company_icon)) }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('storage/' . str_replace('public/', '', $company_icon)) }}" type="image/x-icon" />

        {{-- Meta title & meta description --}}
        <meta name="title" content="@yield('meta_title', $meta_title)">
        <meta name="description" content="@yield('meta_description', $meta_description)">

        {{-- Title --}}

        <title>
            {{ $company_name ?? env('APP_NAME') }} - @yield('title')
        </title>
        
        
        {{-- Import CSS --}}
        <link rel="stylesheet" href="{{ asset('backoffice/css/style.css') }}">
        @vite('resources/css/bootstrap.css')
        @vite('resources/css/line-awesome.min.css')
        @vite('resources/css/swiper.min.css')
        @vite('resources/css/magnific-popup.css')
        
        @yield('styles')

        @include('_elements.color')

    </head>
    <body class="min-vh-100 d-flex flex-column">
        {{-- Import Loader --}}
        @include('jerhome._elements.preloader')

        <main class="main-wrapper">

            
            <div style="max-width:1360px" class="p-4 mx-auto">
                {{-- Import Header --}}
                @include('jerhome._elements.header')

                <div class="container-fluid">
                    {{-- Content  --}}
                    @yield('content')
                </div>
            </div>

            {{-- Import Footer --}}
            @include('jerhome._elements.footer')
            
            
            {{-- Import packages --}}
            @include('jerhome._elements.notyf')
        </main>


        


        {{-- Import JS --}}
        @vite('resources/js/jquery.min.js')
        @vite('resources/js/bootstrap.bundle.min.js')
        {{-- @vite('resources/js/jquery.filterizr.min.js') --}}
        {{-- @vite('resources/js/magnific-popup.min.js') --}}
        {{-- @vite('resources/js/swiper.min.js') --}}
        @vite('resources/js/main.js')
        @vite('resources/js/app.js')

        @vite('resources/js/plugins/notyf.js')
        @vite('resources/js/plugins/swal.js')
        
        @yield('scripts')

        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "LocalBusiness",
              "name": "{{ $company_name }}",
              "image": "{{ asset('storage/' . str_replace('public/', '', $company_icon)) }}",
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