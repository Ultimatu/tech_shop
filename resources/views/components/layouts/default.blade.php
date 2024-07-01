{{--  file : resources/views/layouts/default.blade.php  --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- seo --}}
    <meta name="description" content="TechShop, la boutique en ligne de produits high-tech">
    <meta name="keywords" content="techshop, high-tech, boutique en ligne">
    <meta name="author" content="TechShop">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="15 days">
    <meta name="language" content="fr">
    <meta name="publisher" content="TechShop">
    
    <title>{{  $title ?? 'TechShop' }}</title>

    @vite(['resources/js/app.js'])
    <!-- Inclure le CSS Bootstrap -->
    <link href="{{ $webSiteInfo? $webSiteInfo->image_favicon : asset('assets/img/favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />  
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/slick/slick-theme.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('css')

</head>

<body>
    {{--  header  --}}
    <x-partials.header />

    {{--  content  --}}
    {{ $slot }}
    
        {{--  call to action  --}}
    <x-partials.call-to-action />

    {{--  footer  --}}
    <x-partials.footer />

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- Inclure le script de Bootstrap -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/slick/slick.min.js') }}"></script>
    {{-- template js --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('js')
</body>

</html>



