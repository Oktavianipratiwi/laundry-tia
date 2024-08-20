<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tia Laundry</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/laundry.png') }}" />

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/progressbar_barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-landing-page/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
</head>
<body>
    @include('landing-page/preloader')

    @include('landing-page/header')

    @include('landing-page/slider')

    @include('landing-page/services')

    @include('landing-page/offer-services')

    @include('landing-page/about')

    @include('landing-page/map')

    @include('landing-page/footer')

    @include('landing-page/javascript')

</body>
</html>

