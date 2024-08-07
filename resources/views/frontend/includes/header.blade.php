<!DOCTYPE html>
<html lang="en">

<head>
    <title>SportVote</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:wght@100;200;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ url('frontend/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/owl.theme.default.min.css') }}">
    <!-- Vendor CSS Files -->
    <link href="{{ url('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Dev Files -->
    <link rel="stylesheet" href="{{ url('frontend/css/customcss.css') }}">
    <link href="{{ url('frontend/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap-multiselect.css') }}">
    </link>

    <link rel="stylesheet" href="{{ url('frontend/css/shagun_custom.css') }}">

    <link rel="stylesheet" href="{{ url('frontend/css/style.css') }}">

    @livewireStyles
</head>

<body>
    <div class="site-wrap">

        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>
        {{-- @if (Route::has('login')) --}}
        @auth
            @include('frontend.includes.navlogin')
        @else
            @include('frontend.includes.nav')
        @endauth
        {{-- @endif --}}
        