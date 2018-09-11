@php

$levelAmount = 'level';

if (Auth::User()->level() >= 2) {
    $levelAmount = 'levels';
}
if (Auth::check()){
    $user = Auth::user();
}
Carbon\Carbon::setLocale('en');
        $now=Carbon\Carbon::now();
        $created_date = Carbon\Carbon::parse($user->created_at);
        $created = $created_date->diffForHumans($now);

@endphp
<div class="">
    <div class="prof-header" style="background: url({{ $user->profile->cover }}) no-repeat; background-size: cover">
        @role('admin', true)
            <b-tag class="m-t-20 m-r-20" type="is-warning is-pulled-right" rounded>Admin Access</b-tag>
        @else
            <b-tag class="m-t-20 m-r-20" type="is-primary is-pulled-right" rounded>User Access</b-tag>
        @endrole
        <div class="avatar">
            <img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="prof-img">
            <a id="editAvatar" class="button link-noUnderline is-hidden">Edit</a>
        </div>
    </div>
    <div class="container">
        <div class="prof-info" @role('user')style="margin: 0.5% 0 6% 6%;" @else style="margin: 0.5% 5% 6% 14%;" @endrole>
            <div class="pull-left">
                <h3 class="store-name">
                    {{ $user->full_name }}
                </h3>
                <p>Created : {{ $created }}</p>
            </div>
            <div class="pull-right">
                @if ($user->profile)
                    @if (Auth::user()->id == $user->id)

                        {{--{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), 'fa fa-fw fa-cog', trans('titles.editProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}--}}

                        <a href="{{ url('/profile/'.Auth::user()->name.'/edit') }}" class="button is-info">Edit Profile</a>
                    @endif
                @else

                    <p>{{ trans('profile.noProfileYet') }}</p>
                    {!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), 'fa fa-fw fa-plus ', trans('titles.createProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}

                @endif

            </div>
        </div>
</div>
<div class="flex-container">
    {{--<section class="hero @role('admin', true) is-info  @endrole @role('user', true) is-primary  @endrole welcome is-small">--}}
        {{--<div class="hero-body">--}}
            {{--@role('admin', true)--}}
                {{--<b-tag type="is-light is-pulled-right" rounded>Admin Access</b-tag>--}}
            {{--@else--}}
                {{--<b-tag type="is-warning is-pulled-right" rounded>User Access</b-tag>--}}
            {{--@endrole--}}
                {{--<h1 class="title">--}}
                    {{--Hello, {{ Auth::user()->full_name }}.--}}
                {{--</h1>--}}
                {{--<h2 class="subtitle">--}}
                    {{--I hope you are having a great day!--}}
                {{--</h2>--}}
        {{--</div>--}}
    {{--</section>--}}
    @role('admin')
        <section class="info-tiles m-t-20">
            <div class="tile is-ancestor has-text-centered">
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">{{ $users }}</p>
                        <p class="subtitle">Users</p>
                    </article>
                </div>
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">{{ $products }}</p>
                        <p class="subtitle">Products</p>
                    </article>
                </div>
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">3.4k</p>
                        <p class="subtitle">Open Orders</p>
                    </article>
                </div>
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">19</p>
                        <p class="subtitle">Exceptions</p>
                    </article>
                </div>
            </div>
        </section>
    @endrole

    @role('user', true)
    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Products</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('products.product.create') }}" class="btn btn-success" title="Create New Product">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        @if(count($userProducts) == 0)
            <div class="panel-body text-center">
                <h4>No Products Available!</h4>
            </div>
        @else

            <div class="container" style="margin-top: 30px">
                <div class="row">
                    @php
                        $nb = 1;
                    @endphp
                    @foreach($userProducts as $product)
                        <div class="col-md-2 prodItem">
                            <a href="{{route('products.product.show', $product->id)}}" class="link-noUnderline" title="Show Product">
                                @foreach($product->subCategories as $subCategory)
                                    @foreach($subCategory->categories as $category)
                                        <span class="catName">{{ $category->name }}</span>
                                    @endforeach
                                @endforeach
                                @foreach($product->subCategories as $subCategory)
                                    <span class="subCatName">{{ $subCategory->name }}</span>
                                @endforeach
                                {{--                                @foreach($photos as $photo)--}}
                                <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif" alt="" class="prodImage">
                                {{--@endforeach--}}
                                <h4 class="prodName">{{ $product->name }}</h4>
                                <div class="price">
                                    @if($product->discount)
                                        <span class="discountPrice">
                                                {{ $product->price }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                            </span>
                                        <span class="discount">
                                                {{ $product->discount }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                            </span>
                                    @else
                                        <span class="price">
                                                {{ $product->price }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                            </span>
                                    @endif
                                </div>
                            </a>
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-success is-smaller" style="cursor: help;" title="Product Status">
                                      <span class="icon is-small">
                                        <i class="mdi mdi-check"></i>
                                      </span>
                                    </a>
                                </p>
                                <p class="control">
                                    <span class="button is-light is-smaller" style="cursor: help;" title="Product sold">
                                        <span>Sold</span>
                                    </span>
                                </p>
                                <p class="control">
                                    @if($product->sold)
                                        <a class="active button is-success is-smaller" title="Sold">
                                          <span>
                                              YES
                                          </span>
                                        </a>
                                    @else
                                        <a class="active button is-danger is-smaller" title="Not Sold">
                                          <span>
                                              NO
                                          </span>
                                        </a>
                                    @endif
                                </p>
                                <form method="POST" action="{!! route('products.product.destroy', $product->id) !!}" accept-charset="UTF-8" style="display: inline-flex;">
                                    <input name="_method" value="DELETE" type="hidden">
                                    {{ csrf_field() }}
                                    <p class="control">
                                        <a href="{{route('products.product.show', $product->id)}}" class="button is-info is-smaller" title="Show The Product">
                                          <span class="icon is-small">
                                            <i class="mdi mdi-eye-settings-outline"></i>
                                          </span>
                                        </a>
                                    </p>
                                    <p class="control">
                                        <a href="{{ route('products.product.edit', $product->id ) }}" class="button is-primary is-smaller" title="Edit product">
                                          <span class="icon is-small">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                          </span>
                                        </a>
                                    </p>
                                    <p class="control">
                                        <button type="submit" class="button is-danger is-smaller" title="Delete the product" onclick="return confirm(&quot;Delete Product?&quot;)">
                                          <span class="icon is-small">
                                            <i class="mdi mdi-delete-empty"></i>
                                          </span>
                                        </button>
                                    </p>
                                </form>
                            </div>

                        </div>

                    @endforeach

                </div>
            </div>

            <div class="">
                {!! $userProducts->render() !!}
            </div>

        @endif
    </div>
    @endrole
    @role('admin', true)
    <div class="panel panel-primary m-t-20">

        <div class="panel-body">
            <h2 class="lead">
                {{ trans('auth.loggedIn') }}
            </h2>
            <p>
                <em>Thank you</em> for checking this project out. <strong>Please remember to star it!</strong>
            </p>

            <p>
                <iframe src="https://ghbtns.com/github-btn.html?user=jeremykenedy&repo=laravel-auth&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px" style="margin: 0px 0 -3px .5em;"></iframe>
            </p>

            <p>
                This page route is protected by <code>activated</code> middleware. Only accounts with activated emails are able pass this middleware.
            </p>
            <p>
                <small>
                    Users registered via Social providers are by default activated.
                </small>
            </p>

            <hr>

            <h4>
                You have
                <b-tag type="is-info" rounded>Admin Access</b-tag>
            </h4>

            <hr>

            <h6 class="title is-6">You have access to {{ $levelAmount }}:
                @level(5)
                <b-tag type="is-primary" rounded class="m-l-10">5</b-tag>
                @endlevel

                @level(4)
                <b-tag type="is-info" rounded>4</b-tag>
                @endlevel

                @level(3)
                <b-tag type="is-success" rounded>3</b-tag>
                @endlevel

                @level(2)
                <b-tag type="is-danger" rounded>2</b-tag>
                @endlevel

                @level(1)
                <b-tag type="is-default" rounded>1</b-tag>
                @endlevel
            </h6>
            <hr>

            <h6 class="title is-6">
                You have permissions:
                @permission('view.users')
                <b-tag type="is-info" rounded>
                    {{ trans('permsandroles.permissionView') }}
                </b-tag>
                @endpermission

                @permission('create.users')
                <b-tag type="is-success" rounded>
                    {{ trans('permsandroles.permissionCreate') }}
                </b-tag>
                @endpermission

                @permission('edit.users')
                <b-tag type="is-primary" rounded>
                    {{ trans('permsandroles.permissionEdit') }}
                </b-tag>
                @endpermission

                @permission('delete.users')
                <b-tag type="is-danger" rounded>
                    {{ trans('permsandroles.permissionDelete') }}
                </b-tag>
                @endpermission

            </h6>

        </div>
    </div>
</div>
@endrole