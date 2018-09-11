@extends('layouts.public')

@section('template_title')
    {{ $subCategory->name }}
@endsection

@section('template_linked_css')
    <style>
        @supports (--css: variables) {
            input[type="range"].multirange {
                padding: 0;
                margin: 0;
                display: inline-block;
                vertical-align: top;
            }

            input[type="range"].multirange.original {
                position: absolute;
            }

            input[type="range"].multirange.original::-webkit-slider-thumb {
                position: relative;
                z-index: 2;
            }

            input[type="range"].multirange.original::-moz-range-thumb {
                transform: scale(1); /* FF doesn't apply position it seems */
                z-index: 1;
            }

            input[type="range"].multirange::-moz-range-track {
                border-color: transparent; /* needed to switch FF to "styleable" control */
            }

            input[type="range"].multirange.ghost {
                position: relative;
                background: var(--track-background);
                --track-background: linear-gradient(to right,
                transparent var(--low), var(--range-color) 0,
                var(--range-color) var(--high), transparent 0
                ) no-repeat 0 45% / 100% 40%;
                --range-color: hsl(190, 80%, 40%);
            }

            input[type="range"].multirange.ghost::-webkit-slider-runnable-track {
                background: var(--track-background);
            }

            input[type="range"].multirange.ghost::-moz-range-track {
                background: var(--track-background);
            }

        }

        span.button {
            width: 25px;
            height: 25px;
            border-radius: 25px;
        }
        a:hover,a:focus{
            text-decoration: none;
            outline: none;
        }
        #accordion .panel{
            border: none;
            border-radius: 0;
            box-shadow: none;
            margin-bottom: 15px;
            position: relative;
        }
        #accordion .panel:before{
            content: "";
            display: block;
            width: 1px;
            height: 100%;
            border: 1px dashed #6e8898;
            position: absolute;
            top: 25px;
            left: 18px;
        }
        #accordion .panel:last-child:before{ display: none; }
        #accordion .panel-heading{
            padding: 0;
            border: none;
            border-radius: 0;
            position: relative;
        }
        #accordion .panel-title a{
            display: block;
            padding: 10px 30px 10px 60px;
            margin: 0;
            background: #fff;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #1d3557;
            border-radius: 0;
            position: relative;
        }
        #accordion .panel-title a:before,
        #accordion .panel-title a.collapsed:before{
            content: "\f107";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            width: 40px;
            height: 100%;
            line-height: 40px;
            background: #8a8ac3;
            border: 1px solid #8a8ac3;
            border-radius: 3px;
            font-size: 17px;
            color: #fff;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            transition: all 0.3s ease 0s;
        }
        #accordion .panel-title a.collapsed:before{
            content: "\f105";
            background: #fff;
            border: 1px solid #6e8898;
            color: #000;
        }
        #accordion .panel-body{
            padding: 10px 30px 10px 30px;
            margin-left: 40px;
            background: #fff;
            border-top: none;
            font-size: 15px;
            color: #6f6f6f;
            line-height: 28px;
            letter-spacing: 1px;
        }
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

        .resCarousel-inner .item .tile div,
        .banner .item div {
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
    </style>
@endsection

@section('content')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $nb = 0;
                $i = 0;
                ?>
                @foreach($products as $product )
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $nb }}" class="@if($nb == 0) active @endif"></li>
                    <?php
                    $nb++;
                    ?>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach( $products as $product )
                    <div class="carousel-item @if($i == 0) active @endif" style="background-image: url(@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif)">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>{{ $product->name }}</h3>
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
                    </div>
                    <?php
                    $i++;
                    ?>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>

    <div class="columns m-t-20">
        <div class="column is-one-fifth m-l-10">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <nav class="breadcrumb" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="{{ route('category', ['catSlug' => $category->slug]) }}">{{ $category->name }}</a></li>
                                <li class="is-active"><a href="#" aria-current="page">{{ $subCategory->name }}</a></li>
                            </ul>
                        </nav>
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{ $category->name }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <aside class="menu m-l-5">
                                <ul class="menu-list">
                                    @foreach($category->subCategories as $subCategory)
                                        <li>
                                            <a href="{{ route('sub_category', ['catSlug' =>  $category->slug, 'slug' => $subCategory->slug]) }}" class="link-noUnderline">
                                                {{ $subCategory->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Colour
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <span class="button is-primary"></span>
                            <span class="button is-info"></span>
                            <span class="button is-success"></span>
                            <span class="button is-danger"></span>
                            <span class="button is-warning"></span>
                            <span class="button has-background-green"></span>
                            <span class="button has-background-gold"></span>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Price
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <input type="range" multiple value="10,80" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container p8">

                <h3 class="title is-3">NEWEST PRODUCTS</h3>

                <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
                    <div class="resCarousel-inner">

                        @foreach($products as $product)
                            <div class="item">
                                {{--<a href="#" class="link-noUnderline hvrShadow">--}}
                                <div class="tile">
                                    <div>
                                        {{--                                @if(count($product->photos))--}}
                                        <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif">
                                        {{--@else--}}
                                        {{--                                    <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">--}}
                                        {{--@endif--}}
                                        <h1>{{ $product->name }}</h1>
                                        <a data-toggle="modal"
                                           data-target="#exampleModal{{$product->id}}"
                                           data-backdrop="static"
                                           data-keyboard="false"
                                           title="Show Product"
                                           class="link-noUnderline qviewBtn">
                                            Quick view
                                        </a>
                                    </div>
                                </div>
                            </div>
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

            {{--most popular products--}}


            <div class="container p8">

                <h3 class="title is-3">MOST POPULAR PRODUCTS</h3>

                <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
                    <div class="resCarousel-inner">

                        @foreach($products as $product)
                            <div class="item">
                                {{--<a href="#" class="link-noUnderline hvrShadow">--}}
                                <div class="tile">
                                    <div>
                                        {{--                                @if(count($product->photos))--}}
                                        <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif">
                                        {{--@else--}}
                                        {{--                                    <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">--}}
                                        {{--@endif--}}
                                        <h1>{{ $product->name }}</h1>
                                        <a data-toggle="modal"
                                           data-target="#exampleModal{{$product->id}}"
                                           data-backdrop="static"
                                           data-keyboard="false"
                                           title="Show Product"
                                           class="link-noUnderline qviewBtn">
                                            Quick view
                                        </a>
                                    </div>
                                </div>
                            </div>
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
        </div>
    </div>



@endsection

@section('footer_scripts')
    <script>
        (function() {
            "use strict";

            var supportsMultiple = self.HTMLInputElement && "valueLow" in HTMLInputElement.prototype;

            var descriptor = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, "value");

            self.multirange = function(input) {
                if (supportsMultiple || input.classList.contains("multirange")) {
                    return;
                }

                var value = input.getAttribute("value");
                var values = value === null ? [] : value.split(",");
                var min = +(input.min || 0);
                var max = +(input.max || 100);
                var ghost = input.cloneNode();

                input.classList.add("multirange", "original");
                ghost.classList.add("multirange", "ghost");

                input.value = values[0] || min + (max - min) / 2;
                ghost.value = values[1] || min + (max - min) / 2;

                input.parentNode.insertBefore(ghost, input.nextSibling);

                Object.defineProperty(input, "originalValue", descriptor.get ? descriptor : {
                    // Fuck you Safari >:(
                    get: function() { return this.value; },
                    set: function(v) { this.value = v; }
                });

                Object.defineProperties(input, {
                    valueLow: {
                        get: function() { return Math.min(this.originalValue, ghost.value); },
                        set: function(v) { this.originalValue = v; },
                        enumerable: true
                    },
                    valueHigh: {
                        get: function() { return Math.max(this.originalValue, ghost.value); },
                        set: function(v) { ghost.value = v; },
                        enumerable: true
                    }
                });

                if (descriptor.get) {
                    // Again, fuck you Safari
                    Object.defineProperty(input, "value", {
                        get: function() { return this.valueLow + "," + this.valueHigh; },
                        set: function(v) {
                            var values = v.split(",");
                            this.valueLow = values[0];
                            this.valueHigh = values[1];
                            update();
                        },
                        enumerable: true
                    });
                }

                if (typeof input.oninput === "function") {
                    ghost.oninput = input.oninput.bind(input);
                }

                function update() {
                    ghost.style.setProperty("--low", 100 * ((input.valueLow - min) / (max - min)) + 1 + "%");
                    ghost.style.setProperty("--high", 100 * ((input.valueHigh - min) / (max - min)) - 1 + "%");
                }

                input.addEventListener("input", update);
                ghost.addEventListener("input", update);

                update();
            }

            multirange.init = function() {
                [].slice.call(document.querySelectorAll("input[type=range][multiple]:not(.multirange)")).forEach(multirange);
            }

            if (document.readyState == "loading") {
                document.addEventListener("DOMContentLoaded", multirange.init);
            }
            else {
                multirange.init();
            }

        })();

    </script>
@endsection