<nav class="navbar" role="navigation" aria-label="dropdown navigation">
    <div class="navbar-brand ">

        {{-- Branding Image --}}
        <a class="navbar-item" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Expat-nktt">
            {{--{!! config('app.name', Lang::get('titles.app')) !!}--}}
        </a>


    </div>
    <button class="button navbar-burger" data-target="navMenu" id="nav-burger-btn">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="navbar-menu" id="navMenu">
        <div class="navbar-start">

            <div class="search-box">
                <select class="select filter" id="region_id" name="region_id">
                    <option value="1" selected>All</option>
                    @foreach ($regions as $key => $region)
                        <option value="{{ $key }}" id="region_id" {{ old('region_id', optional($region)->id) == $key ? 'selected' : '' }}>
                            {{ $region }}
                        </option>
                    @endforeach
                </select>
                {{--<select class="select filter" id="region_id" name="region_id">--}}
                    {{--<option value="" {{ old('region_id', optional($product)->region_id ?: '') == '' ? 'selected' : '' }} selected>All</option>--}}
                    {{--@foreach ($regions as $key => $region)--}}
                        {{--<option value="{{ $key }}" {{ old('region_id', optional($product)->region_id) == $key ? 'selected' : '' }}>--}}
                            {{--{{ $region }}--}}
                        {{--</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
                <form action="{{ url('search') }}" method="GET">
                    {{--{{ csrf_token() }}--}}
                    <?php
                        if(Request::is('search')){
                            $s = $_GET['s'];
                        } else {
                            $s="";
                        }
                    ?>
                    <input type="search" class="input" name="s" value="{{$s}}" placeholder="Search for your favorite product...">
                    <button type="submit" class="button is-success link-noUnderline">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="navbar-end">
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                    {{--<i class="fa fa-language"></i> {{ strtoupper(App::getLocale()) }} <span class="caret"></span>--}}
                {{--</a>--}}

                {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--@foreach(config('app.locales') as $key => $value)--}}
                        {{--<li><a href="/{{ $key }}/{{ substr(Request::path(), 3) }}">{{ $value }}</a></li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}

            {{--</li>--}}
            @guest
                <div class="navbar-item">
                    <a href="{{ route('login') }}" class="navbar-item is-tab link-noUnderline">
                        <i class="fa fa-sign-in"></i>
                    </a>
                    <a href="{{ route('register') }}" class="navbar-item is-tab link-noUnderline">Join Our Community</a>
                </div>

            @else

                <div class="navbar-item has-dropdown is-hoverable" style="width: 50px">
                    <a href="#" class="notify">
                        <i class="far fa-bell"></i>
                    </a>

                    <div class="navbar-dropdown is-right">
                        <div class="noti"></div>
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link link-noUnderline">
                        @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                            <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                        @else
                            <div class="user-avatar-nav"></div>
                        @endif

                        {{ Auth::user()->name }}
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
