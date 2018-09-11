<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <meta name="description" content="">
    <meta name="author" content="Jeremy Kenedy">
    <link rel="shortcut icon" href="/favicon.ico">

    {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    {{-- Styles --}}
    {{--        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/half-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('css/resCarousel.css') }}" rel="stylesheet">
    <link href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">

    @yield('template_linked_css')

    <style type="text/css">
        body{
            background: #ffffff;
        }
        @yield('template_fastload_css')

            @if (Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0))
                .user-avatar-nav {
            background: url({{ Gravatar::get(Auth::user()->email) }}) 50% 50% no-repeat;
            background-size: auto 100%;
        }
        @endif

    </style>

    {{-- Scripts --}}
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>

    @if (Auth::User() && (Auth::User()->profile) && $theme->link != null && $theme->link != 'null')
        <link rel="stylesheet" type="text/css" href="{{ $theme->link }}">
    @endif

<!-- This makes the current user's id available in javascript -->
    @if(!auth()->guest())
        <script>
            window.Laravel.userId = <?php echo auth()->user()->id; ?>
        </script>
    @endif

    @yield('head')

</head>
<body>
<div id="app">

{{--    @include('partials.nav')--}}
    @if (Request::is('login') || Request::is('register'))
        <div class="container">

            @include('partials.form-status')

        </div>
        @yield('content')

    @else

        @include('partials._includes.nav.main')
        @include('partials._includes.nav.sec_nav')
        <div class="container">

            @include('partials.form-status')

        </div>

        @yield('content')

    @endif

</div>

{{-- Scripts --}}
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/dropzone.js') }}"></script>
<script src="{{ asset('js/resCarousel.js') }}"></script>
<script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>

@if(config('settings.googleMapsAPIStatus'))
    {!! HTML::script('//maps.googleapis.com/maps/api/js?key='.config("settings.googleMapsAPIKey").'&libraries=places&dummy=.js', array('type' => 'text/javascript')) !!}
@endif

@yield('footer_scripts')
<script>
    const navBurger = document.getElementById('nav-burger-btn');

    navBurger.onclick = function () {
        this.classList.toggle('is-active');
        document.getElementById('navMenu').classList.toggle('is-active')
    };

</script>

<script>
    const app = new Vue({
        el: '#app',
        data: {

        },
        components:{
            name :'products-table'
        }
    })
</script>

</body>
</html>
