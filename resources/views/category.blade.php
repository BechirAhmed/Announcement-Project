@extends('layouts.public')

@section('template_title')
    {{ $category->name }}
@endsection

@section('template_linked_css')
    <style>
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
                @foreach($category->subCategories as $subCategory)
                    @foreach($subCategory->products->where('is_active', true) as $product)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $nb }}" class="@if($nb == 0) active @endif"></li>
                        <?php
                        $nb++;
                        ?>
                    @endforeach
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">

                @foreach($category->subCategories as $subCategory)
                    @foreach($subCategory->products->where('is_active', true) as $product)
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
                                Section 3
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            100 1000
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            New products
            <div class="container p8">

                <h3 class="title is-3">NEWEST PRODUCTS</h3>

                <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
                    <div class="resCarousel-inner">

                        @foreach($category->subCategories as $subCategory)
                            @foreach($subCategory->products->where('is_active', true) as $product)
                            <div class="item">
                                <a href="#" class="link-noUnderline hvrShadow">
                                <div class="tile">
                                    <div>
                                                                        @if(count($product->photos))
                                        <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif">
                                        @else
                                                                            <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">
                                        @endif
                                        <h1>{{ $product->name }}</h1>
                                        @foreach($product->subCategories as $subCategory)
                                            <a href="{{ route('product', ['catSlug' => $category->slug, 'subCatSlug' => $subCategory->slug, 'slug' => $product->slug, 'sku' => $product->sku, 'id' => $product->id, ]) }}">
                                            @endforeach
                                            Quick view
                                        </a>
                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach
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

            Most popular


            <div class="container p8">

                <h3 class="title is-3">MOST POPULAR PRODUCTS</h3>

                <div class="resCarousel" data-items="2-4-4-4" data-interval="2000" data-slide="1" data-animator="lazy">
                    <div class="resCarousel-inner">

                        @foreach($category->subCategories as $subCategory)
                            @foreach($subCategory->products->where('is_active', true) as $product)
                            <div class="item">
                                <a href="#" class="link-noUnderline hvrShadow">
                                <div class="tile">
                                    <div>
                                                                        @if(count($product->photos))
                                        <img src="@if(count($product->photos)) {{asset('images/'.$product->photos[0]->resized_name) }} @else  {{ asset('images/slide2.png') }}@endif">
                                        @else
                                                                            <img src="{{ asset('images/82881dcd021dcce989acd64f97977b67b375dbb7.png') }}" alt="">
                                        @endif
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
                                </a>
                            </div>
                        @endforeach
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

    </script>
@endsection