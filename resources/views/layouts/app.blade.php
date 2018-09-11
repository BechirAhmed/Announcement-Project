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
    <meta name="author" content="Rim Academy Group">
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
    <link href="{{ asset('css/reset.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="https://unpkg.com/buefy/lib/buefy.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-notifications.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/skins/line/red.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/skins/line/blue.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/skins/square/green.css') }}">


    @yield('template_linked_css')

    <style type="text/css">
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

    <!-- This makes the current user's id available in javascript -->
    @if(!auth()->guest())
        <script>
            window.Laravel.userId = <?php echo auth()->user()->id; ?>
        </script>
    @endif

    @if (Auth::User() && (Auth::User()->profile) && $theme->link != null && $theme->link != 'null')
        <link rel="stylesheet" type="text/css" href="{{ $theme->link }}">
    @endif

    @yield('head')

</head>
<body>
<div id="app">

    @include('partials.nav')

        {{--@include('partials._includes.nav.main')--}}
        {{--@include('partials._includes.nav.sec_nav')--}}
        {{--<div class="container is-fluid">--}}
            {{--<div class="columns">--}}
                {{--<div class="column is-3">--}}
    @role('admin')
        @include('partials._includes.nav.sideNav')
    @endrole
                <div class="@role('admin', true) management-area  @endrole m-t-50">
                    @include('partials.form-status')
                    @yield('content')
                </div>
            {{--</div>--}}
        {{--</div>--}}



</div>

{{-- Scripts --}}
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/prefixfree.min.js') }}"></script>
<script src="{{ asset('js/icheck.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>
<script src="https://unpkg.com/buefy"></script>
{{--<script src="//js.pusher.com/3.1/pusher.min.js"></script>--}}
{{--@if(config('settings.googleMapsAPIStatus'))--}}
    {{--{!! HTML::script('//maps.googleapis.com/maps/api/js?key='.config("settings.googleMapsAPIKey").'&libraries=places&dummy=.js', array('type' => 'text/javascript')) !!}--}}
{{--@endif--}}

@yield('footer_scripts')
<script>
    const app = new Vue({
        el: '#app',
        data: {

        }
    });
</script>
<script>
    const accordions = document.getElementsByClassName('has-submenu');
    const adminSlidOutBtn = document.getElementById('admin-slideout-btn');
//    const xsNotifyBtn = document.getElementById('notifications');
//    const xsProfBtn = document.getElementById('xsProfileDropBtn');


    function setSubmenuStyles(submenu, maxHeight, margins) {
        submenu.style.maxHeight = maxHeight
        submenu.style.marginTop = margins
        submenu.style.marginBottom = margins
    }

     adminSlidOutBtn.onclick = function () {
         this.classList.toggle('is-active');
         document.getElementById('admin-side-menu').classList.toggle('is-active')
     };
//
//     xsNotifyBtn.onclick = function () {
//       document.getElementById('xsNotify').classList.toggle('is-hidden')
//     };
//     xsProfBtn.onclick = function () {
//         document.getElementById('profileDrop').classList.toggle('is-hidden')
//     };

    for (var i = 0; i < accordions.length; i++) {
         if (accordions[i].classList.contains('is-active')) {
             const submenu = accordions[i].nextElementSibling;
             setSubmenuStyles(submenu, submenu.scrollHeight + "px", "0.75em")
         }

        accordions[i].onclick = function() {
            this.classList.toggle('is-active');

            const submenu = this.nextElementSibling;
            if (submenu.style.maxHeight) {
                // menu is open, we need to close it now
                setSubmenuStyles(submenu, null, null);
                $('.mdi-chevron-down').css({
                    transform: 'rotate(0deg)',
                    transition: 'all 0.3s ease-in-out'
                });
            } else {
                // menu is close, we need to open it now
                 setSubmenuStyles(submenu, submenu.scrollHeight + "px", "0.75em");
                $('.mdi-chevron-down').css({
                    transform: 'rotate(180deg)',
                    transition: 'all 0.3s ease-in-out'
                });
            }
        }
    }

</script>
<script>

//    var notifications = [];
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('i[data-count]');
    var notificationsCount     = parseInt(notificationsCountElem.data('count'));
    var notifications          = notificationsWrapper.find('ul.dropdown-menu');

    if (notificationsCount <= 0) {
        notificationsWrapper.hide();
    }

    Pusher.logToConsole = true;

    const NOTIFICATION_TYPES = {
        follow: 'App\\Notifications\\UserFollowed',
        newProduct: 'App\\Notifications\\NewProduct'
    };

    $(document).ready(function() {
        // check if there's a logged in user
        if(Laravel.userId) {
            $.get('/notifications', function (data) {
                addNotifications(data, "#notifications");
            });
            window.Echo.private(`App\\Models\\User.${Laravel.userId}`)
                .notification((notification) => {
                    addNotifications([notification], '#notifications');
                });
        }
        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
    });

    function addNotifications(newNotifications, target) {
        notifications = _.concat(notifications, newNotifications);
        // show only last 5 notifications
        notifications.slice(0, 5);
        showNotifications(notifications, target);
    }
    function showNotifications(notifications, target) {
        if(notifications.length) {
            var htmlElements = notifications.map(function (notification) {
                return makeNotification(notification);
            });
            $(target + 'Menu').html(htmlElements.join(''));
            $(target).addClass('has-notifications');
        } else {
            $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
            $(target).removeClass('has-notifications');
        }
    }

    // Make a single notification string
    function makeNotification(notification) {
        var to = routeNotification(notification);
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var notificationText = makeNotificationText(notification);
        return `
                <li class="notification">
                    <a href="` + to + `" style="text-decoration: none">
                        <div class="media">
                            <div class="media-left">
                              <div class="media-object">
                                <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px; max-height: 50px;">
                              </div>
                            </div>
                            <div class="media-body">
                              <strong class="notification-title">`+notificationText+`</strong>
                              <!--p class="notification-desc">Extra description can go here</p-->
                              <div class="notification-meta">
                                <small class="timestamp">about a minute ago</small>
                              </div>
                            </div>
                        </div>
                    </a>
                </li>`;
    }

    // get the notification route based on it's type
    function routeNotification(notification) {
        var to = '?read=' + notification.id;
        if(notification.type === NOTIFICATION_TYPES.follow) {
            to = 'users' + to;
        } else if(notification.type === NOTIFICATION_TYPES.newProduct) {
            const productId = notification.data.product_id;
            to = `products/show/${productId}` + to;
        }
        return '/' + to;
    }

    // get the notification text based on it's type
    function makeNotificationText(notification) {
        var text = '';
        if(notification.type === NOTIFICATION_TYPES.follow) {
            const name = notification.data.follower_name;
//            const date = notification.data.follower_date;
            text += '<strong>' + name + '</strong> followed you';
        } else if(notification.type === NOTIFICATION_TYPES.newProduct) {
            const name = notification.data.following_name;
            text += '<strong>' + name + '</strong> added a new product';
        }
        return text;
    }
</script>
<script>
//    $('.thumbnail').on('click', function() {
//        var clicked = $(this);
//        var newSelection = clicked.data('big');
//        var $img = $('.primary').css("background-image","url(" + newSelection + ")");
//        clicked.parent().find('.thumbnail').removeClass('selected');
//        clicked.addClass('selected');
//        $('.primary').empty().append($img.hide().fadeIn('slow'));
//    });
</script>
</body>
</html>
