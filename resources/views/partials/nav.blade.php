<nav class="navbar is-fixed-top-desktop" role="navigation" aria-label="dropdown navigation">
    <div class="navbar-brand ">

        {{-- Branding Image --}}
        <a class="navbar-item" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="{!! config('app.name', Lang::get('titles.app')) !!}">
        </a>


    </div>

    <div class="navbar-xs-item is-pulled-right is-hidden-desktop">
        @guest
            <a href="{{ route('login') }}" class="xs-notify link-noUnderline">
                <i class="fa fa-sign-in"></i>
            </a>

        @else
            <ul class="xs-item">
                {{--<li class="dropdown-notifications">--}}
                    {{--<a class="xs-notify" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
                        {{--<i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li>
                    <a data-target="profileDrop" class="xs-notify link-noUnderline" id="xsProfileDropBtn">
                        @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                            <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                        @else
                            <div class="user-avatar-nav"></div>
                        @endif
                    </a>
                </li>
            </ul>

            <div class="prof-xs-dropdown is-hidden" id="profileDrop">
                <div class="menu">
                    <div class="dropdown-content">
                        <a href="{{ url('/profile/'.Auth::user()->name) }}" class="dropdown-item link-noUnderline dropdownMenu" {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'class=active' : null }}>
                            {!! trans('titles.profile') !!}
                        </a>
                        <a href="{{ route('public.home') }}" class="dropdown-item link-noUnderline dropdownMenu">
                            Manage
                        </a>
                        <hr class="dropdown-divider">
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item link-noUnderline dropdownMenu">
                            {!! trans('titles.logout') !!}
                        </a>
                    </div>
                </div>
            </div>
            {{--<div class="not-xs-dropdown" id="xsNotify">--}}
                {{--<div class="dropdown-container">--}}
                    {{--<div class="dropdown-toolbar">--}}
                        {{--<div class="dropdown-toolbar-actions">--}}
                            {{--<a href="#">Mark all as read</a>--}}
                        {{--</div>--}}
                        {{--<h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>--}}
                    {{--</div>--}}
                    {{--<ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">--}}
                        {{--<li class="dropdown-header">No notifications</li>--}}
                    {{--</ul>--}}
                    {{--<div class="dropdown-footer text-center">--}}
                        {{--<a href="#">View All</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        @endguest

    </div>

    <div class="navbar-menu" id="navMenu">
        <div class="navbar-end">
            @guest
                <div class="navbar-item">
                    <a href="{{ route('login') }}" class="navbar-item is-tab link-noUnderline">
                        <i class="fa fa-sign-in"></i>
                    </a>
                    <a href="{{ route('register') }}" class="navbar-item is-tab link-noUnderline">Join Our Community</a>
                </div>

            @else
                <div class="navbar-item">
                    <ul>
                        <li class="dropdown dropdown-notifications">
                            <a class="dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
                            </a>
                            <div class="dropdown-container">
                                <div class="dropdown-toolbar">
                                    <div class="dropdown-toolbar-actions">
                                        <a href="#">Mark all as read</a>
                                    </div>
                                    <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">
                                    <li class="dropdown-header">No notifications</li>
                                </ul>
                                <div class="dropdown-footer text-center">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link link-noUnderline">
                        @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                            <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                        @else
                            <div class="user-avatar-nav"></div>
                        @endif

                        {{ Auth::user()->full_name }}
                    </a>

                    <div class="navbar-dropdown is-right">
                        <a href="{{ url('/profile/'.Auth::user()->name) }}" class="navbar-item link-noUnderline" {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'class=active' : null }}>
                            {!! trans('titles.profile') !!}
                        </a>
                        <a href="{{ route('public.home') }}" class="navbar-item link-noUnderline">
                            Manage
                        </a>
                        <hr class="navbar-divider">
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="navbar-item link-noUnderline">
                            {!! trans('titles.logout') !!}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

            @endguest

        </div>
    </div>

</nav>