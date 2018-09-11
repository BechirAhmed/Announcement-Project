@extends('layouts.public')

@section('template_title')
    {{ $product->name }}
@endsection

@section('template_linked_css')
    <style>
        @media (min-width:1200px){
            .ResSlid0 .item {
                width: 18%!important;
            }
        }

        .resCarousel-inner .item {
            /*border: 4px solid #eee;*/
            /*vertical-align: top;*/
            text-align: center;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }

        .resCarousel-inner .item .tile a,
        .banner .item {
            display: inline-grid;
            width: 100%;
            min-height: 150px;
            height: 150px;
            text-align: center;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }

        .resCarousel-inner .item h1 {
            vertical-align: middle;
            color: #000;
        }

        .banner .item div {
            /*background: url('images/fdaf282558d1827bccf942e74d60fe658d97fc9f.png') center top no-repeat;*/
            /*background-size: cover;*/
            min-height: 550px;
        }

        .item .tile div {
            /*background: url('images/fdaf282558d1827bccf942e74d60fe658d97fc9f.png') center center no-repeat;*/
            /*background-size: cover;*/
            height: 200px;
            color: white;
        }
        .item div img {
            height: 50px;
            max-width: 100%;
            margin: auto;
        }
        .thumbnail.selected{
            cursor: initial;
        }
        span.button {
            width: 25px;
            height: 25px;
            border-radius: 25px;
        }
        .relatedPostsSlider {
            margin-top: 50px;
        }
        .relatedImg {
            height: 100px;
            border-top-right-radius: 7px;
            border-top-left-radius: 7px;
        }
        a span {
            color: #000;
        }
        .owl-carousel{
            display: inline-flex;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="columns m-t-20">
        <div class="column" style="border-right: 1px solid #ccc;">
            <div class="image-gallery">
                <main class="primary" style="background-image: url('@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif');"></main>
                <aside class="thumbnails" style="width: 550px; @if($product->photos->count() > 5) overflow-x: scroll; @endif">
                    @php
                        $nb = 0;
                    @endphp
                    @foreach($product->photos as $photo)
                        <a class="{{ $nb == 0 ? 'selected ' : '' }}thumbnail" data-big="{{asset('images/'.$photo->image_name) }}">
                            <div class="thumbnail-image" style="background-image: url({{asset('images/'.$photo->resized_name) }})"></div>
                        </a>
                        @php
                            $nb++;
                        @endphp
                    @endforeach
                </aside>
            </div>
        </div>
        <div class="column text-left">
            <h3 class="title is-3 text-left">
                {{ $product->name }}
            </h3>
            <p class="prodDesc">
                {{ $product->description }}
            </p>
            <div class="colors" style="margin: 20px 0">
                <h4 class="title is-4">
                    Colors
                </h4>
                <span class="button is-primary"></span>
                <span class="button is-info"></span>
                <span class="button is-success"></span>
                <span class="button is-danger"></span>
                <span class="button is-warning"></span>
                <span class="button has-background-green"></span>
                <span class="button has-background-gold"></span>
            </div>
            <div class="prodPrice" style="margin-top: 20px">
                @if($product->discount)
                    <table class="table">
                        <thead>
                            <th>Real Price</th>
                            <th>Discount Price</th>
                        </thead>
                        <tbody>
                            <td>
                                <span class="discountPrice">
                                        {{ $product->price }}
                                    @foreach($product->unitRelateds as $unitRelated)
                                        {{ $unitRelated->name }}
                                    @endforeach
                                </span>
                            </td>
                            <td>
                                <span class="discount" style="color: #000">
                                        {{ $product->discount }}
                                    @foreach($product->unitRelateds as $unitRelated)
                                        {{ $unitRelated->name }}
                                    @endforeach
                                </span>
                            </td>
                        </tbody>
                    </table>
                @else
                    <h4 class="title is-4">
                        Price
                    </h4>
                    <span class="price">
                            {{ $product->price }}
                        @foreach($product->unitRelateds as $unitRelated)
                            {{ $unitRelated->name }}
                        @endforeach
                        </span>
                @endif
            </div>
            <h4 class="contctInfo title is-4">
                Contact info
            </h4>
            <table class="table">
                <tbody>
                <tr>
                    <th>
                        @if($product->user->user_type == 'business')
                            Store
                        @else
                            User
                        @endif
                    </th>
                    <td>
                        <a href="{{route('store', ['userName' => $product->user->name])}}" class="link-noUnderline">
                            {{ optional($product->user)->full_name }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Tel</th>
                    <td>{{ optional($product->user)->phone_number }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ optional($product->user)->email }}</td>
                </tr>
                <tr>
                    <th>Adress</th>
                    <td>{{ optional($product->user)->adresse }}</td>
                </tr>
                <tr>
                    <th>Region</th>
                    <td>
                        @foreach($product->regions as $region)
                            {{$region->name}}
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <h3 class="title is-3">Relateds Products</h3>
    @if($relatedProducts->count() == 0)
        <p>There is no related products!</p>
    @else
        <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
            <div class="resCarousel-inner">
                @foreach($relatedProducts as $product)
                        <div class="item">
                            <div class="tile">
                                @foreach($product->subCategories as $subCategory)
                                    @foreach($subCategory->categories as $category)
                                        <a href="{{ route('product', ['catSlug' => $category->slug, 'subCatSlug' => $subCategory->slug, 'slug' => $product->slug, 'sku' => $product->sku, 'id' => $product->id, ]) }}" class="link-noUnderline hvr-shadow">
                                            @endforeach
                                            @endforeach

                                            {{--                                @if(count($product->photos))--}}
                                            <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif">
                                            {{--@else--}}
                                            {{--                                    <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">--}}
                                            {{--@endif--}}
                                            <h1>{{ $product->name }}</h1>
                                            @if($product->discount)
                                                <span>
                                        <span class="discountPrice">
                                                {{ $product->price }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                    </span>
                                    <span class="discount" style="color: #000">
                                                {{ $product->discount }}
                                        @foreach($product->unitRelateds as $unitRelated)
                                            {{ $unitRelated->name }}
                                        @endforeach
                                    </span>
                                    </span>
                                            @else
                                                <span class="price">
                                                {{ $product->price }}
                                                    @foreach($product->unitRelateds as $unitRelated)
                                                        {{ $unitRelated->name }}
                                                    @endforeach
                                    </span>
                                            @endif
                                        </a>
                            </div>
                        </div>
                        {{--@include('partials._includes.productPreview')--}}
                @endforeach
            </div>
            <button class="btn leftRs">
                <i class="fa fa-caret-left"></i>
            </button>
            <button class="btn rightRs">
                <i class="fa fa-caret-right"></i>
            </button>
        </div>
    @endif
<div class="m-t-50"></div>
    <h3 class="title is-3">Products By <a href="{{route('store', ['userName' => $user->name])}}" class="link-noUnderline">{{$user->full_name}}</a></h3>
    <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
        <div class="resCarousel-inner">

            @foreach($currentUserProducts as $product)
                <div class="item">
                    <div class="tile">
                        @foreach($product->subCategories as $subCategory)
                            @foreach($subCategory->categories as $category)
                                <a href="{{ route('product', ['catSlug' => $category->slug, 'subCatSlug' => $subCategory->slug, 'slug' => $product->slug, 'sku' => $product->sku, 'id' => $product->id, ]) }}" class="link-noUnderline hvr-shadow">
                                    @endforeach
                                    @endforeach

                                    {{--                                @if(count($product->photos))--}}
                                    <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif">
                                    {{--@else--}}
                                    {{--                                    <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">--}}
                                    {{--@endif--}}
                                    <h1>{{ $product->name }}</h1>
                                    @if($product->discount)
                                        <span>
                                    <span class="discountPrice">
                                            {{ $product->price }}
                                        @foreach($product->unitRelateds as $unitRelated)
                                            {{ $unitRelated->name }}
                                        @endforeach
                                </span>
                                <span class="discount" style="color: #000">
                                            {{ $product->discount }}
                                    @foreach($product->unitRelateds as $unitRelated)
                                        {{ $unitRelated->name }}
                                    @endforeach
                                </span>
                                </span>
                                    @else
                                        <span class="price">
                                            {{ $product->price }}
                                            @foreach($product->unitRelateds as $unitRelated)
                                                {{ $unitRelated->name }}
                                            @endforeach
                                </span>
                                    @endif
                                </a>
                    </div>
                </div>
                {{--@include('partials._includes.productPreview')--}}
            @endforeach

        </div>
        <button class="btn leftRs">
            <i class="fa fa-caret-left"></i>
        </button>
        <button class="btn rightRs">
            <i class="fa fa-caret-right"></i>
        </button>
    </div>
</div>

@endsection

@section('footer_scripts')
    <script>
        $(document).ready(function () {

            $(".owl-carousel").owlCarousel({
                loop:false,
                margin:10,
                nav:true,
                responsiveClass: true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:6
                    },
                    1000:{
                        items:9
                    }
                }
            });

            $('.thumbnail').on('click', function() {
                var clicked = $(this);
                var newSelection = clicked.data('big');
                var $img = $('.primary').css("background-image","url(" + newSelection + ")");
                clicked.parent().find('.thumbnail').removeClass('selected');
                clicked.addClass('selected');
                $('.primary').empty().append($img.hide().fadeIn('slow'));
            });
        });
    </script>
@endsection